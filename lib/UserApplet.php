<?php
class UserApplet
{
	private $app;
	public function __construct($app)
	{
		session_start();
		$this->app = $app;
	}
	public function start()
	{
		Document::val("AppletDir", APPDIR."/user");
		
		$path = $this->app->path();

		if ($path->hasNext())
		{
			$pn = $path->next();
			if ($pn == "login")
			{
				Document::body(function() { Document::page("user-login"); });	
			}
			elseif ($pn == "register")
			{
				Document::body(function() { Document::page("user-register"); });
			}
			else
			{
				Document::redirect(Document::val("AppletDir"));
			}
		}
		else
		{
			Document::body(function() { Document::page("user"); });
		}
		
		
		Document::build();
	}
	public static function callback($app)
	{
		$a = new UserApplet($app);
		return $a->start();
	}
}
?>
