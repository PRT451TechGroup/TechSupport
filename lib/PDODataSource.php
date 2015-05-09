<?php
class PDODataSource implements IDataSource
{
	private $pdo_dsn;
	private $pdo_username;
	private $pdo_password;
	private $pdo_options;
	
	public function __construct($dsn, $username, $password, $options)
	{
		$this->pdo_dsn = $dsn;
		$this->pdo_username = $username;
		$this->pdo_password = $password;
		$this->pdo_options = $options;
	}
	private function open_connection()
	{
		return new PDO($this->pdo_dsn, $this->pdo_username, $this->pdo_password, $this->pdo_options);
	}
	public function datasource_init()
	{
	}
	public function datasource_create()
	{
	}
}
?>
