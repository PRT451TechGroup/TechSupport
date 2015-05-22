<?php
require("define.inc.php");
spl_autoload_register(function($class)
{
	require LIBDIR."/".str_replace("\\", "/", $class).".php";
});

call_user_func(function()
{
	$app = null;
	ob_start(null, 0, PHP_OUTPUT_HANDLER_STDFLAGS);
	try
	{
		require("language.en.php");
		require("config.inc.php");
		$path = isset($_GET["forcepath"]) ? new Path($_GET["forcepath"]) : new Path(substr($_SERVER["REQUEST_URI"], strlen(APPDIR)));
		$app = new Application();
		$app->arguments($_POST)->path($path)->datasource(Configuration::datasource());
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
	catch(Exception $e)
	{
		ob_clean();
		try
		{
			$GLOBALS["PrimaryException"] = $e;
			$GLOBALS["__APPLICATION"] = $app;
			require(PAGEDIR."/exception.php");
		}
		catch(Exception $f)
		{
			ob_clean();
			echo "<h2>Exception</h2>";
			echo "<p>" . str_replace("\n", "<br />", htmlspecialchars($e->toString())) . "</p>";
			echo "<h2>Second Exception</h2>";
			echo "<p>" . str_replace("\n", "<br />", htmlspecialchars($f->toString())) . "</p>";
		}
	}
	ob_end_flush();
});
?>
