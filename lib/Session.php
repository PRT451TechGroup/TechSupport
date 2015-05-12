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
	public static function verify()
	{
		if (self::$verified)
			return true;
		
		if (!isset($_SESSION["userid"]))
			return false;

		if (($_SESSION["username"] = self::$datasource->user_name(array("userid" => $_SESSION["userid"]))) === false)
			return false;

		self::$verified = true;
		return true;
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
