<?php
class Widgets
{
	public static function logout()
	{
		return Session::verify() ?
			'<a href="'.APPDIR.'/user/logout" class="ui-btn-right ui-btn ui-icon-power ui-btn-icon-notext ui-shadow ui-corner-all">'.Language::logout().'</a>' :
			'';
	}
	public static function back()
	{
		return '<a href="'.Bean::back().'>" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all">'.Language::back().'</a>';
	}
}
?>
