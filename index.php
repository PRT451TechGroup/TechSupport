<?php
define("DOCPATH", $_SERVER["DOCUMENT_ROOT"] . "/techsupport");
define("LIBDIR", DOCPATH . "/lib");
define("PAGEDIR", DOCPATH . "/pages");
spl_autoload_register(function($class)
{
	require sprintf("%s/%s.php", LIBDIR, $class);
});
function startApplication()
{
	$path = isset($_GET["forcepath"]) ? new Path($_GET["forcepath"]) : new Path($_SERVER["REQUEST_URI"], 1);
	//echo $path;
	$app = new Application();
	$app->getVars($_GET)->postVars($_POST)->path($path);
	$app->doctree(array
	(
		"*" => array("ClientApplet", "callback"),
		"user" => array("UserApplet", "callback"),
		"repair" => array("RepairApplet", "callback"),
		"request" => array("RequestApplet", "callback"),
		"loan" => array("LoanApplet", "callback")
	));
	$app->start();
}
startApplication();
?>
