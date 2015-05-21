<?php
class ClientApplet
{
	private $app;
	public function __construct($app)
	{
		$this->app = $app;
	}
	public function start()
	{
		$path = $this->app->path();

		if (!$path->hasNext())
		{
			if (Session::verify())
			{
				Document::body(function()
				{
					Document::page("guest");
				});
				Document::build();
			}
			else
			{
				Document::redirect(APPDIR.'/user');
			}
		}
		else
		{
			$_PAGE = array("path" => $path->toString(), "back" => "/");
			Document::body(function() use($_PAGE)
			{
				Document::page("404", $_PAGE);
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
