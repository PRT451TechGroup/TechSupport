<?php
class Document
{
	private static $body;
	private static $context;
	private static $vars = array();
	public static function body($val = null)
	{
		 if (isset($val))
		 {
		 	self::$body = $val;
		 }
		 else
		 {
		 	$f = self::$body;
		 	$f();
		 }
	}
	
	public static function js($file)
	{
		return sprintf('<script src="%s/js/%s.js"></script>', APPDIR, $file);
	}
	public static function js_root($file)
	{
		return sprintf('<script src="%s/%s.js"></script>', APPDIR, $file);
	}
	public static function css($file)
	{
		return sprintf('<link rel="stylesheet" href="%s/css/%s.css" />', APPDIR, $file);
	}
	public static function css_root($file)
	{
		return sprintf('<link rel="stylesheet" href="%s/%s.css" />', APPDIR, $file);
	}
	public static function page($__page, $__vars = array())
	{
		extract($__vars);
		include sprintf("%s/%s.php", PAGEDIR, $__page);
	}
	public static function build()
	{
		self::page("template");
	}
	public static function context($val = null)
	{
		if (isset($val))
		 {
		 	self::$context = $val;
		 }
		 else
		 {
		 	return self::$context;
		 }
	}
	public static function val($key, $val = null)
	{
		if (isset($val))
		{
			self::$vars[$key] = $val;
		}
		else
		{
			return self::$vars[$key];
		}
	}
	public static function text($key)
	{
		return htmlspecialchars(self::$vars[$key]);
	}
	public static function redirect($v)
	{
		header("Location: $v");
		return;
		Bean::redirect($v);
		self::body(function() { self::page("redirect"); });
		self::build();
	}
}
?>
