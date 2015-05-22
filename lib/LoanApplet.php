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
		if (!Session::verify())
		{
			Document::redirect(APPDIR."/");
			return;
		}
		
		$path = $this->app->path()->remainder();
		$args = $this->app->arguments();
		$datasource = $this->app->datasource();

		$appletRoot = "/loan";

		$_PAGE = array("APPLET_ROOT" => APPDIR.$appletRoot);
		$loans = new \Data\Table\Loans($datasource->open_connection());

		if (strlen($path) === 0)
		{
			$_PAGE["back"] = "/";
			Document::body(function() use($_PAGE) { Document::page("loan/index", $_PAGE); });
			Document::build();
		}
		elseif ($path === "review")
		{
			$_PAGE["back"] = $appletRoot;
			Document::body(function() use($_PAGE) { Document::page("loan/review", $_PAGE); });
			Document::build();
		}
		else if ($path === "create")
		{
			$loanid = $loans->insertLoan(Session::userid());
			Document::redirect($_PAGE["APPLET_ROOT"]."/create/$loanid");
		}
		elseif (preg_match('#^create/(?P<loanid>\d+)$#', $path, $matches))
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
			}

			$loan = $loans->selectLoanById($loanid);
			$_PAGE += array
			(
				"back" => $appletRoot,
				"loan" => $loan,
				"loanid" => $loanid
			);

			Document::body(function() use($_PAGE) { Document::page("loan/create", $_PAGE); });
			Document::build();
		}
		elseif (preg_match('#^create/(?P<loanid>\d+)/equipment$#', $path, $matches))
		{
			$loanid = $matches["loanid"];
			$_PAGE += array
			(
				"back" => "$appletRoot/create/$loanid",
				"equipment" => $loans->selectEquipmentByLoanId($loanid)
			);

			Document::body(function() use($_PAGE) { Document::page("loan/equipment", $_PAGE); });
			Document::build();
		}
		elseif (preg_match('#^create/(?P<loanid>\d+)/equipment/create$#', $path, $matches))
		{
			$loanid = $matches["loanid"];
			$_PAGE += array
			(
				"back" => "$appletRoot/create/$loanid/equipment"
			);

			Document::body(function() use($_PAGE) { Document::page("loan/equipment/create", $_PAGE); });
			Document::build();
		}
		elseif (preg_match('#^review/(?P<condition>\d+)$#', $path, $matches))
		{
			
		}
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
