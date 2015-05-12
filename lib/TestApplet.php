<?php
class TestApplet
{
	private $app;
	public function __construct($app)
	{
		$this->app = $app;
	}
	public function start()
	{
		$datasource = $this->app->datasource();
		/*print_r(array(
			$datasource->user_login(array("username" => "TestUser", "password" => "1234")),
			$datasource->user_login(array("username" => "TestUser", "password" => "4321")),
			$datasource->user_login(array("username" => "H33", "password" => "ww"))
		));*/
		//echo $datasource->user_name(array("userid" => 1));
		throw new Exception("ABCDEFG");
	}
	public static function callback($app)
	{
		$a = new TestApplet($app);
		return $a->start();
	}
}
?>
