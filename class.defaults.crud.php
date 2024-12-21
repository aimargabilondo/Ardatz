<?php

class DefaultsCrud // la class des operations avec la base de données.
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}

	public function getValueByGelaAndParamName($gela, $param_name) 
	{
		$stmt = $this->db->prepare("SELECT value FROM tbl_defaults WHERE param=:param_name AND gela=:gela");
		$stmt->bindparam(":gela", $gela);
		$stmt->bindparam(":param_name", $param_name);
		$stmt->execute();
		if($stmt->rowCount() > 0) 
		{
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			return $row['value'];
		}else{
			return '';
		}
		
	}
	
	public function getValueByIrakasleIdAndParamName($irakasleId, $param_name) 
	{
		$stmt = $this->db->prepare("SELECT value FROM tbl_defaults WHERE param=:param_name AND irakasle_id=:irakasleId");
		$stmt->bindparam(":irakasleId", $irakasleId);
		$stmt->bindparam(":param_name", $param_name);
		$stmt->execute();
		if($stmt->rowCount() > 0) 
		{
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			return $row['value'];
		}else{
			return '-1';
		}
		
	}
}
?>