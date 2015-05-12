<?php
class Application
{
	private $arguments;
	private $path;
	private $doctree;
	private $datasource;
	public function __construct()
	{
	}
	public function arguments($v = null)
	{
		if (isset($v))
		{
			$this->arguments = $v;
			return $this;
		}
		else
			return $this->arguments;
	}
	public function path($v = null)
	{
		if (isset($v))
		{
			$this->path = $v;
			return $this;
		}
		else
			return $this->path;
	}
	public function doctree($v = null)
	{
		if (isset($v))
		{
			$this->doctree = $v;
			return $this;
		}
		else
			return $this->doctree;
	}
	public function datasource($v = null)
	{
		if (isset($v))
		{
			$this->datasource = $v;
			return $this;
		}
		else
			return $this->datasource;
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
			{
				$this->path->rewind();
				break;
			}
		}
		
		if (is_array($at) && isset($at["*"]))
		{
			$at = $at["*"];
		}
		
		if (is_callable($at))
			return $at($this);
		else
			return;
	}
}
?>
