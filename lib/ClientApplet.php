<?php
class ClientApplet
{
	private $app;
	public function __construct($app)
	{
		session_start();
		$this->app = $app;
	}
	public function start()
	{
		/*$pages = array
		(
			"pgMain",
			""
		);

		foreach($pages as $key => $value)
		{
			include sprintf("%s/%s.php", PAGEDIR, $value);
		}*/

		include sprintf("%s/%s.php", PAGEDIR, "default");
	}
	public static function callback($app)
	{
		return (new ClientApplet($app))->start();
	}
}
?>
