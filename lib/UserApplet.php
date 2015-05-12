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
		$path = $this->app->path();
		$args = new ArrayList($this->app->arguments());

		$match = $path->match(array
		(
			"." => "user",
			"*" => "default",
			"login" => array
			(
				"." => "login",
				"*" => "default",
				"submit" => "login-submit"
			),
			"register" => array
			(
				"." => "register",
				"*" => "default",
				"submit" => "register-submit"
			)
			
		));

		
		switch($match)
		{
			case "user":
				Document::body(function() { Document::page("user"); });
				Document::build();
				break;
			case "login-submit":
				if ($args->containsKey("username", "password"))
				{
					
				}
				else
				{
					Document::redirect(APPDIR."/user/login");
				}
				break;
			case "login":
				Document::body(function() { Document::page("user-login"); });
				Document::build();
				break;
			case "register":
				Document::body(function() { Document::page("user-register"); });
				Document::build();
				break;
			case "register-submit":
				if ($args->containsKey("username", "password", "vpassword"))
				{
					$err = true;

					if (strlen($args->username) == 0)
						Bean::error(Language::username_blank());
					else if ($args->password != $args->vpassword)
						Bean::error(Language::password_mismatch());
					else if (strlen($args->password) == 0)
						Bean::error(Language::password_blank());
					else
						$err = false;


					if ($err)
					{
						Document::body(function() { Document::page("register-error"); });
						Document::build();
					}
					else
					{
						$datasource = $this->app->datasource();

						$uid = $datasource->user_register(array("username" => $args->username, "password" => $args->password));
						Bean::retval(array("retval" => $uid));
						Document::body(function() { print_r(Bean::retval()); });
						Document::build();
					}
				}
				else
				{
					Document::redirect(APPDIR."/user/register");
				}
				break;
			case "default":
				Document::redirect(APPDIR."/user");
				break;
		}
		
		
		
		
	}
	public static function callback($app)
	{
		$a = new UserApplet($app);
		return $a->start();
	}
}
?>
