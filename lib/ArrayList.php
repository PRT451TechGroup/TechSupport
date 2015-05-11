<?php
class ArrayList
{
	private $model;
	public function __construct($model)
	{
		if ($model instanceof ArrayList)
			$this->model = $model->toArray();
		else
			$this->model = $model;
	}
	public function toArray()
	{
		return $this->model;
	}
	public function length()
	{
		return count($this->model);
	}
	public function count()
	{
		return $this->length();
	}
	public function containsKey()
	{
		foreach(func_get_args() as $key)
		{
			if (!array_key_exists($key, $this->model))
				return false;
		}
		return true;
	}
	public function containsValue($val, $strict = false)
	{
		return in_array($val, $this->model, $strict);
	}
	public function __unset($key)
	{
		unset($this->model[$key]);
	}
	public function __isset($key)
	{
		return isset($this->model[$key]);
	}
	public function __get($key)
	{
		return $this->model[$key];
	}
	public function __set($key, $val)
	{
		$this->model[$key] = $val;
	}
	public function __call($key, $args)
	{
		if (count($args) === 0)
		{
			return $this->model[$key];
		}
		else
		{
			$this->model[$key] = $args[0];
			return $this;
		}
	}
}
?>
