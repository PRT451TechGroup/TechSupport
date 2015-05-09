<?php
require("config.inc.php");
spl_autoload_register(function($class)
{
	require sprintf("%s/%s.php", LIBDIR, $class);
});
function startApplication()
{
	$path = isset($_GET["forcepath"]) ? new Path($_GET["forcepath"]) : new Path(substr($_SERVER["REQUEST_URI"], strlen(APPDIR)));
	//echo $path;
	$app = new Application();
	$app->arguments($_POST)->path($path);
	$app->doctree(array
	(
		"*" => array("ClientApplet", "callback"),
		"user" => array("UserApplet", "callback"),
		"repair" => array("RepairApplet", "callback"),
		"request" => array("RequestApplet", "callback"),
		"loan" => array("LoanApplet", "callback"),
		"js" => array("ScriptApplet", "callback")
	));
	$app->start();
}
startApplication();
?>
