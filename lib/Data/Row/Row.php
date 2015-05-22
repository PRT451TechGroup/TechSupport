<?php
namespace Data\Row;
abstract class Row implements ArrayAccess
{
	abstract public boolean offsetExists ( mixed $offset )
	abstract public mixed offsetGet ( mixed $offset )
	abstract public void offsetSet ( mixed $offset , mixed $value )
	abstract public void offsetUnset ( mixed $offset )
}
?>
