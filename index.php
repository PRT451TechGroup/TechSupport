<?php
require("config.inc.php");
spl_autoload_register(function($class)
{
	require LIBDIR."/".$class.".php";
});
require("language.en.php");

function startApplication()
{
	global $datasource;
	$path = isset($_GET["forcepath"]) ? new Path($_GET["forcepath"]) : new Path(substr($_SERVER["REQUEST_URI"], strlen(APPDIR)));
	//echo $path;
	$app = new Application();
	$app->arguments($_POST)->path($path)->datasource($datasource());
	$app->doctree(array
	(
		"*" => function($v) { ClientApplet::callback($v); },
		"user" => function($v) { UserApplet::callback($v); },
		"repair" => function($v) { RepairApplet::callback($v); },
		"request" => function($v) { RequestApplet::callback($v); },
		"loan" => function($v) { LoanApplet::callback($v); },
		"js" => function($v) { ScriptApplet::callback($v); },
		"test" => function($v) { TestApplet::callback($v); }
	));
	$app->start();
}
startApplication();
?>
