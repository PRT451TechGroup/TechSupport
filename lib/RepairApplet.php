<?php
class RepairApplet
{
	private $app;
	public function __construct($app)
	{
		$this->app = $app;
	}
	public function start()
	{
		if (!Session::verify())
		{
			Document::redirect(APPDIR."/");
			return;
		}
		
		$path = $this->app->path()->remainder();
		$args = $this->app->arguments();
		$datasource = $this->app->datasource();

		$appletRoot = "/repair";

		if (!isset($_SESSION["repairmode"]))
		{
			$_SESSION["repairmode"] = "review";
		}

		$_PAGE = array("APPLET_ROOT" => APPDIR.$appletRoot, "appletRoot" => $appletRoot);
		$repairs = new \Data\Table\Repairs($datasource->open_connection());

		$previousView = function($completion = null) use($appletRoot, $repairs)
		{
			if ($_SESSION["repairmode"] == "review")
			{
				if (intval($completion) >= 0)
					return "$appletRoot/review/$completion";
				else
					return "$appletRoot";
			}
			elseif ($_SESSION["repairmode"] == "calendar")
			{
				return "$appletRoot/calendar";
			}
		};

		// index
		if (strlen($path) === 0)
		{
			$_PAGE["back"] = "/";
			Document::body(function() use($_PAGE) { Document::page("repair/index", $_PAGE); });
			Document::build();
		}
		// review
		elseif ($path === "review")
		{
			$_PAGE["back"] = "/repair";
			$_PAGE["completion"] = $datasource->repair_completion();
			$_SESSION["repairmode"] = "review";
			Document::body(function() use($_PAGE) { Document::page("repair/review", $_PAGE); });
			Document::build();
		}
		// create
		elseif ($path === "create")
		{
			$repairid = $repairs->insertRepair(Session::userid());
			Document::redirect($_PAGE["APPLET_ROOT"]."/$repairid");
		}
		// repair-calendar
		elseif ($path === "calendar")
		{
			$_SESSION["repairmode"] = "calendar";
			$_PAGE["back"] = "/repair";
			$_PAGE["repairs"] = $repairs->selectRepairs();
			Document::body(function() use($_PAGE) { Document::page("repair/calendar", $_PAGE); });
			Document::build();
		}
		// review-cat
		elseif (preg_match('#^review/(?P<completion>\d+)$#', $path, $matches))
		{
			$_SESSION["repairmode"] = "review";
			$completion = $matches["completion"];
			
			$_PAGE["completion"] = $completion;
			$_PAGE["repairs"] = $repairs->selectRepairsByCompletion($completion);
			$_PAGE["back"] = "$appletRoot/review";
			Document::body(function() use($_PAGE) { Document::page("repair/review-cat", $_PAGE); });
			Document::build();
		}
		// repair-view
		elseif (preg_match('#^view/(?P<repairid>\d+)$#', $path, $matches))
		{
			$repairid = $matches["repairid"];
			$repair = $repairs->selectRepairById($repairid);

			
			$_PAGE["repairid"] = $repairid;
			$_PAGE["repair"] = $repair;
			$_PAGE["back"] = $previousView($repair["completion"]);
			$_PAGE["equipment"] = $repairs->selectEquipmentByRepairId($repairid);

			Document::body(function() use($_PAGE) { Document::page("repair/view", $_PAGE); });
			Document::build();
		}
		// repair
		else if (preg_match("#^(?P<repairid>\d+)$#", $path, $matches))
		{
			$repairid = $matches["repairid"];
			if (isset($args["__method"]) && $args["__method"] === "update")
			{
				$repair = array();
				$repair["name"] = $args["name"];
				$repair["complainer"] = $args["complainer"];
				$repair["location"] = (string)(new FSLocation($args["precinct"], $args["building"], $args["floor"], $args["room"]));
				$repair["duedate"] = (string)(new FSDateTime($args["year"], $args["month"], $args["day"], $args["hour"], $args["minute"]));
				$repair["completion"] = $args["completion"];
				$repair["priority"] = $args["priority"];
				$ur = null;
				if (isset($_GET["equipmentcount"]))
					$ur = array("completion");

				$repairs->updateRepair($repairid, $repair, $ur);

				//Document::redirect($_PAGE["APPLET_ROOT"]."/review/".$args["completion"]);
				Document::redirect($_PAGE["APPLET_ROOT"]."/view/$repairid");
			}
			else
			{
				$repair = $repairs->selectRepairById($repairid);
				$completion = $repair["completion"];
				//throw new Exception(print_r($repair, true));
				
				$_PAGE["repairid"] = $repairid;
				$_PAGE["completion"] = $completion;
				$_PAGE["repair"] = $repair;
				
				//$_PAGE["back"] = "/repair/review/$completion";
				$_PAGE["back"] = "$appletRoot/view/$repairid";
				$_PAGE["repairusername"] = $datasource->user_name(array("userid" => $repair["userid"]));
				Document::body(function() use($_PAGE) { Document::page("repair/edit", $_PAGE); });
				Document::build();
			}
		}
		// repair-delete
		elseif (preg_match('#^(?P<repairid>\d+)/delete$#', $path, $matches))
		{
			$repairid = $matches["repairid"];
			$repair = $repairs->selectRepairById($repairid);
			$repairs->deleteRepairById($repairid);
			Document::redirect($_PAGE["APPLET_ROOT"]."/review" . $repair["completion"]);
		}
		// repair-equipment-delete
		elseif (preg_match('#^(?P<repairid>\d+)/equipment/(?P<equipmentid>\d+)/delete$#', $path, $matches))
		{
			$repairid = $matches["repairid"];
			$equipmentid = $matches["equipmentid"];
			$repairs->deleteEquipmentById($equipmentid);
			Document::redirect($_PAGE["APPLET_ROOT"]."/$repairid/equipment");
		}
		// repair-equipment
		elseif (preg_match("#^(?P<repairid>\d+)/equipment$#", $path, $matches))
		{
			$repairid = $matches["repairid"];
			if (isset($args["__method"]))
			{
				switch($args["__method"])
				{
					case "insert":
						$equipment = array("equipmentname" => $args["equipmentname"], "assetno" => $args["assetno"], "description" => $args["description"]);
						$repairs->insertEquipment($repairid, $equipment);
						break;
					case "update":
						$equipment = array("equipmentname" => $args["equipmentname"], "assetno" => $args["assetno"], "description" => $args["description"]);
						$equipmentid = $args["equipmentid"];
						$repairs->updateEquipment($equipmentid, $equipment);
						break;
				}
			}

			$_PAGE["repairid"] = $repairid;
			$_PAGE["equipment"] = $repairs->selectEquipmentByRepairId($repairid);
			$_PAGE["back"] = "$appletRoot/$repairid";

			Document::body(function() use($_PAGE) { Document::page("repair/equipment", $_PAGE); });
			Document::build();
		}
		// repair-equipment-create
		elseif (preg_match("#^(?P<repairid>\d+)/equipment/create$#", $path, $matches))
		{
			$repairid = $matches["repairid"];

			$_PAGE["repairid"] = $repairid;
			$_PAGE["back"] = "$appletRoot/$repairid/equipment";

			Document::body(function() use($_PAGE) { Document::page("repair/equipment/create", $_PAGE); });
			Document::build();
		}
		// repair-equipment
		elseif (preg_match("#^(?P<repairid>\d+)/equipment/(?P<equipmentid>\d+)$#", $path, $matches))
		{
			$repairid = $matches["repairid"];
			$equipmentid = $matches["equipmentid"];

			$_PAGE["repairid"] = $repairid;
			$_PAGE["equipmentid"] = $equipmentid;
			$_PAGE["back"] = "$appletRoot/$repairid/equipment";
			$_PAGE["equipment"] = $repairs->selectEquipmentById($equipmentid);

			Document::body(function() use($_PAGE) { Document::page("repair/equipment/edit", $_PAGE); });
			Document::build();
		}
		else
		{
			Document::redirect($_PAGE["APPLET_ROOT"]);
		}
	}
	public static function callback($app)
	{
		$a = new RepairApplet($app);
		return $a->start();
	}
}
?>
