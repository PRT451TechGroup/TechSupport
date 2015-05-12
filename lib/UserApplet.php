<?php
class UserApplet
{
	private $app;
	public function __construct($app)
	{
		$this->app = $app;
	}
	public function start()
	{
		$path = $this->app->path();
		$args = new ArrayList($this->app->arguments());
		$datasource = $this->app->datasource();
		
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
			),
			"logout" => "logout"
		));

		
		switch($match)
		{
			case "user":
				Bean::back("/");
				Document::body(function() { Document::page("user"); });
				Document::build();
				break;
			case "login-submit":
				if ($args->containsKey("username", "password"))
				{
					$uid = $datasource->user_login(array("username" => $args->username, "password" => $args->password));
					if ($uid !== false)
					{
						Session::userid($uid);
						Session::username($args->username);
						Bean::username($args->username);
						Bean::back("/");
						Document::body(function() { Document::page("login-success"); });
						Bean::back("/user");Document::build();
					}
					else
					{
						Bean::back("/user/login");
						Bean::error(Language::badlogin());
						Document::body(function() { Document::page("login-error"); });
						Document::build();
					}
				}
				else
				{
					Document::redirect(APPDIR."/user/login");
				}
				break;
			case "login":
				Bean::back("/user");
				Document::body(function() { Document::page("user-login"); });
				Document::build();
				break;
			case "register":
				Bean::back("/user");
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
			case "logout":
				Session::clear();
				Bean::back("/user");
				Document::body(function() { Document::page("user-logout"); });
				Document::build();
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
