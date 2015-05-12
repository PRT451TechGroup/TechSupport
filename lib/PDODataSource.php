<?php
/**
 * PDO implementation of data source
 * @implements IDataSource
 * @author AkariAkaori
 */
class PDODataSource implements IDataSource
{
	private $pdo_dsn;
	private $pdo_username;
	private $pdo_password;
	private $pdo_options;

	/**
	 * Creates a new PDO data source
	 * @param string $dsn The Data Source Name
	 * @param string $username The username
	 * @param string $password The password
	 * @param array $options The driver-specific options
	 */
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
		
		if (!$data->containsKey("username", "password"))
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
				return intval($row["userid"]);
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
	public function user_name($args)
	{
		$data = new ArrayList($args);
		
		if (!$data->containsKey("userid"))
			return false;

		$stmt = $this->prepare('SELECT username FROM users WHERE userid = ?');

		if (!$stmt->execute(array(intval($data->userid))))
			return false;

		$res = $stmt->fetchAll();
		foreach($res as $row)
		{
			return $row["username"];
		}
		return false;
	}
	public function user_names()
	{
		$stmt = $this->prepare('SELECT userid, username FROM users');

		if (!$stmt->execute())
			return false;

		$res = $stmt->fetchAll();
		$out = array();
		foreach($res as $row)
		{
			$out[strval($row["userid"])] = $row["username"];
		}
		return $out;
	}	
	
	public function repair_new($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("userid"))
		{
			throw new InvalidArgumentException("userid not supplied");
			return false;
		}
			

		if ($data->containsKey("userid", "location", "duedate", "completion", "priority"))
		{
			$sql = "INSERT INTO repairs (userid, location, duedate, completion, priority) VALUES (?, ?, ?, ?, ?)";
			$vals = array($data->userid, $data->location, $data->duedate, $data->completion, $data->priority);
		}
		else
		{
			$sql = "INSERT INTO repairs (userid) VALUES (?)";
			$vals = array($data->userid);
		}

		$conn = $this->open_connection();
		$stmt = $conn->prepare($sql);
		
		if (!$stmt->execute($vals))
			return false;

		return $conn->lastInsertId();
	}
	public function repair_get($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("repairid"))
		{
			throw new InvalidArgumentException("repairid not supplied");
			return false;
		}

		$conn = $this->open_connection();

		$stmt = $conn->prepare('SELECT * FROM repairs WHERE repairid = ?');

		if (!$stmt->execute(array($data->repairid)))
			return false;

		$out = array();

		foreach($stmt->fetchAll() as $row)
		{
			foreach($row as $key => $value)
			{
				if (!is_numeric($key))
					$out[$key] = $value;
			}

			$cnt = $conn->prepare('SELECT COUNT(equipmentid) AS equipmentcount FROM equipment WHERE repairid = ?');
			$cnt->execute(array($data->repairid));

			foreach($cnt->fetchAll() as $crow)
			{
				$out["equipmentcount"] = $crow["equipmentcount"];
			}
			
			return $out;
		}
		return false;
	}
	public function repair_completion()
	{
		$stmt = $this->prepare('SELECT completion, COUNT(repairid) AS repaircount, SUM(CASE WHEN priority > 0 THEN 1 ELSE 0 END) AS prioritycount FROM repairs GROUP BY completion');

		if (!$stmt->execute(array()))
			return false;

		$out = array();
		foreach($stmt->fetchAll() as $row)
		{
			$out[$row["completion"]] = array("repaircount" => $row["repaircount"], "prioritycount" => $row["prioritycount"]);
		}
		return $out;
	}
	public function repair_list($args)
	{
	}
	public function repair_modify($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("repairid"))
		{
			throw new InvalidArgumentException("repairid not supplied");
			return false;
		}
		if ($data->containsKey("location", "duedate", "completion", "priority"))
		{
			if ($data->containsKey("userid"))
			{
				$sql = "UPDATE repairs SET userid=?, location=?, duedate=?, completion=?, priority=? WHERE repairid=?";
				$vals = array($data->userid, $data->location, $data->duedate, $data->completion, $data->priority, $data->repairid);
			}
			else
			{
				$sql = "UPDATE repairs SET location=?, duedate=?, completion=?, priority=? WHERE repairid=?";
				$vals = array($data->location, $data->duedate, $data->completion, $data->priority, $data->repairid);
			}
		}
		else
		{
			throw new InvalidArgumentException("not enough columns supplied");
			return false;
		}

		$stmt = $this->prepare($sql);

		if (!$stmt->execute($vals))
			return false;
		
		return true;

	}
	public function repair_delete($data)
	{
	}

	public function equipment_list($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("repairid"))
		{
			throw new InvalidArgumentException("repairid not supplied");
			return false;
		}

		$stmt = $this->prepare('SELECT * FROM equipment WHERE repairid = ?');

		if (!$stmt->execute(array($data->repairid)))
			return false;

		$out = array();

		foreach($stmt->fetchAll() as $row)
		{
			$eid = $row["equipmentid"];
			$out[$eid] = array();
			foreach($row as $key => $value)
			{
				if (!is_numeric($key))
					$out[$eid][$key] = $value;
			}
		}
		return $out;
	}
}
?>
