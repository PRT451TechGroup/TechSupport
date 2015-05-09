<?php
class Path
{
	private $pos;
	private $spl;
	public function __construct($path, $skip = 0)
	{
		$path = trim($path, "/");
		$path = explode("?",$path)[0];
		$this->spl = array_slice(explode("/",$path), $skip);
		$this->pos = 0;
	}
	public function next()
	{
		return $this->hasNext() ? $this->spl[$this->pos++] : null;
	}
	public function peek()
	{
		return $this->pos <= count($this->spl) ? $this->spl[$this->pos] : null;
	}
	public function rewind()
	{
		if ($this->pos !== 0)
		{
			$this->pos--;
		}
	}
	
	public function count()
	{
		return count($this->spl);
	}
	public function hasNext()
	{
		return $this->pos < count($this->spl);
	}
}
?>
