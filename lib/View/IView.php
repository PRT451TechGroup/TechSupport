<?php
namespace View;
interface IView
{
	public function set($name, $value);
	public function sets($vars);
	public function fetch($name);
	public function show();
	
}
?>
