<?php
class ClientApplet
{
	private $app;
	public function __construct($app)
	{
		session_start();
		$this->app = $app;
	}
	public function start()
	{
		$path = $this->app->path();

		if (!$path->hasNext())
		{
			Document::body(function()
			{
				Document::page("guest");
			});
			Document::build();
		}
		else
		{
			Bean::path($path->toString());
			Document::body(function()
			{
				Document::page("404");
			});
			Document::build();
		}
	}
	public static function callback($app)
	{
		$a = new ClientApplet($app);
		return $a->start();
	}
}
?>
