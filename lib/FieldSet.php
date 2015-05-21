<?php
abstract class FieldSet
{
	private $model;
	abstract protected function __field_list();
	abstract protected function __field_defaults();
	abstract public function __toString();
	abstract protected function __fromString($str);
	
	public function __construct()
	{
		$fga = func_get_args();
		if (count($fga) > 0)
		{
			if (count($fga) === 1)
			{
				$arg = $fga[0];
				if (is_object($arg) && get_class($this) === get_class($arg))
				{
					$this->model = $arg->model;
					return;
				}
				else if (is_string($arg))
				{
					$this->model = $this->__fromString($arg);
					if (!is_null($this->model))
						return;
				}
				else if (is_array($arg))
				{
					$fl = $this->__field_list();
					$fd = $this->__field_defaults();

					$keys = array_intersect($fl, array_keys($arg));
					foreach($keys as $key)
					{
						$fd[$key] = $arg[$key];
					}
					$this->model = array_combine($fl, $fd);
					return;
				}
			}
			else
			{
				$fl = $this->__field_list();
				$fd = $this->__field_defaults();

				for($i=0;$i<count($fd) && $i<count($fga);$i++)
					$fd[$i] = $fga[$i];
				
				$this->model = array_combine($fl, $fd);
				return;
			}
		}
		$this->model = array_combine($this->__field_list(), $this->__field_defaults());
	}
	public function &__get($fieldName)
	{
		if (array_key_exists($fieldName, $this->model))
			return $this->model[$fieldName];
		else
			throw new Exception("Unknown field $fieldName");
	}
	public function __isset($fieldName)
	{
		if (array_key_exists($fieldName, $this->model))
			return isset($this->model[$fieldName]);
		else
			throw new Exception("Unknown field $fieldName");
	}
	public function __set($fieldName, $fieldValue)
	{
		if (array_key_exists($fieldName, $this->model))
			$this->model[$fieldName] = $fieldValue;
		else
			throw new Exception("Unknown field $fieldName");
	}
	protected function __fromPattern($pattern, $subject)
	{
		$matches = array();
		if (preg_match($pattern, $subject, $matches))
			return $this->extract_fields($matches);
		else
			return null;
	}
	protected function extract_fields($arr)
	{
		$out = array();
		$keys = array_intersect($this->__field_list(), array_keys($arr));
		foreach($keys as $key)
		{
			$out[$key] = $arr[$key];
		}
		return $out;
	}
	public function to_array()
	{
		return $this->model;
	}
}
?>
