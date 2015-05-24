<?php
namespace View;
abstract class View implements IView
{
	protected $vars = array();
	public function fetch($name)
	{
		return array_key_exists($name, $this->vars) ? $this->vars[$name] : null;
	}
	public function sets($vars)
	{
		$this->vars += $vars;
	}
	public function set($name, $value)
	{
		$this->vars[$name] = $value;
	}
	protected function page(/*$path, $vars*/)
	{
		extract(func_get_arg(1));
		include PAGEDIR.'/'.func_get_arg(0);
	}
}
?>
