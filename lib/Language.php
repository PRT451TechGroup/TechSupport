<?php
class Language
{
	private static $callbackTable = array();
	private static $stringTable = array();
	public static function addString($name, $val = null)
	{
		if (is_array($name))
		{
			foreach($name as $k => $v)
			{
				self::$stringTable[$k] = $v;
			}
		}
		else
			self::$stringTable[$name] = $val;
	}
	public static function addCallback($name, $val)
	{
		self::$callbackTable[$name] = $val;
	}
	public static function val($name, $args = null)
	{

		switch(self::resourceType($name))
		{
			case "string";
				return self::$stringTable[$name];
			case "callable";
				$cb = self::$callbackTable[$name];
				return $cb($args);
			default:
				throw new Exception('Resource '.$name.' does not exist');
		}
		
	}
	public static function resourceType($name)
	{
		if (isset(self::$stringTable[$name]))
			return "string";
		if (isset(self::$callbackTable[$name]))
			return "callable";

		return "none";
	}
	public static function __callStatic($name, $args)
	{
		if (self::resourceType($name) != "none")
		{
			return self::val($name, (count($args) > 0) ? $args[0] : null);
		}
		else
		{
			throw new Exception('Resource ' . $name . ' does not exist');
		}
	}
}
?>
