<?php
class Configuration
{
	private static $configTable = array();
	public static function set($name, $val = null)
	{
		if (is_array($name))
		{
			foreach($name as $k => $v)
			{
				self::$configTable[$k] = $v;
			}
		}
		else
			self::$configTable[$name] = $val;
	}
	public static function get($name, $val = null)
	{
		if (isset($val))
		{
			self::$configTable[$name] = $val;
		}
		else
		{
			if (!isset(self::$configTable[$name]))
				throw new Exception('Bean '.$name.' does not exist');

			return self::$configTable[$name];
		}
	}
	public static function __callStatic($name, $args)
	{
		return (count($args) == 0) ? self::get($name) : self::get($name, $args[0]);
	}
}
?>
