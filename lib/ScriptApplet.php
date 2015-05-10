<?php
class ScriptApplet
{
	private $app;
	public function __construct($app)
	{
		$this->app = $app;
	}
	public function start()
	{
		$path = $this->app->path()->next();
		
	}
	public static function callback($app)
	{
		$a = new ScriptApplet($app);
		return $a->start();
	}
}
?>
