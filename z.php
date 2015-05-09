<?php
class xyz
{
	public function __construct()
	{
	
	}
	public function __set($n, $v)
	{
		echo "$n = $v";
	}
}
$f = new xyz();
$f["hello"] = 10;
?>