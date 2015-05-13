<?php
class Path
{
	private $pos;
	private $spl;
	public function __construct($path, $skip = 0)
	{
		$path = trim($path, "/");
		$path = explode("?",$path);
		$path = $path[0];
		
		if (strlen($path) === 0)
			$this->spl = array();
		else
			$this->spl = array_slice(explode("/",$path), $skip);
		$this->pos = 0;
	}
	public function match($tree, &$vars = null)
	{
		$at = $tree;
		$minpos = $this->pos;
		while(($name = $this->next()) !== null)
		{
			
			if (strlen($name) === 0)
				break;
			
			if (array_key_exists($name, $at))
			{
				
				$at = $at[$name];
				if (is_string($at))
					break;
			}
			else if (isset($at["/"]) && isset($at["*"]))
			{
				if (isset($vars))
					$vars[$at["/"]] = $name;

				$at = $at["*"];
			}
			else
			{
				$this->rewind();
				break;
			}
		}

		if (is_array($at))
		{
			if ($this->hasNext())
			{
				if (isset($at["*"]))
					$at = $at["*"];
			}
			else
			{
				if (isset($at["."]))
					$at = $at["."];
				else if (isset($at["*"]))
					$at = $at["*"];
			}
		}

		if ($this->pos < $minpos)
			$this->pos = $minpos;
		
		return $at;
	}
	public function next()
	{
		return $this->hasNext() ? $this->spl[$this->pos++] : null;
	}
	public function peek()
	{
		return $this->hasNext() ? $this->spl[$this->pos] : null;
	}
	public function rewind()
	{
		if ($this->pos !== 0)
		{
			$this->pos--;
			return $this->spl[$this->pos];
		}
		else
			return null;
	}
	public function reset()
	{
		$this->pos = 0;
	}
	
	public function count()
	{
		return count($this->spl);
	}
	public function hasNext()
	{
		return $this->pos < count($this->spl);
	}
	public function toString()
	{
		$out = "";
		foreach($this->spl as $k => $v)
		{
			if ($k === $this->pos)
				$fmt = "%s[%s] ";
			else
				$fmt = "%s%s ";

			$out = sprintf($fmt, $out, $v);
		}
		return $out;
	}
}
?>
