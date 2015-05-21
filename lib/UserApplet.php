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
			"." => "login",
			"*" => "default",
			"login" => "login-submit",
			"register" => array
			(
				"." => "register",
				"*" => "default",
				"submit" => "register-submit"
			),
			"logout" => "logout"
		));

		$_PAGE = array();
		switch($match)
		{
			case "user":
				$_PAGE["back"] = "/";
				Document::body(function() use($_PAGE) { Document::page("user", $_PAGE); });
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
						Document::redirect(APPDIR.'/');
						/*Bean::username($args->username);
						Bean::back("/");
						Document::body(function() { Document::page("login-success"); });
						Bean::back("/user");
						Document::build();*/
					}
					else
					{
						$_PAGE["back"] = "/user";
						$_PAGE["error"] = Language::badlogin();
						Document::body(function() use($_PAGE) { Document::page("login-error", $_PAGE); });
						Document::build();
					}
				}
				else
				{
					Document::redirect(APPDIR."/user");
				}
				break;
			case "login":
				$_PAGE["back"] = "/user";
				Document::body(function() use($_PAGE) { Document::page("user-login", $_PAGE); });
				Document::build();
				break;
			case "register":
				$_PAGE["back"] = "/user";
				Document::body(function() use($_PAGE) { Document::page("user-register", $_PAGE); });
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
						Document::redirect(APPDIR."/");
					}
				}
				else
				{
					Document::redirect(APPDIR."/user/register");
				}
				break;
			case "logout":
				Session::clear();
				$_PAGE["back"] = "/user";
				Document::body(function() use($_PAGE) { Document::page("user-logout", $_PAGE); });
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
