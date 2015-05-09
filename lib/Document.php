<?php
class Document
{
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
}
?>
