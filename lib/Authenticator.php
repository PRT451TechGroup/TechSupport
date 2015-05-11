<?php
class Authenticator
{
	private $hash;
	private $salt;
	
	protected function __construct($hash, $salt)
	{
		$this->hash = $hash;
		$this->salt = $salt;
	}
	public static function from_password($password, $salt = null)
	{
		if (!isset($salt))
		{
			$salt = base64_encode(openssl_random_pseudo_bytes(128));
		}
		return new Authenticator(hash("sha256", $salt.$password), $salt);
	}
	public static function from_hash($hash, $salt)
	{
		return new Authenticator($has, $salt);
	}
	public function hash($val = null)
	{
		if (isset($val))
		{
			$this->hash = val;
			return $this;
		}
		else
			return $this->hash;
	}
	public function salt($val = null)
	{
		if (isset($val))
		{
			$this->salt = val;
			return $this;
		}
		else
			return $this->salt;
	}
	public function verify($password)
	{
		return hash("sha256", ($this->salt).$password) == $this->hash;
	}
}
?>
