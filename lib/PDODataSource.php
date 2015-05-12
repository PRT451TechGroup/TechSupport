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
	private function prepare($stmt)
	{
		return $this->open_connection()->prepare($stmt);
	}
	public function datasource_init()
	{
	}
	public function datasource_create()
	{
	}

	public function user_login($args)
	{
		$data = new ArrayList($args);
		
		if (!data.containsKey("username", "password"))
			return false;

		if (strlen($data->username) === 0 || strlen($data->password) === 0)
			return false;

		$stmt = $this->prepare('SELECT userid, hash, salt FROM users WHERE username = ?');

		if (!$stmt->execute(array($data->username)))
			return false;

		$res = $stmt->fetchAll();
		foreach($res as $row)
		{
			$auth = Authenticator::from_hash($row["hash"], $row["salt"]);
			if ($auth->verify($data->password))
				return intval($res["userid"]);
		}
		return false;
	}
	public function user_register($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("username", "password"))
			return false;

		if (strlen($data->username) === 0 || strlen($data->password) === 0)
			return false;

		$conn = $this->open_connection();
		$stmt = $conn->prepare('INSERT INTO users (username, hash, salt) VALUES (?, ?, ?)');
		$auth = Authenticator::from_password($data->password);

		if (!$stmt->execute(array($data->username, $auth->hash(), $auth->salt())))
			return false;

		return $conn->lastInsertId();
	}
	/*
	public function repair_new($args)
	{
		$data = new ArrayList($args);

		
	}
	public function repair_list();
	public function repair_modify($data);
	public function repair_delete($data);*/
}
?>
