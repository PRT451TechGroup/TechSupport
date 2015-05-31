<?php
// spaghetti code needs to be cleaned up to same standard as LoanApplet
class RequestApplet
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

		$appletRoot = "/request";


		$_PAGE = array("APPLET_ROOT" => APPDIR.$appletRoot, "appletRoot" => $appletRoot);
		$requests = new \Data\Table\Requests($datasource->open_connection());

		// index
		if (strlen($path) === 0)
		{
			$_PAGE["back"] = "/";
			Document::body(function() use($_PAGE) { Document::page("request/index", $_PAGE); });
			Document::build();
		}
		// create
		elseif ($path === "create")
		{
			if (isset($args["__method"]) && $args["__method"] === "insert")
			{
				$request = array();
				$request["techname"] = $args["techname"];
				$request["staffname"] = $args["staffname"];
				$request["requirements"] = $args["requirements"];
				$request["location"] = (string)(new FSLocation($args["precinct"], $args["building"], $args["floor"], $args["room"]));
				$request["duedate"] = (string)(new FSDateTime($args["year"], $args["month"], $args["day"], $args["hour"], $args["minute"]));
				$request["priority"] = $args["priority"];
				$request["completed"] = 0;

				$requests->insertRequest(Session::userid(), $request);
				
				Document::redirect($_PAGE["APPLET_ROOT"]."/calendar");
			}
			else
			{
				$_PAGE["back"] = "/request/calendar";
				Document::body(function() use($_PAGE) { Document::page("request/create", $_PAGE); });
				Document::build();
			}
		}
		// review-cat
		elseif ($path === "calendar" || $path === "completed")
		{
			$_PAGE += ($path === "calendar") ?
			array
			(
				"requests" => $requests->selectRequests(Session::userid()),
				"calendar_title" => Language::request_calendar()
			) :
			array
			(
				"requests" => $requests->selectCompletedRequests(Session::userid()),
				"calendar_title" => Language::request_completed()
			);
			$_PAGE["calendar_mode"] = $path;
			$_PAGE["back"] = "$appletRoot";
			Document::body(function() use($_PAGE) { Document::page("request/calendar", $_PAGE); });
			Document::build();
		}
		// request-view
		elseif (preg_match('#^(?P<mode>calendar|completed)/(?P<requestid>\d+)$#', $path, $matches))
		{
			$mode = $matches["mode"];
			$requestid = $matches["requestid"];
			$request = $requests->selectRequestByid($requestid);

			$_PAGE["back"] = "$appletRoot/$mode";
			$_PAGE["requestid"] = $requestid;
			$_PAGE["request"] = $request;

			
			Document::body(function() use($_PAGE) { Document::page("request/view", $_PAGE); });
			Document::build();
		}
		// request
		else if (preg_match("#^(?P<requestid>\d+)$#", $path, $matches))
		{
			$requestid = $matches["requestid"];
			if (isset($args["__method"]) && $args["__method"] === "update")
			{
				$request = array();
				$request["techname"] = $args["techname"];
				$request["staffname"] = $args["staffname"];
				$request["requirements"] = $args["requirements"];
				$request["location"] = (string)(new FSLocation($args["precinct"], $args["building"], $args["floor"], $args["room"]));
				$request["duedate"] = (string)(new FSDateTime($args["year"], $args["month"], $args["day"], $args["hour"], $args["minute"]));
				$request["priority"] = $args["priority"];
				$request["completed"] = $args["completion"];

				$requests->updateRequest($requestid, $request);

				Document::redirect($_PAGE["APPLET_ROOT"]."/calendar");
			}
			else
			{
				$request = $requests->selectRequestById($requestid);
				
				$_PAGE["requestid"] = $requestid;
				$_PAGE["request"] = $request;
				
				$_PAGE["back"] = "/request/calendar";
				Document::body(function() use($_PAGE) { Document::page("request/edit", $_PAGE); });
				Document::build();
			}
		}
		// request-delete
		elseif (preg_match('#^(?P<requestid>\d+)/delete$#', $path, $matches))
		{
			$requestid = $matches["requestid"];
			$requests->deleteRequestById($requestid);
			Document::redirect($_PAGE["APPLET_ROOT"]."/calendar");
		}
		else
		{
			Document::redirect($_PAGE["APPLET_ROOT"]);
		}
	}
	public static function callback($app)
	{
		$a = new RequestApplet($app);
		return $a->start();
	}
}
?>
