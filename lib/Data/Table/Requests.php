<?php
namespace Data\Table;
class Requests
{
	private $conn;
	public function __construct($conn)
	{
		$this->conn = $conn;
	}
	public function deleteRequestById($id)
	{
		return $this->conn->prepare("DELETE FROM requests WHERE requestid=?")->execute(array($id));
	}
	public function selectRequestById($id)
	{
		$stmt = $this->conn->prepare("SELECT *, DATEDIFF(duedate, CURDATE()) AS daydiff FROM requests WHERE requestid=?");
		if ($stmt->execute(array($id)))
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function selectRequests($userid)
	{
		$sql =  "SELECT *, DATEDIFF(duedate, CURDATE()) AS daydiff FROM requests WHERE userid=? AND completed=0 ORDER BY duedate ASC";
		$stmt = $this->conn->prepare($sql);

		if ($stmt->execute(array($userid)))
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function selectCompletedRequests($userid)
	{
		$sql =  "SELECT *, DATEDIFF(duedate, CURDATE()) AS daydiff FROM requests WHERE userid=? AND completed=1 ORDER BY duedate ASC";
		$stmt = $this->conn->prepare($sql);

		if ($stmt->execute(array($userid)))
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function insertRequest($userid, $request)
	{
		$stmt = $this->conn->prepare("INSERT INTO requests (userid, techname, staffname, requirements, location, duedate, priority, completed) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		if ($stmt->execute(array($userid, $request["techname"], $request["staffname"], $request["requirements"], $request["location"], $request["duedate"], $request["priority"], $request["completed"])))
			return $this->conn->lastInsertId();
	}
	public function updateRequest($id, $request)
	{
		$stmt = $this->conn->prepare(
			" UPDATE requests".
			" SET techname=?,staffname=?,requirements=?,location=?,duedate=?,priority=?,completed=?".
			" WHERE requestid=?");
		return $stmt->execute(array($request["techname"], $request["staffname"], $request["requirements"], $request["location"], $request["duedate"], $request["priority"], $request["completed"], $id));
	}
}
?>
