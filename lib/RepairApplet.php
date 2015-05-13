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

		
		switch($match)
		{
			case "repair":
				Bean::back("/");
				Document::body(function() { Document::page("repair"); });
				Document::build();
				break;
			case "repair-delete":
				$completion = $matchvars["completion"];
				$repairid = $matchvars["repairid"];
				$datasource->repair_delete(array("repairid" => $repairid));
				Document::redirect(APPDIR."/repair/review/$completion");
				break;
			case "review":
				Bean::back("/repair");
				Bean::completion($datasource->repair_completion());
				//throw new Exception(print_r(Bean::completion(), true));
				Document::body(function() { Document::page("repair-review"); });
				Document::build();
				break;
			case "review-repair":
				if ($args->containsKey("name", "complainer", "building", "floor", "room", "year", "month", "day", "hour", "minute", "priority", "completion"))
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
						"location" => sprintf("%s.%s.%s", $args->building, $args->floor, $args->room),
						"duedate" => sprintf("%s-%s-%s %s:%s:00", $args->year, $args->month, $args->day, $args->hour, $args->minute),
						"completion" => $args->completion,
						"priority" => $args->priority
					));
					
					$redirect = true;

					//throw new Exception(sprintf("%s.%s.%s", $args->building, $args->floor, $args->room));
				}

				$repairid = $matchvars["repairid"];
				$repair = new ArrayList($datasource->repair_get(array("repairid" => $repairid)));
				$completion = $repair->completion;
				
				if (isset($redirect))
				{
					Document::redirect(APPDIR."/repair/review/$completion");
					break;
				}
				
				Bean::repairid($repairid);
				Bean::completion($completion);
				Bean::repair($repair);
				
				Bean::back("/repair/review/$completion");
				Bean::repairusername($datasource->user_name(array("userid" => $repair->userid)));
				Document::body(function() { Document::page("repair-edit"); });
				Document::build();
				break;
			case "create":
				Document::redirect(APPDIR."/repair/create/".($datasource->repair_new(array("userid" => Session::userid()))));
				break;
			case "create-show":
				if ($args->containsKey("name", "complainer", "building", "floor", "room", "year", "month", "day", "hour", "minute", "priority"))
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
						"location" => sprintf("%s.%s.%s", $args->building, $args->floor, $args->room),
						"duedate" => sprintf("%s-%s-%s %s:%s:00", $args->year, $args->month, $args->day, $args->hour, $args->minute),
						"completion" => 0,
						"priority" => $args->priority
					));
					
					Document::redirect(APPDIR."/repair");
					break;

					//throw new Exception(sprintf("%s.%s.%s", $args->building, $args->floor, $args->room));
				}
				
				Bean::repairid($matchvars["repairid"]);
				Bean::repair(new ArrayList($datasource->repair_get(array("repairid" => $matchvars["repairid"]))));
				Bean::back("/repair");
				Bean::repairusername($datasource->user_name(array("userid" => Bean::repair()->userid)));
				Document::body(function() { Document::page("repair-create"); });
				Document::build();
				break;
			case "review-equipment": $completion = $matchvars["completion"];
			case "create-equipment":
				
				$repairid = $matchvars["repairid"];

				if ($args->containsKey("__action"))
				{
					if ($args->__action == "equipment-create" && $args->containsKey("equipmentname", "assetno", "description"))
					{
						$datasource->equipment_new(array
						(
							"repairid" => $repairid,
							"equipmentname" => $args->equipmentname,
							"assetno" => $args->assetno,
							"description" => $args->description
						));
					}
					elseif ($args->__action == "equipment-edit" && $args->containsKey("equipmentid", "equipmentname", "assetno", "description"))
					{
						$datasource->equipment_modify(array
						(
							"equipmentid" => $args->equipmentid,
							"equipmentname" => $args->equipmentname,
							"assetno" => $args->assetno,
							"description" => $args->description
						));
					}
				}

				
				Bean::repairid($repairid);
				Bean::equipment($datasource->equipment_list(array("repairid" => $repairid)));
				if (isset($completion))
					Bean::back("/repair/review/$completion/$repairid");
				else
					Bean::back("/repair/create/$repairid");
				
				Document::body(function() { Document::page("equipment"); });
				Document::build();
				break;
			case "review-equipment-create": $completion = $matchvars["completion"];
			case "create-equipment-create":
				$repairid = $matchvars["repairid"];

				if (isset($completion))
					Bean::back("/repair/review/$completion/$repairid/equipment");
				else
					Bean::back("/repair/create/$repairid/equipment");
				Document::body(function() { Document::page("equipment-create"); });
				Document::build();
				break;
			case "review-equipment-edit": $completion = $matchvars["completion"];
			case "create-equipment-edit":
				$repairid = $matchvars["repairid"];
				$equipmentid = $matchvars["equipmentid"];
				
				Bean::equipmentid($equipmentid);
				Bean::equipment(new ArrayList($datasource->equipment_get(array("equipmentid" => $equipmentid))));
				if (isset($completion))
					Bean::back("/repair/review/$completion/$repairid/equipment");
				else
					Bean::back("/repair/create/$repairid/equipment");
				Document::body(function() { Document::page("equipment-edit"); });
				Document::build();
				break;
			case "review-equipment-delete": $completion = $matchvars["completion"];
			case "create-equipment-delete":
				$repairid = $matchvars["repairid"];
				$equipmentid = $matchvars["equipmentid"];

				$datasource->equipment_delete(array("equipmentid" => $equipmentid));

				if (isset($completion))
					Document::redirect(APPDIR."/repair/review/$completion/$repairid/equipment");
				else
					Document::redirect(APPDIR."/repair/create/$repairid/equipment");
				break;
			case "review-cat":
				$completion = $matchvars["completion"];

				Bean::completion($completion);
				Bean::repairs($datasource->repair_list(array("completion" => $completion)));
				Bean::back("/repair/review");
				Document::body(function() { Document::page("repair-review-cat"); });
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