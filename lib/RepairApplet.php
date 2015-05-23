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
		
		$path = $this->app->path();
		$args = new ArrayList($this->app->arguments());
		$matchvars = array();
		$datasource = $this->app->datasource();
		$match = $path->match(array
		(
			"." => "repair",
			"*" => "default",
			"review" => array
			(
				"." => "review",
				"/" => "completion",
				"*" => array
				(
					"." => "review-cat",
					"/" => "repairid",
					"*" => array
					(
						"." => "review-repair",
						"delete" => "repair-delete",
						"equipment" => array
						(
							"." => "review-equipment",
							"/" => "equipmentid",
							"create" => "review-equipment-create",
							"*" => array
							(
								"." => "review-equipment-edit",
								"delete" => "review-equipment-delete"
							)
						)
					)
				)
			),
			"create" => array
			(
				"." => "create",
				"/" => "repairid",
				"*" => array
				(
					"." => "create-show",
					"equipment" => array
					(
						"." => "create-equipment",
						"create" => "create-equipment-create",
						"/" => "equipmentid",
						"*" => array
						(
							"." => "create-equipment-edit",
							"delete" => "create-equipment-delete"
						)
					)
				)
			)
			
		), $matchvars);

		$_PAGE = array();
		switch($match)
		{
			case "repair":
				$_PAGE["back"] = "/";
				Document::body(function() use($_PAGE) { Document::page("repair", $_PAGE); });
				Document::build();
				break;
			case "repair-delete":
				$completion = $matchvars["completion"];
				$repairid = $matchvars["repairid"];
				$datasource->repair_delete(array("repairid" => $repairid));
				Document::redirect(APPDIR."/repair/review/$completion");
				break;
			case "review":
				$_PAGE["back"] = "/repair";
				$_PAGE["completion"] = $datasource->repair_completion();
				Document::body(function() use($_PAGE) { Document::page("repair-review", $_PAGE); });
				Document::build();
				break;
			case "review-repair":
				if ($args->containsKey("name", "complainer", "precinct", "building", "floor", "room", "year", "month", "day", "hour", "minute", "priority", "completion"))
				{
					if (!is_numeric($args->building))
						throw new Exception("building is not numeric");
					if (!is_numeric($args->floor))
						throw new Exception("floor is not numeric");
					if (!is_numeric($args->room))
						throw new Exception("room is not numeric");
					if (!is_numeric($args->priority))
						throw new Exception("priority is not numeric");
					if (!is_numeric($args->completion))
						throw new Exception("completion is not numeric");
					$rv = $datasource->repair_modify(array
					(
						"name" => $args->name,
						"complainer" => $args->complainer,
						"repairid" => $matchvars["repairid"],
						"location" => (string)(new FSLocation($args->precinct, $args->building, $args->floor, $args->room)),
						"duedate" => (string)(new FSDateTime($args->year, $args->month, $args->day, $args->hour, $args->minute)),
						"completion" => $args->completion,
						"priority" => $args->priority
					));
					
					$redirect = true;

				}

				$repairid = $matchvars["repairid"];
				$repair = new ArrayList($datasource->repair_get(array("repairid" => $repairid)));
				$completion = $repair->completion;
				
				if (isset($redirect))
				{
					Document::redirect(APPDIR."/repair/review/$completion");
					break;
				}
				
				$_PAGE["repairid"] = $repairid;
				$_PAGE["completion"] = $completion;
				$_PAGE["repair"] = $repair;
				
				$_PAGE["back"] = "/repair/review/$completion";
				$_PAGE["repairusername"] = $datasource->user_name(array("userid" => $repair->userid));
				Document::body(function() use($_PAGE) { Document::page("repair-edit", $_PAGE); });
				Document::build();
				break;
			case "create":
				Document::redirect(APPDIR."/repair/create/".($datasource->repair_new(array("userid" => Session::userid()))));
				break;
			case "create-show":
				if ($args->containsKey("name", "complainer", "precinct", "building", "floor", "room", "year", "month", "day", "hour", "minute", "priority"))
				{
					if (!is_numeric($args->building))
						throw new Exception("building is not numeric");
					if (!is_numeric($args->floor))
						throw new Exception("floor is not numeric");
					if (!is_numeric($args->room))
						throw new Exception("room is not numeric");
					if (!is_numeric($args->priority))
						throw new Exception("priority is not numeric");

					$rv = $datasource->repair_modify(array
					(
						"name" => $args->name,
						"complainer" => $args->complainer,
						"repairid" => $matchvars["repairid"],
						"location" => (string)(new FSLocation($args->precinct, $args->building, $args->floor, $args->room)),
						"duedate" => (string)(new FSDateTime($args->year, $args->month, $args->day, $args->hour, $args->minute)),
						"completion" => 0,
						"priority" => $args->priority
					));
					
					Document::redirect(APPDIR."/repair");
					break;

				}
				
				$_PAGE["repairid"] = $matchvars["repairid"];
				$_PAGE["repair"] = new ArrayList($datasource->repair_get(array("repairid" => $matchvars["repairid"])));
				$_PAGE["back"] = "/repair";
				$_PAGE["repairusername"] = $datasource->user_name(array("userid" => $_PAGE["repair"]->userid));
				Document::body(function() use($_PAGE) { Document::page("repair-create", $_PAGE); });
				Document::build();
				break;
			case "review-equipment": $completion = $matchvars["completion"];
			case "create-equipment":
				
				$repairid = $matchvars["repairid"];

				if ($args->containsKey("__action"))
				{
					if ($args->__action == "equipment-create" && $args->containsKey("equipmentname", "assetno", "description"))
					{
						$datasource->repairequipment_new(array
						(
							"repairid" => $repairid,
							"equipmentname" => $args->equipmentname,
							"assetno" => $args->assetno,
							"description" => $args->description
						));
					}
					elseif ($args->__action == "equipment-edit" && $args->containsKey("equipmentid", "equipmentname", "assetno", "description"))
					{
						$datasource->repairequipment_modify(array
						(
							"repairid" => $repairid,
							"equipmentid" => $args->equipmentid,
							"equipmentname" => $args->equipmentname,
							"assetno" => $args->assetno,
							"description" => $args->description
						));
					}
				}

				
				$_PAGE["repairid"] = $repairid;
				$_PAGE["equipment"] = $datasource->repairequipment_list(array("repairid" => $repairid));
				$_PAGE["back"] = isset($completion) ? "/repair/review/$completion/$repairid" : "/repair/create/$repairid";
				
				Document::body(function() use($_PAGE) { Document::page("equipment", $_PAGE); });
				Document::build();
				break;
			case "review-equipment-create": $completion = $matchvars["completion"];
			case "create-equipment-create":
				$repairid = $matchvars["repairid"];
				$_PAGE["back"] = isset($completion) ? "/repair/review/$completion/$repairid/equipment" : "/repair/create/$repairid/equipment";

				Document::body(function() use($_PAGE) { Document::page("equipment-create", $_PAGE); });
				Document::build();
				break;
			case "review-equipment-edit": $completion = $matchvars["completion"];
			case "create-equipment-edit":
				$repairid = $matchvars["repairid"];
				$equipmentid = $matchvars["equipmentid"];
				
				$_PAGE["equipmentid"] = $equipmentid;
				$_PAGE["equipment"] = new ArrayList($datasource->repairequipment_get(array("equipmentid" => $equipmentid, "repairid" => $repairid)));
				$_PAGE["back"] = isset($completion) ? "/repair/review/$completion/$repairid/equipment" : "/repair/create/$repairid/equipment";
				
				Document::body(function() use($_PAGE) { Document::page("equipment-edit", $_PAGE); });
				Document::build();
				break;
			case "review-equipment-delete": $completion = $matchvars["completion"];
			case "create-equipment-delete":
				$repairid = $matchvars["repairid"];
				$equipmentid = $matchvars["equipmentid"];

				$datasource->repairequipment_delete(array("equipmentid" => $equipmentid, "repairid" => $repairid));

				if (isset($completion))
					Document::redirect(APPDIR."/repair/review/$completion/$repairid/equipment");
				else
					Document::redirect(APPDIR."/repair/create/$repairid/equipment");
				break;
			case "review-cat":
				$completion = $matchvars["completion"];

				$_PAGE["completion"] = $completion;
				$_PAGE["repairs"] = $datasource->repair_list(array("completion" => $completion));
				$_PAGE["back"] = "/repair/review";
				Document::body(function() use($_PAGE) { Document::page("repair-review-cat", $_PAGE); });
				Document::build();
				break;
			case "default":
				Document::redirect(APPDIR."/repair");
				break;
			default:
				throw new Exception("Unexpected match " . $match);
		}
		
		
		
		
	}
	public static function callback($app)
	{
		$a = new RepairApplet($app);
		return $a->start();
	}
}
?>
