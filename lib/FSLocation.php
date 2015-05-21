<?php
class FSLocation extends FieldSet
{
	protected function __field_list()
	{
		return array("precinct", "building", "floor", "room");
	}
	protected function __field_defaults()
	{
		return array("Purple", "10", "1", "1");
	}
	protected function __fromString($str)
	{
		return $this->__fromPattern('/(?P<precinct>\w+) (?P<building>\d+)\.(?P<floor>\d+)\.(?P<room>\d+)/', $str);
	}
	public function __toString()
	{
		return sprintf("%s %s.%s.%s", $this->precinct, $this->building, $this->floor, $this->room);
	}
}
?>
