<?php
class Widgets
{
	// logout button
	public static function logout()
	{
		return Session::verify() ?
			'<a href="'.APPDIR.'/user/logout" class="ui-btn-right ui-btn ui-icon-power ui-btn-icon-notext ui-shadow ui-corner-all">'.Language::logout().'</a>' :
			'';
	}

	// header back button
	public static function back($back)
	{
		return '<a href="'.APPDIR.$back.'" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all">'.Language::back().'</a>';
	}

	// apply selected attribute if values match
	public static function selected($v0, $v1)
	{
		return $v0 == $v1 ? ' selected="selected"' : "";
	}

	// todo
	public static function options($options, $value)
	{
	}

	// todo
	public static function widget()
	{
	}

	// Widgets::a_b_c(array $args) => includes /widgets/a/b/c.php with scope variables $args
	public static function __callStatic($__callName, $__callArgs)
	{
		$fn = WIDGETDIR."/".str_replace("_", "/", $__callName).".php";
		if (file_exists($fn))
		{
			if (isset($__callArgs[0]))
				extract($__callArgs[0]);
			include $fn;
			return compact(array_keys(get_defined_vars()));
		}
		else
		{
			throw new Exception("Invalid widget $__callName");
		}
	}
}
?>
