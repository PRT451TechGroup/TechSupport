<?php
class ClientApplet
{
	public function __construct()
	{
		session_start();
	}
	public function start($getVars, $postVars, $path)
	{
		while(($p = $path->next()) != null)
		{
			echo htmlspecialchars($p) . "<br />";
		}
	}
	public static function callback($getVars, $postVars, $path)
	{
		return (new ClientApplet())->start($getVars, $postVars, $path);
	}
}
?>
