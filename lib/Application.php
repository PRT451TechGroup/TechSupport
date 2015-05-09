<?php
class Application
{
	private $getVars;
	private $postVars;
	private $path;
	private $doctree;
	public function __construct()
	{
	}
	public function getVars($v)
	{
		if (isset($v))
		{
			$this->getVars = $v;
			return $this;
		}
		else
			return $this->getVars;
	}
	public function postVars($v)
	{
		if (isset($v))
		{
			$this->postVars = $v;
			return $this;
		}
		else
			return $this->postVars;
	}
	public function path($v)
	{
		if (isset($v))
		{
			$this->path = $v;
			return $this;
		}
		else
			return $this->path;
	}
	public function doctree($v)
	{
		if (isset($v))
		{
			$this->doctree = $v;
			return $this;
		}
		else
			return $this->doctree;
	}
	
	public function start()
	{
		$at = $this->doctree;
		while(($name = $this->path->next()) !== null)
		{
			if (strlen($name) === 0)
				break;
			
			if (array_key_exists($name, $at))
			{
				$at = $at[$name];
				if (!is_array($at) || is_callable($at))
					break;
			}
			else
				break;
		}
		
		if (is_array($at) && isset($at["*"]))
		{
			$at = $at["*"];
			$this->path->rewind();
		}
		
		if (is_callable($at))
			return $at($this->getVars, $this->postVars, $path);
		else
			return;
	}
}
?>
