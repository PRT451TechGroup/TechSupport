<?php
class Session
{
	private static $started = false;
	private static $verified = false;
	private static $datasource;

	public static function datasource($val)
	{
		self::$datasource = $val;
	}
	
	public static function start()
	{
		if (!self::$started)
		{
			self::$started = true;
			session_start();
		}
	}
	public static function verify($minprivilege = "user")
	{
		if (self::$verified)
		{
			return self::privilege_level($_SESSION["privilege"]) >= self::privilege_level($minprivilege);
		}
		
		$users = new \Data\Table\Users(self::$datasource->open_connection());
		
		if (!isset($_SESSION["userid"]))
			return false;
			
		$user = $users->selectUserById($_SESSION["userid"]);

		if (($_SESSION["username"] = $user["username"]) === false)
			return false;
			
		if (self::privilege_level($_SESSION["privilege"] = $user["privilege"]) < self::privilege_level($minprivilege))
			return false;

		self::$verified = true;
		return true;
	}
	public static function privilege_level($privilege)
	{
		return intval(array_search($privilege, array("guest", "user", "admin")));
	}
	public static function privilege($val = null)
	{
		if (isset($val))
			$_SESSION["privilege"] = $val;
		else
			return $_SESSION["privilege"];
	}
	public static function username($val = null)
	{
		if (isset($val))
			$_SESSION["username"] = $val;
		else
			return $_SESSION["username"];
	}
	public static function userid($val = null)
	{
		if (isset($val))
			$_SESSION["userid"] = $val;
		else
			return $_SESSION["userid"];
	}
	public static function clear()
	{
		self::start();
		unset($_SESSION["username"]);
		unset($_SESSION["userid"]);
	}
}
?>
