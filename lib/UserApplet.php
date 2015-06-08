<?php
use \Exceptions\BreakException;
class UserApplet
{
	private $app;
	public function __construct($app)
	{
		$this->app = $app;
	}
	public function start()
	{
		$path = $this->app->path()->remainder();
		$args = new ArrayList($this->app->arguments());
		$datasource = $this->app->datasource();
		$users = new \Data\Table\Users($datasource->open_connection());
		$appletRoot = "/user";
		$_PAGE = array("APPLET_ROOT" => APPDIR.$appletRoot, "appletRoot" => $appletRoot);
		$matches = array();
		try
		{
		if ($path === "")
		{
			if (!Session::verify())
			{
				$_PAGE["back"] = "/";
				Document::body(function() use($_PAGE) { Document::page("user/login", $_PAGE); });
				Document::build();
			}
			else
			{
				$_PAGE["back"] = "/";
				Document::body(function() use($_PAGE) { Document::page("user/index", $_PAGE); });
				Document::build();
			}
		}
		else if ($path === "login")
		{
			if ($args->containsKey("username", "password"))
			{
				//$uid = $datasource->user_login(array("username" => $args->username, "password" => $args->password));
				$uid = $users->selectUserIdByCredentials($args->username, $args->password);
				if ($uid !== false)
				{
					Session::userid($uid);
					Session::username($args->username);
					Document::redirect(APPDIR.'/');
				}
				else
				{
					$_PAGE["back"] = "/user";
					$_PAGE["error"] = Language::badlogin();
					Document::body(function() use($_PAGE) { Document::page("user/login/error", $_PAGE); });
					Document::build();
				}
			}
			else
			{
				Document::redirect(APPDIR."/user");
			}
		}
		else if ($path === "forgot")
		{
			if ($args->containsKey("username", "email"))
			{
				$err = true;
				$_PAGE["back"] = "/user/forgot";
				if (strlen($args->username) == 0)
					$_PAGE["error"] = Language::username_blank();
				else if (!preg_match('/[A-Za-z0-9._%+-]+@[a-zA-Z0-9][a-zA-Z0-9-]{1,61}(?:\.[a-zA-Z0-9][a-zA-Z0-9-]{1,61})+/', $args->email))
					$_PAGE["error"] = Language::email_invalid();
				else
				{
					//$uid = $datasource->user_register(array("username" => $args->username, "password" => $args->password));
					$user = $users->resetPassword($args->username, $args->email);
					if ($user === false)
					{
						$_PAGE["error"] = "Invalid credentials";
					}
					else
					{
						$err = false;
					}
				}

				if ($err)
				{
					Document::body(function() use($_PAGE) { Document::page("forgot-error", $_PAGE); });
					Document::build();
				}
				else
				{
					$message = "Reset URL: ".Configuration::mailurl()."?username=".urlencode($user["username"])."&resetcode=".urlencode($user["resetcode"]);
					mail($args->email, "Password reset", $message, Configuration::mailheader());
					//$_PAGE["error"] = json_encode($user);
					//Document::body(function() use($_PAGE) { Document::page("forgot-error", $_PAGE); });
					//Document::build();
					Document::redirect(APPDIR."/");
				}
			}
			else
			{
				$_PAGE["back"] = "/user";
				Document::body(function() use($_PAGE) { Document::page("user/forgot", $_PAGE); });
				Document::build();
			}
		}
		else if ($path === "forgot/reset")
		{
			if (isset($_GET["resetcode"]) && isset($_GET["username"]))
			{
				$resetcode = $_GET["resetcode"];
				$username = $_GET["username"];
				$userid = $users->selectIdByUsername($username);
				if ($userid !== false)
				{
					if ($users->resetCode($userid, $resetcode))
					{
						$password = base64_encode(openssl_random_pseudo_bytes(16));
						if ($users->updatePassword($userid, $password))
						{
							$user = $users->selectUserById($userid);
							mail($user["email"], "New password", "Password: $password", Configuration::mailheader());
						}
						
					}
				}
			}
			Document::redirect(APPDIR."/");
		}
		else if ($path === "register")
		{
			if ($args->containsKey("username", "password", "vpassword", "email"))
			{
				$err = true;
				$_PAGE["back"] = "/user/register";
				if (strlen($args->username) == 0)
					$_PAGE["error"] = Language::username_blank();
				else if ($args->password != $args->vpassword)
					$_PAGE["error"] = (Language::password_mismatch());
				else if (!preg_match('/[A-Za-z0-9._%+-]+@[a-zA-Z0-9][a-zA-Z0-9-]{1,61}(?:\.[a-zA-Z0-9][a-zA-Z0-9-]{1,61})+/', $args->email))
					$_PAGE["error"] = Language::email_invalid();
				else if (strlen($args->password) == 0)
					$_PAGE["error"] = (Language::password_blank());
				else
				{
					//$uid = $datasource->user_register(array("username" => $args->username, "password" => $args->password));
					$uid = $users->insertUser($args->username, $args->password, $args->email);
					if ($uid === false)
					{
						$_PAGE["error"] = Language::user_exists();
					}
					else
					{
						Session::userid($uid);
						Session::username($args->username);
						$err = false;
					}
				}

				if ($err)
				{
					Document::body(function() use($_PAGE) { Document::page("user/register/error", $_PAGE); });
					Document::build();
				}
				else
				{
					
						
					Document::redirect(APPDIR."/");
				}
			}
			else
			{
				$_PAGE["back"] = "/user";
				Document::body(function() use($_PAGE) { Document::page("user/register", $_PAGE); });
				Document::build();
			}
		}
		else if ($path === "change")
		{
			if (!Session::verify())
				throw new BreakException();
			
			if ($args->containsKey("oldpassword", "password", "vpassword"))
			{
				$err = true;
				$_PAGE["back"] = "/user/change";
				if ($args->password != $args->vpassword)
					$_PAGE["error"] = (Language::password_mismatch());
				else if (strlen($args->password) == 0)
					$_PAGE["error"] = (Language::password_blank());
				else
				{
					//$uid = $datasource->user_register(array("username" => $args->username, "password" => $args->password));
					$ra = $users->updatePassword(Session::userid(), $args->password, $args->oldpassword);
					if ($ra === false)
					{
						$_PAGE["error"] = Language::old_password_incorrect();
					}
					else
					{
						$err = false;
					}
				}

				if ($err)
				{
					Document::body(function() use($_PAGE) { Document::page("user/change/error", $_PAGE); });
					Document::build();
				}
				else
				{
					
						
					Document::redirect(APPDIR."/");
				}
			}
			else
			{
				$_PAGE["back"] = "/user";
				Document::body(function() use($_PAGE) { Document::page("user/change", $_PAGE); });
				Document::build();
			}
		}
		else if ($path === "logout")
		{
			Session::clear();
			$_PAGE["back"] = "/user";
			Document::body(function() use($_PAGE) { Document::page("user/logout", $_PAGE); });
			Document::build();
		}
		else if (preg_match('#^approve(?:/(?P<path>.+))?$#', $path, $matches))
		{
			if (Session::verify("admin"))
			{
				if (isset($matches["path"]))
				{
					try
					{
						$path = $matches["path"];
						$matches = array();
						
						if (!preg_match('#^(?P<userid>\d+)(?:/(?P<action>reject|approve))?$#', $path, $matches))
							throw new \Exceptions\BreakException();
						
						$userid = $matches["userid"];
						$user = $users->selectUserById($userid);
						
						if ($user["privilege"] !== "guest")
							throw new BreakException();
						
						if (isset($matches["action"]))
						{
							$action = $matches["action"];
							
							if ($action === "reject")
								$users->deleteUserById($userid);
							elseif ($action === "approve")
								$users->setPrivilegeById($userid, "user");
							
							throw new BreakException();
						}
						else
						{
							$_PAGE += array
							(
								"back" => "/user/approve",
								"userid" => $userid,
								"user" => $user
							);
							Document::body(function() use($_PAGE) { Document::page("user/approve/review", $_PAGE); });
							Document::build();
						}
					}
					catch(BreakException $e)
					{
						Document::redirect($_PAGE["APPLET_ROOT"]."/approve");
					}
				}
				else
				{
					$_PAGE += array
					(
						"back" => "/user",
						"users" => $users->selectUsersByPrivilege("guest")
					);
					Document::body(function() use($_PAGE) { Document::page("user/approve", $_PAGE); });
					Document::build();
				}
			}
			else
				Document::redirect(APPDIR."/user");
		}
		else
		{
			throw new BreakException();
		}
		}
		catch(BreakException $e)
		{
			Document::redirect(APPDIR."/user");
		}
		
		
		
		
	}
	public static function callback($app)
	{
		$a = new UserApplet($app);
		return $a->start();
	}
}
?>
