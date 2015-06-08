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
			//throw new \Exception($ct[0]);
			return $this->categoryOf($ct[0]);
		}
	}
	public function deleteLoanById($id)
	{
		return $this->conn->prepare("DELETE FROM loanequipment WHERE loanid=?")->execute(array($id)) &&
			$this->conn->prepare("DELETE FROM loans WHERE loanid=?")->execute(array($id));
	}
	public function categoryOf($daydiff)
	{
		$daydiff = intval($daydiff);
		foreach($this->dueCategories as $categoryIndex => $categoryExpression)
		{
			if (preg_match('/^(?P<operator>\<|\>|\<=|\>=|=|<>) (?P<value>-?\d+)$/', $categoryExpression, $matches))
			{
				$value = intval($matches["value"]);
				$testFunc = function($daydiff, $operator, $value)
				{
					switch($operator)
					{
						case "<": return $daydiff < $value;
						case "<=": return $daydiff <= $value;
						case ">": return $daydiff > $value;
						case ">=": return $daydiff >= $value;
						case "=": return $daydiff == $value;
						case "<>": return $daydiff != $value;
					}
				};
				if ($testFunc($daydiff, $matches["operator"], $value))
					return $categoryIndex;
			}
			elseif (preg_match('/^BETWEEN (?P<min>-?\d+) AND (?P<max>-?\d+)$/', $categoryExpression, $matches))
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
			$stmt = $this->conn->prepare("SELECT COUNT(loanid) AS loancount FROM loans WHERE completion = 0 AND DATEDIFF(returndate, CURDATE()) $value");
			$stmt->execute();
			$cnt = $stmt->fetch(\PDO::FETCH_ASSOC);
			$out[] = $cnt["loancount"];
		}
		return $out;
	}
	public function selectLoansByCategory($cat)
	{
		$dcc = $this->dueCategories[$cat];
		$sql =  " SELECT loans.*, COUNT(loanequipment.loanid) AS equipmentcount".
			" FROM loans".
			" LEFT OUTER JOIN loanequipment".
			" ON loanequipment.loanid=loans.loanid".
			" WHERE loans.completion = 0 AND DATEDIFF(loans.returndate, CURDATE()) $dcc".
			" GROUP BY loans.loanid ".
			" ORDER BY loans.priority DESC, loans.returndate ASC ";
		$stmt = $this->conn->prepare($sql);

		if ($stmt->execute())
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function selectLoanById($id)
	{
		$stmt = $this->conn->prepare(
			" SELECT loans.*, DATEDIFF(loans.returndate, CURDATE()) AS daydiff, COUNT(loanequipment.loanid) AS equipmentcount".
			" FROM loans".
			" LEFT OUTER JOIN loanequipment".
			" ON loanequipment.loanid=loans.loanid".
			" WHERE loans.loanid = ?");
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function selectLoans($limit = 1000)
	{
		$sql =  " SELECT loans.*, DATEDIFF(loans.returndate, CURDATE()) AS daydiff, COUNT(loanequipment.loanid) AS equipmentcount".
			" FROM loans".
			" LEFT OUTER JOIN loanequipment".
			" ON loanequipment.loanid=loans.loanid".
			" WHERE loans.completion = 0".
			" GROUP BY loans.loanid ".
			" ORDER BY loans.returndate ASC, loans.priority DESC".
			" LIMIT $limit";
		$stmt = $this->conn->prepare($sql);

		if ($stmt->execute())
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function selectCompletedLoans($limit = 1000)
	{
		$sql =  " SELECT loans.*, DATEDIFF(loans.returndate, CURDATE()) AS daydiff, COUNT(loanequipment.loanid) AS equipmentcount".
			" FROM loans".
			" LEFT OUTER JOIN loanequipment".
			" ON loanequipment.loanid=loans.loanid".
			" WHERE loans.completion = 1".
			" GROUP BY loans.loanid ".
			" ORDER BY loans.returndate ASC, loans.priority DESC".
			" LIMIT $limit";
		$stmt = $this->conn->prepare($sql);

		if ($stmt->execute())
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function selectEquipmentCountByLoanId($id)
	{
		$stmt = $this->conn->prepare("SELECT COUNT(equipmentid) AS equipmentcount FROM loanequipment WHERE loanid=?");
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC) ?: array("equipmentcount" => "0");
		
	}
	public function selectEquipmentByLoanId($id)
	{
		$stmt = $this->conn->prepare(
			" SELECT le.loanid, e.*".
			" FROM loanequipment AS le, equipment AS e".
			" WHERE le.loanid=? AND le.equipmentid=e.equipmentid");

		if ($stmt->execute(array($id)))
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function selectEquipmentById($equipmentid)
	{
		$stmt = $this->conn->prepare(
			" SELECT le.loanid, e.* ".
			" FROM loanequipment AS le, equipment AS e ".
			" WHERE le.equipmentid=? AND le.equipmentid=e.equipmentid");

		if ($stmt->execute(array($equipmentid)))
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
			" UPDATE equipment".
			" SET equipmentname=?,assetno=?".
			" WHERE equipmentid=?");

		return $stmt->execute(array($equipment["equipmentname"], $equipment["assetno"], $equipmentid));
	}
	public function deleteEquipmentById($equipmentid)
	{
		return $this->conn->prepare("DELETE FROM loanequipment WHERE equipmentid=?")->execute(array($equipmentid)) &&
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
	/*
	public function updateLoan($id, $loan)
	{
		$stmt = $this->conn->prepare(
			"UPDATE loans ".
			"SET creditor=?,debtor=?,loandate=?,returndate=?,priority=?,completion=? ".
			"WHERE loanid=?");
		return $stmt->execute(array($loan["creditor"], $loan["debtor"], $loan["loandate"], $loan["returndate"], $loan["priority"], $loan["completion"], $id));
	}*/
	public function updateLoan($id, $loan, $ignoreprops = null)
	{
		$props = array("creditor", "debtor", "loandate", "returndate", "priority", "completion");
		if (!is_null($ignoreprops))
		{
			$props = array_filter($props, function($val) use($ignoreprops)
			{
				return array_search($val, $ignoreprops) === FALSE;
			});
		}
		
		$vals = array();
		foreach($props as $fieldName)
		{
			$vals[":$fieldName"] = $loan[$fieldName];
		}
		$vals[":loanid"] = $id;

		$setlist = implode(",", array_map(function($k) { return "$k=:$k"; }, $props));

		$stmt = $this->conn->prepare("UPDATE loans SET $setlist WHERE loanid=:loanid");

		return $stmt->execute($vals);
	}
}
?>
