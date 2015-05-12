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
				"*" => "default"
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
						"*" => "create-equipment-edit",
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
			case "review":
				
				break;
			case "create":
				Document::redirect(APPDIR."/repair/create/".($datasource->repair_new(array("userid" => Session::userid()))));
				break;
			case "create-show":
				if ($args->containsKey("building", "floor", "room", "duedate", "priority"))
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
						"repairid" => $matchvars["repairid"],
						"location" => sprintf("%s.%s.%s", $args->building, $args->floor, $args->room),
						"duedate" => $args->duedate,
						"completion" => 0,
						"priority" => $args->priority
					));

					//throw new Exception(sprintf("%s.%s.%s", $args->building, $args->floor, $args->room));
				}
				
				Bean::repairid($matchvars["repairid"]);
				Bean::repair(new ArrayList($datasource->repair_get(array("repairid" => $matchvars["repairid"]))));
				Bean::back("/repair");
				Bean::repairusername($datasource->user_name(array("userid" => Bean::repair()->userid)));
				Document::body(function() { Document::page("repair-create"); });
				Document::build();
				break;
			case "create-equipment":
				$repairid = $matchvars["repairid"];
				Bean::repairid($repairid);
				Bean::equipment($datasource->equipment_list(array("repairid" => $repairid)));
				Bean::back("/repair/create/".$repairid);
				Document::body(function() { Document::page("equipment"); });
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
