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
	public function open_connection()
	{
		return new PDO($this->pdo_dsn, $this->pdo_username, $this->pdo_password, $this->pdo_options);
	}
	private function prepare($stmt)
	{
		return $this->open_connection()->prepare($stmt);
	}
	private function execute($sql, $data)
	{
		return $this->prepare($sql)->execute($data);
	}
	private function insert($sql, $data)
	{
		$conn = $this->open_connection();
		$stmt = $conn->prepare($sql);

		if (!$stmt->execute($data))
			return false;

		return $conn->lastInsertId();
	}
	private function select($sql, $data)
	{
		$stmt = $this->prepare($sql);

		if (!$stmt->execute($data))
			return false;

		return $stmt->fetchAll();
	}
	public function datasource_init()
	{
	}
	public function datasource_create()
	{
	}
	private static function rowcopy($row)
	{
		$out = array();

		foreach($row as $key => $value)
		{
			if (!is_numeric($key))
				$out[$key] = $value;
		}
		
		return $out;
	}
	private static function tablecopy($table, $indexfield)
	{
		$out = array();

		foreach($table as $row)
		{
			$out[$row[$indexfield]] = self::rowcopy($row);
		}

		return $out;
	}

	public function user_login($args)
	{
		$data = new ArrayList($args);
		
		if (!$data->containsKey("username", "password"))
			return false;

		if (strlen($data->username) === 0 || strlen($data->password) === 0)
			return false;

		$res = $this->select
		(
			'SELECT userid, hash, salt FROM users WHERE username = ?',
			array($data->username)
		);

		if (!$res)
			return false;

		
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

		$auth = Authenticator::from_password($data->password);

		return $this->insert
		(
			'INSERT INTO users (username, hash, salt) VALUES (?, ?, ?)',
			array($data->username, $auth->hash(), $auth->salt())
		);
		
	}
	public function user_name($args)
	{
		$data = new ArrayList($args);
		
		if (!$data->containsKey("userid"))
			return false;


		$res = $this->select
		(
			'SELECT username FROM users WHERE userid = ?',
			array(intval($data->userid))
		);
		if (!$res)
			return false;
		foreach($res as $row)
		{
			return $row["username"];
		}
		return false;
	}
	public function user_names()
	{
		$res = $this->select
		(
			'SELECT userid, username FROM users',
			array()
		);

		if (!$res)
			return false;

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
			

		if ($data->containsKey("userid", "complainer", "name", "location", "duedate", "completion", "priority"))
		{
			$sql = "INSERT INTO repairs (userid, name, complainer, location, duedate, completion, priority) VALUES (?, ?, ?, ?, ?, ?)";
			$vals = array($data->userid, $data->name, $data->complainer, $data->location, $data->duedate, $data->completion, $data->priority);
		}
		else
		{
			$sql = "INSERT INTO repairs (userid) VALUES (?)";
			$vals = array($data->userid);
		}

		return $this->insert($sql, $vals);
	}
	public function repair_get($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("repairid"))
		{
			throw new InvalidArgumentException("repairid not supplied");
			return false;
		}

		$out = array();

		foreach($this->select
		(
			'SELECT * FROM repairs WHERE repairid = ?',
			array($data->repairid)
		) as $row)
		{
			$out = static::rowcopy($row);

			foreach($this->select
			(
				'SELECT COUNT(equipmentid) AS equipmentcount FROM repairequipment WHERE repairid = ?',
				array($data->repairid)
			) as $crow)
			{
				$out["equipmentcount"] = $crow["equipmentcount"];
			}
			
			return $out;
		}
		return false;
	}
	public function repair_completion()
	{
		return static::tablecopy($this->select
		(
			'SELECT completion, COUNT(repairid) AS repaircount, SUM(CASE WHEN priority > 0 THEN 1 ELSE 0 END) AS prioritycount FROM repairs GROUP BY completion',
			array()
		), "completion");
	}
	public function repair_list($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("completion"))
		{
			$sql = "SELECT * FROM repairs";
			$vals = array();
		}
		else
		{
			$sql = "SELECT * FROM repairs WHERE completion = ?";
			$vals = array($data->completion);
		}

		return static::tablecopy($this->select($sql, $vals), "repairid");
	}
	public function repair_modify($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("repairid"))
		{
			throw new InvalidArgumentException("repairid not supplied");
			return false;
		}
		if ($data->containsKey("name", "complainer", "location", "duedate", "completion", "priority"))
		{
			if ($data->containsKey("userid"))
			{
				$sql = "UPDATE repairs SET userid=?, name=?, complainer=?, location=?, duedate=?, completion=?, priority=? WHERE repairid=?";
				$vals = array($data->userid, $data->name, $data->complainer, $data->location, $data->duedate, $data->completion, $data->priority, $data->repairid);
			}
			else
			{
				$sql = "UPDATE repairs SET name=?, complainer=?, location=?, duedate=?, completion=?, priority=? WHERE repairid=?";
				$vals = array($data->name, $data->complainer, $data->location, $data->duedate, $data->completion, $data->priority, $data->repairid);
			}
		}
		else
		{
			throw new InvalidArgumentException("not enough columns supplied");
			return false;
		}

		return $this->execute($sql, $vals);

	}
	public function repair_delete($args)
	{
		$data = new ArrayList($args);
		return
			$this->execute('DELETE FROM repairequipment WHERE repairid=?', array($data->repairid)) &&
			$this->execute('DELETE FROM repairs WHERE repairid=?', array($data->repairid));
	}

	public function repairequipment_list($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("repairid"))
		{
			throw new InvalidArgumentException("repairid not supplied");
			return false;
		}
		
		$out = array();

		return static::tablecopy($this->select
		(
			'SELECT e.equipmentid AS equipmentid, e.equipmentname AS equipmentname, e.assetno AS assetno, re.description AS description FROM equipment AS e, repairequipment AS re WHERE re.repairid = ? AND e.equipmentid = re.equipmentid',
			array($data->repairid)
		), "equipmentid");
	}
	public function equipment_new($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("equipmentname", "assetno"))
		{
			throw new InvalidArgumentException("not enough columns supplied");
		}

		return $this->insert
		(
			'INSERT INTO equipment (equipmentname, assetno) VALUES (?, ?)',
			array($data->equipmentname, $data->assetno)
		);
	}
	public function repairequipment_new($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("description"))
		{
			throw new InvalidArgumentException("not enough columns supplied");
		}

		$equipmentid = $this->equipment_new($args);
		$this->insert
		(
			'INSERT INTO repairequipment (repairid, equipmentid, description) VALUES (?, ?, ?)',
			array($data->repairid, $equipmentid, $data->description)
		);

		return $equipmentid;
	}
	public function equipment_get($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("equipmentid"))
		{
			throw new InvalidArgumentException("equipmentid not supplied");
		}

		foreach($this->select
		(
			'SELECT * FROM equipment WHERE equipmentid = ?',
			array($data->equipmentid)
		) as $row)
		{
			return static::rowcopy($row);
		}
		return false;
	}
	public function repairequipment_get($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("equipmentid", "repairid"))
		{
			throw new InvalidArgumentException("not enough columns supplied");
		}

		foreach($this->select
		(
			'SELECT e.equipmentid AS equipmentid, e.equipmentname AS equipmentname, e.assetno AS assetno, re.description AS description '.
			'FROM equipment AS e, repairequipment AS re '.
			'WHERE re.equipmentid = ? AND e.equipmentid = e.equipmentid AND re.repairid = ?',
			array($data->equipmentid, $data->repairid)
		) as $row)
		{
			return static::rowcopy($row);
		}
		return false;
	}
	public function repairequipment_delete($args)
	{
		$data = new ArrayList($args);
		$rv = $this->execute('DELETE FROM repairequipment WHERE repairid=? AND equipmentid=?', array($data->repairid, $data->equipmentid)) &&
			$this->execute('DELETE FROM equipment WHERE equipmentid=?', array($data->equipmentid));
		if (!$rv)
			throw new Exception($rv);
		return $rv;
	}
	public function equipment_delete($args)
	{
		$data = new ArrayList($args);
		$rv = $this->execute('DELETE FROM equipment WHERE equipmentid=?', array($data->equipmentid));
		if (!$rv)
			throw new Exception($rv);
		return $rv;
	}
	public function repairequipment_modify($args)
	{
		$data = new ArrayList($args);

		if (!$data->containsKey("repairid"))
		{
			throw new InvalidArgumentException("repairid not supplied");
		}
		if (!$data->containsKey("description"))
		{
			throw new InvalidArgumentException("not enough columns supplied");
		}

		return $this->equipment_modify($args) &&
		$this->execute
		(
			'UPDATE repairequipment SET description=? WHERE repairid=? AND equipmentid=?',
			array($data->description, $data->repairid, $data->equipmentid)
		);
	}
	public function equipment_modify($args)
	{
		$data = new ArrayList($args);


		if (!$data->containsKey("equipmentid"))
		{
			throw new InvalidArgumentException("equipmentid not supplied");
		}
		if (!$data->containsKey("equipmentname", "assetno"))
		{
			throw new InvalidArgumentException("not enough columns supplied");
		}

		return $this->execute
		(
			'UPDATE equipment SET equipmentname=?, assetno=? WHERE equipmentid=?',
			array($data->equipmentname, $data->assetno, $data->equipmentid)
		);
	}
}
?>
