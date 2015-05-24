<?php
class LoanApplet
{
	private $app;
	public function __construct($app)
	{
		$this->app = $app;
	}
	public function start()
	{
		// reject guests
		if (!Session::verify())
		{
			Document::redirect(APPDIR."/");
			return;
		}
		
		$path = $this->app->path()->remainder();

		// http post vars
		$args = $this->app->arguments();
		$datasource = $this->app->datasource();

		$appletRoot = "/loan";


		$_PAGE = array("APPLET_ROOT" => APPDIR.$appletRoot, "appletRoot" => $appletRoot);
		$loans = new \Data\Table\Loans($datasource->open_connection());

		// Applet index page
		if (strlen($path) === 0)
		{
			$_PAGE["back"] = "/";
			Document::body(function() use($_PAGE) { Document::page("loan/index", $_PAGE); });
			Document::build();
		}
		// Review Loans
		elseif ($path === "review")
		{
			$_PAGE += array
			(
				"back" => $appletRoot,
				"categories" => $loans->countLoansByCategory()
			);
			Document::body(function() use($_PAGE) { Document::page("loan/review", $_PAGE); });
			Document::build();
		}
		// Create loan and redirect to editor
		else if ($path === "create")
		{
			$loanid = $loans->insertLoan(Session::userid());
			Document::redirect($_PAGE["APPLET_ROOT"]."/$loanid");
		}
		elseif ($path === "calendar")
		{
			$_PAGE += array
			(
				"back" => $appletRoot,
				"categories" => $loans->countLoansByCategory()
			);
			Document::body(function() use($_PAGE) { Document::page("loan/review", $_PAGE); });
			Document::build();
		}
		// Delete loan
		elseif (preg_match('#^(?P<loanid>\d+)/delete$#', $path, $matches))
		{
			$loanid = $matches["loanid"];
			$cat = $loans->getCategoryById($loanid);
			$loans->deleteLoanById($loanid);
			Document::redirect($_PAGE["APPLET_ROOT"]."/review/$cat");
		}
		// Edit or view loan
		elseif (preg_match('#^(?P<loanid>\d+)$#', $path, $matches))
		{
			$loanid = $matches["loanid"];
			if (isset($args["__method"]) && $args["__method"] === "update")
			{
				$loan = array();
				$loan["userid"] = Session::userid();
				$loan["loanid"] = $loanid;
				$loan["loanername"] = $args["loanername"];
				$loan["staffname"] = $args["staffname"];
				$loan["loandate"] = (string)(new FSDateTime($args["loan_year"], $args["loan_month"], $args["loan_day"]));
				$loan["returndate"] = (string)(new FSDateTime($args["return_year"], $args["return_month"], $args["return_day"]));
				$loan["completion"] = 0;
				$loans->updateLoan($loanid, $loan);
				$cat = $loans->getCategoryById($loanid);
				Document::redirect($_PAGE["APPLET_ROOT"]."/review/$cat");
			}
			else
			{
				$loan = $loans->selectLoanById($loanid);
				$_PAGE += array
				(
					"back" => $appletRoot."/review/".$loans->categoryOf($loan['daydiff']),
					"loan" => $loan,
					"loanid" => $loanid,
					"loanowner" => $datasource->user_name(array("userid" => $loan["userid"]))
				);
				Document::body(function() use($_PAGE) { Document::page("loan/edit", $_PAGE); });
				Document::build();
			}
		}
		// Edit or view loan equipment
		elseif (preg_match('#^(?P<loanid>\d+)/equipment$#', $path, $matches))
		{
			$loanid = $matches["loanid"];

			if (isset($args["__method"]))
			{
				switch($args["__method"])
				{
					case "insert":
						$equipment = array("equipmentname" => $args["equipmentname"], "assetno" => $args["assetno"]);
						$loans->insertEquipment($loanid, $equipment);
						break;
					case "update":
						$equipment = array("equipmentname" => $args["equipmentname"], "assetno" => $args["assetno"]);
						$equipmentid = $args["equipmentid"];
						$loans->updateEquipment($equipmentid, $equipment);
						break;
				}
			}
			
			$_PAGE += array
			(
				"back" => "$appletRoot/$loanid",
				"equipment" => $loans->selectEquipmentByLoanId($loanid)
			);

			Document::body(function() use($_PAGE) { Document::page("loan/equipment", $_PAGE); });
			Document::build();
		}
		// Add equipment
		elseif (preg_match('#^(?P<loanid>\d+)/equipment/create$#', $path, $matches))
		{
			$loanid = $matches["loanid"];
			$_PAGE += array
			(
				"back" => "$appletRoot/$loanid/equipment"
			);

			Document::body(function() use($_PAGE) { Document::page("loan/equipment/create", $_PAGE); });
			Document::build();
		}
		// Edit or view equipment
		elseif (preg_match('#^(?P<loanid>\d+)/equipment/(?P<equipmentid>\d+)$#', $path, $matches))
		{
			$loanid = $matches["loanid"];
			$equipmentid = $matches["equipmentid"];
			$_PAGE += array
			(
				"back" => "$appletRoot/$loanid/equipment",
				"equipmentid" => $equipmentid,
				"equipment" => $loans->selectEquipmentById($equipmentid)
			);

			Document::body(function() use($_PAGE) { Document::page("loan/equipment/edit", $_PAGE); });
			Document::build();
		}
		// Delete equipment
		elseif (preg_match('#^(?P<loanid>\d+)/equipment/(?P<equipmentid>\d+)/delete$#', $path, $matches))
		{
			$loanid = $matches["loanid"];
			$equipmentid = $matches["equipmentid"];

			$loans->deleteEquipmentById($equipmentid);

			Document::redirect($_PAGE["APPLET_ROOT"]."/$loanid/equipment");
		}
		// Review loans by category
		elseif (preg_match('#^review/(?P<category>\d+)$#', $path, $matches))
		{
			$category = $matches["category"];
			$_PAGE += array
			(
				"back" => "$appletRoot/review",
				"category" => $category,
				"loans" => $loans->selectLoansByCategory($category)
			);

			Document::body(function() use($_PAGE) { Document::page("loan/review-cat", $_PAGE); });
			Document::build();
		}
		// Redirect invalid pages to index
		else
		{
			Document::redirect($_PAGE["APPLET_ROOT"]);
		}
		
		
		
		
	}
	public static function callback($app)
	{
		$a = new LoanApplet($app);
		return $a->start();
	}
}
?>
