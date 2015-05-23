<?php
namespace Data\Table;
class Loans
{
	private $conn;
	public $dueCategories = array("< 0", "= 0", "BETWEEN 1 AND 7", "BETWEEN 8 AND 31", "> 31");
	public function __construct($conn)
	{
		$this->conn = $conn;
	}
	public function getCategoryById($id)
	{
		$stmt = $this->conn->prepare("SELECT DATEDIFF(returndate, CURDATE()) AS daydiff FROM loans WHERE loanid = ?");
		if ($stmt->execute(array($id)))
		{
			$ct = $stmt->fetch(\PDO::FETCH_NUM);
			if (preg_match('/^(?P<operator>\<|\>|\<=|\>=|=|<>) (?P<value>-?\d+)$/', $categoryExpression, $matches))
			{
				$value = intval($matches["value"]);
				{
					switch($operator)
					{
						case "<=": return $daydiff <= $value;
						case ">": return $daydiff > $value;
						case ">=": return $daydiff >= $value;
						case "=": return $daydiff == $value;
						case "<>": return $daydiff != $value;
					}
				};
					return $categoryIndex;
			}
			{
				list($min, $max) = array(intval($matches["min"]), intval($matches["max"]));
				if ($min <= $daydiff && $daydiff <= $max)
					return $categoryIndex;
			}
		}
	}
	public function countLoansByCategory()
	{
		$out = array();
		foreach($this->dueCategories as $value)
		{
			$stmt = $this->conn->prepare("SELECT COUNT(loanid) AS loancount FROM loans WHERE completion >= 0 AND DATEDIFF(returndate, CURDATE()) $value");
			$stmt->execute();
			$cnt = $stmt->fetch(\PDO::FETCH_ASSOC);
			$out[] = $cnt["loancount"];
		}
		return $out;
	}
	public function selectLoansByCategory($cat)
	{
		$dcc = $this->dueCategories[$cat];
		$stmt = $this->conn->prepare("SELECT * FROM loans WHERE completion >= 0 AND DATEDIFF(returndate, CURDATE()) $dcc");
		if ($stmt->execute())
		{
			$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			// map loan id to row index
			$loanids = array();
			$idlist = "";
			foreach($rows as $rowKey => $rowValue)
			{
				$rows[$rowKey]["equipmentcount"] = "0";
				$loanids[$rowValue["loanid"]] = $rowKey;
				

				if (strlen($idlist) > 0)
					$idlist .= ",".$rowValue["loanid"];
				else
					$idlist .= $rowValue["loanid"];
			}
			//throw new \Exception($idlist);

			if (strlen($idlist) > 0)
			{
				$countStatement = $this->conn->prepare("SELECT loanid, COUNT(equipmentid) FROM loanequipment WHERE loanid in ($idlist) GROUP BY loanid");
				$countStatement->execute();
				while(list($loanid, $equipmentcount) = $countStatement->fetch(\PDO::FETCH_NUM))
				{
					$rows[$loanids[$loanid]]["equipmentcount"] = $equipmentcount;
				}
			}

			return $rows;
		}
	}
	public function selectLoanById($id)
	{
		$stmt = $this->conn->prepare("SELECT *, DATEDIFF(returndate, CURDATE()) AS daydiff FROM loans WHERE loanid = ?");
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC) + $this->selectEquipmentCountByLoanId($id);
	}
	public function selectLoans()
	{
		$stmt = $this->conn->prepare("SELECT * FROM loans WHERE completion >= 0");
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
	public function updateEquipment($equipmentid, $equipment)
	{
		$stmt = $this->conn->prepare(
			"UPDATE equipment ".
			"SET equipmentname=?,assetno=? ".
			"WHERE equipmentid=?");

		return $stmt->execute(array($equipment["equipmentname"], $equipment["assetno"], $equipmentid));
	}
	public function deleteEquipmentById($loanid, $equipmentid)
	{
		return $this->conn->prepare("DELETE FROM loanequipment WHERE loanid=? AND equipmentid=?")->execute(array($loanid, $equipmentid)) &&
			$this->conn->prepare("DELETE FROM equipment WHERE equipmentid=?")->execute(array($equipmentid));
	}
	public function insertEquipment($loanid, $equipment)
	{
		if ($this->conn->prepare("INSERT INTO equipment (equipmentname, assetno) VALUES (?, ?)")->execute(array($equipment["equipmentname"], $equipment["assetno"])))
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
