<?php
class FSDateTime extends FieldSet
{
	protected function __field_list()
	{
		return array("year", "month", "day", "hour", "minute", "second");
	}
	protected function __field_defaults()
	{
		return array("1", "1", "1", "0", "0", "0");
	}
	protected function __fromString($str)
	{
		return $this->__fromPattern('/^(?P<year>\d+)-(?P<month>\d+)-(?P<day>\d+) (?P<hour>\d+)\:(?P<minute>\d+)\:(?P<second>\d+)$/', $str);
	}
	public function __toString()
	{
		return sprintf("%s-%s-%s %s:%s:%s", $this->year, $this->month, $this->day, $this->hour, $this->minute, $this->second);
	}
}
?>
