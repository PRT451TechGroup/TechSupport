<?php
// spaghetti code needs to be cleaned up to same standard as LoanApplet
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


		$_PAGE = array("APPLET_ROOT" => APPDIR.$appletRoot, "appletRoot" => $appletRoot);
		$repairs = new \Data\Table\Repairs($datasource->open_connection());

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
			Document::body(function() use($_PAGE) { Document::page("repair/review", $_PAGE); });
			Document::build();
		}
		// create
		elseif ($path === "create")
		{
			$repairid = $repairs->insertRepair(Session::userid());
			Document::redirect($_PAGE["APPLET_ROOT"]."/$repairid");
		}
		// review-cat
		elseif (preg_match('#^review/(?P<completion>\d+)$#', $path, $matches))
		{
			$completion = $matches["completion"];
			
			$_PAGE["completion"] = $completion;
			$_PAGE["repairs"] = $repairs->selectRepairsByCompletion($completion);
			$_PAGE["back"] = "$appletRoot/review";
			Document::body(function() use($_PAGE) { Document::page("repair/review-cat", $_PAGE); });
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

				$repairs->updateRepair($repairid, $repair);

				Document::redirect($_PAGE["APPLET_ROOT"]."/review/".$args["completion"]);
			}
			else
			{
				$repair = $repairs->selectRepairById($repairid);
				$completion = $repair["completion"];
				//throw new Exception(print_r($repair, true));
				
				$_PAGE["repairid"] = $repairid;
				$_PAGE["completion"] = $completion;
				$_PAGE["repair"] = $repair;
				
				$_PAGE["back"] = "/repair/review/$completion";
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
			Document::redirect($_PAGE["APPLET_ROOT"]."/review/" . $repair["completion"]);
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
