<?php
class Session
{
	private static $started = false;
	
	public static function start()
	{
		if (!self::$started)
		{
			self::$started = true;
			session_start();
		}
	}
	public static function verify($datasource)
	{
		if (!isset($_SESSION["userid"]))
			return false;

		if (($_SESSION["username"] = $datasource->user_name(array("userid" => $_SESSION["userid"]))) === false)
			return false;

		return true;
	}
	public static function username()
	{
		return $_SESSION["username"];
	}
	public static function userid()
	{
		return $_SESSION["userid"];
	}
}
?>
