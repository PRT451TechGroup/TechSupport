<?php
namespace Data\Table;
class Repairs
{
	private $conn;
	public function __construct($conn)
	{
		$this->conn = $conn;
	}
	public function countPrioritiesByCompletion()
	{
		$stmt = $this->conn->prepare("SELECT completion, COUNT(repairid) AS count FROM repairs WHERE completion >= 0 AND priority > 0 GROUP BY completion");
		if ($stmt->execute())
		{
			$out = array_fill(0, 5, 0);
			while(list($completion, $count) = $stmt->fetch(\PDO::FETCH_NUM))
			{
				$out[intval($completion)] = intval($count);
			}
			return $out;
		}
	}
	public function selectRepairsByCompletion($completion)
	{
		$stmt = $this->conn->prepare("SELECT * FROM repairs WHERE completion = ?");

		if ($stmt->execute(array($completion)))
		{
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
	}
	public function selectRepairById($id)
	{
		$stmt = $this->conn->prepare("SELECT * FROM repairs WHERE repairid=?");
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC) + $this->selectEquipmentCountByRepairId($id);
		/*$stmt = $this->conn->prepare("SELECT repairs.*, COUNT FROM repairs WHERE repairid=?");
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC) + $this->selectEquipmentCountByRepairId($id);*/
			
	}
	public function selectEquipmentCountByRepairId($id)
	{
		$stmt = $this->conn->prepare("SELECT COUNT(equipmentid) AS equipmentcount FROM repairequipment WHERE repairid=?");
		
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC) ?: array("equipmentcount" => "0");
	}
	public function selectEquipmentByRepairId($id)
	{
		$stmt = $this->conn->prepare(
			"SELECT re.repairid AS repairid, e.equipmentid AS equipmentid, e.equipmentname AS equipmentname, e.assetno AS assetno, re.description AS description ".
			"FROM repairequipment AS re, equipment AS e ".
			"WHERE re.repairid=? AND re.equipmentid=e.equipmentid");

		if ($stmt->execute(array($id)))
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function selectEquipmentById($equipmentid)
	{
		$stmt = $this->conn->prepare(
			"SELECT re.repairid AS repairid, e.equipmentid AS equipmentid, e.equipmentname AS equipmentname, e.assetno AS assetno, re.description AS description ".
			"FROM repairequipment AS re, equipment AS e ".
			"WHERE re.equipmentid=? AND re.equipmentid=e.equipmentid");

		if ($stmt->execute(array($equipmentid)))
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function insertRepair($userid)
	{
		$stmt = $this->conn->prepare("INSERT INTO repairs (userid) VALUES (?)");
		if ($stmt->execute(array($userid)))
			return $this->conn->lastInsertId();
	}
	public function insertEquipment($repairid, $equipment)
	{
		if ($this->conn->prepare("INSERT INTO equipment (equipmentname, assetno) VALUES (?, ?)")->execute(array($equipment["equipmentname"], $equipment["assetno"])))
		{
			$equipmentid = $this->conn->lastInsertId();
			$this->conn->prepare("INSERT INTO repairequipment (repairid, equipmentid, description) VALUES (?, ?, ?)")->execute(array($repairid, $equipmentid, $equipment["description"]));
			return $equipmentid;
		}
	}
	public function updateRepair($id, $repair)
	{
		$props = array("name", "complainer", "location", "duedate", "completion", "priority");
		$vals = array();
		foreach($props as $fieldName)
		{
			$vals[":$fieldName"] = $repair[$fieldName];
		}
		$vals[":repairid"] = $id;

		$setlist = implode(",", array_map(function($k) { return "$k=:$k"; }, $props));

		$stmt = $this->conn->prepare("UPDATE repairs SET $setlist WHERE repairid=:repairid");

		return $stmt->execute($vals);
	}
	public function updateEquipment($equipmentid, $equipment)
	{
		return $this->conn->prepare("UPDATE equipment SET equipmentname=?,assetno=? WHERE equipmentid=?")->execute(array($equipment["equipmentname"], $equipment["assetno"], $equipmentid)) &&
			$this->conn->prepare("UPDATE repairequipment SET description=? WHERE equipmentid=?")->execute(array($equipment["description"], $equipmentid));
	}
	public function deleteEquipmentById($equipmentid)
	{
		return $this->conn->prepare("DELETE FROM repairequipment WHERE equipmentid=?")->execute(array($equipmentid)) &&
			$this->conn->prepare("DELETE FROM equipment WHERE equipmentid=?")->execute(array($equipmentid));
	}
}
?>
