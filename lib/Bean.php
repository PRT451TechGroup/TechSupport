<?php
class Bean
{
	private static $beanTable = array();
	public static function extract()
	{
		$fga = func_get_args();

		if (count($fga) > 0)
		{
			$extract = array();
			foreach($fga as $key)
			{
				$extract[$key] = self::$beanTable[$key];
			}
			return $extract;
		}
		else
		{
			return self::$beanTable;
		}
	}
	public static function set($name, $val = null)
	{
		if (is_array($name))
		{
			foreach($name as $k => $v)
			{
				self::$beanTable[$k] = $v;
			}
		}
		else
			self::$beanTable[$name] = $val;
	}
	public static function get($name, $val = null)
	{
		if (isset($val))
		{
			self::$beanTable[$name] = $val;
		}
		else
		{
			if (!isset(self::$beanTable[$name]))
				throw new Exception('Bean '.$name.' does not exist');

			return self::$beanTable[$name];
		}
	}
	public static function text($name)
	{
		return htmlspecialchars(self::get($name));
	}
	public static function __callStatic($name, $args)
	{
		return (count($args) == 0) ? self::get($name) : self::get($name, $args[0]);
	}
}
?>
