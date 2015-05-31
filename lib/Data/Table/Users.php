<?php
namespace Data\Table;
class Users
{
	private $conn;
	public function __construct($conn)
	{
		$this->conn = $conn;
	}
	public function selectUserIdByCredentials($username, $password)
	{
		$stmt = $this->conn->prepare("SELECT userid, hash, salt FROM users WHERE username = ?");
		if ($stmt->execute(array($username)))
		{
			while(list($userid, $hash, $salt) = $stmt->fetch(\PDO::FETCH_NUM))
			{
				$auth = \Authenticator::from_hash($hash, $salt);
				if ($auth->verify($password))
					return intval($userid);
			}
		}
		return false;
	}
	public function insertUser($username, $password, $email)
	{
		$stmt = $this->conn->prepare("INSERT INTO users (username, email, hash, salt) VALUES (?, ?, ?, ?)");
		$auth = \Authenticator::from_password($password);

		try
		{
			if ($stmt->execute(array($username, $email, $auth->hash(), $auth->salt())))
				return $this->conn->lastInsertId();
		}
		catch(\PDOException $e)
		{
			foreach($e->errorInfo as $errcode)
			{
				if ($errcode == 1062)
					return false;
			}
			throw $e;
		}
	}
	public function selectUsernameById($userid)
	{
		$stmt = $this->conn->prepare("SELECT username FROM users WHERE userid=?");
		if ($stmt->execute(array($userid)))
		{
			while(list($username) = $stmt->fetch(\PDO::FETCH_NUM))
				return $username;
		}
		return false;
	}
	public function listUsernames()
	{
		$stmt = $this->conn->prepare("SELECT userid, username FROM users");
		if ($stmt->execute())
		{
			$lst = array();
			while(list($userid, $username) = $stmt->fetch(\PDO::FETCH_NUM))
			{
				$lst[$userid] = $username;
			}
			return $lst;
		}
	}
	public function resetPassword($username, $email)
	{
		$code = base64_encode(openssl_random_pseudo_bytes(16));
		$stmt = $this->conn->prepare("UPDATE users SET resetcode=?,resetexpire=DATE_ADD(NOW(), INTERVAL 24 HOUR) WHERE (username=? AND email=? AND resetexpire < DATE_ADD(NOW(), INTERVAL 23 HOUR)) OR (resetexpire IS NULL AND resetcode IS NULL)");
		if ($stmt->execute(array($code, $username, $email)))
		{
			$stmt = $this->conn->prepare("SELECT userid, username, email, resetcode FROM users WHERE username=? AND email=? AND resetcode=?");
			if ($stmt->execute(array($username, $email, $code)))
				return $stmt->fetch(\PDO::FETCH_ASSOC) ?: false;
		}
		return false;
	}
}
?>
