<?php
namespace Data\Table;
class Loans
{
	private $conn;
	public function __construct($conn)
	{
		$this->conn = $conn;
	}
	public function selectLoanById($id)
	{
		$stmt = $this->conn->prepare("SELECT * FROM loans WHERE loanid = ?");
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC) + $this->selectEquipmentCountByLoanId($id);
	}
	public function selectLoans()
	{
		$stmt = $this->conn->prepare("SELECT * FROM loans");
		if ($stmt->execute(array()))
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function selectEquipmentCountByLoanId($id)
	{
		$stmt = $this->conn->prepare("SELECT COUNT(equipmentid) AS equipmentcount FROM loanequipment WHERE loanid=?");
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		
	}
	public function selectEquipmentByLoanId($id)
	{
		$stmt = $this->conn->prepare(
			"SELECT le.loanid AS loanid, e.equipmentid AS equipmentid, e.equipmentname AS equipmentname, e.assetno AS assetno ".
			"FROM loanequipment AS le, equipment AS e ".
			"WHERE le.loanid=? AND le.equipmentid=e.equipmentid");

		if ($stmt->execute(array($id)))
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function selectEquipmentById($loanid, $equipmentid)
	{
		$stmt = $this->conn->prepare(
			"SELECT le.loanid AS loanid, e.equipmentid AS equipmentid, e.equipmentname AS equipmentname, e.assetno AS assetno ".
			"FROM loanequipment AS le, equipment AS e ".
			"WHERE le.loanid=? AND le.equipmentid=? AND le.equipmentid=e.equipmentid");

		if ($stmt->execute(array($loanid, $equipmentid)))
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function insertLoan($userid)
	{
		$stmt = $this->conn->prepare("INSERT INTO loans (userid) VALUES (?)");
		if ($stmt->execute(array($userid)))
			return $this->conn->lastInsertId();
	}
	public function insertEquipment($loanid)
	{
		if ($this->conn->prepare("INSERT INTO equipment () VALUES ()")->execute())
		{
			$equipmentid = $this->conn->lastInsertId();
			$this->conn->prepare("INSERT INTO loanequipment (loanid, equipmentid) VALUES (?, ?)")->execute(array($loanid, $equipmentid));
			return $equipmentid;
		}
	}
	public function updateLoan($id, $loan)
	{
		$stmt = $this->conn->prepare(
			"UPDATE loans ".
			"SET userid=?,loanername=?,staffname=?,loandate=?,returndate=?,completion=? ".
			"WHERE loanid=?");
		return $stmt->execute(array($loan["userid"], $loan["loanername"], $loan["staffname"], $loan["loandate"], $loan["returndate"], $loan["completion"], $id));
	}
}
?>
