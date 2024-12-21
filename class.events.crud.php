<?php

class EventsCrud
{
	private $db;
	
	
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
		
	public function searchEvents($startDate, $endDate)
	{
		$json = array();
		$sqlQuery = "
			SELECT id, title, start, end, type
			FROM tbl_calendar_events  
			WHERE start BETWEEN '$startDate' AND '$endDate' ";

		$stmt = $this->db->query($sqlQuery);
		$eventArray = array();
		while ($Result = $stmt->fetch()) {
			 array_push($eventArray, $Result);
		}
		return json_encode($eventArray);
	}	
	
	
	public function addEvent($title, $start, $end, $type)
	{


		$sql = "INSERT INTO tbl_calendar_events(title, start, end, type) values ('$title', '$start', '$end', '$type'); ";
		
		echo $sql;
		
		$query = $this->db->prepare( $sql );
		$sth = $query->execute();
	}
	
	
	public function updateEventTitle($id, $title, $type)
	{

		$sql = "UPDATE tbl_calendar_events SET  title = '$title', type = '$type' WHERE id = $id; ";
		
		//echo $sql;
		
		$query = $this->db->prepare( $sql );
		$sth = $query->execute();
	}
	
	public function updateEventDate($id, $start, $end)
	{


		$sql = "UPDATE tbl_calendar_events SET  start = '$start', end = '$end' WHERE id = $id ";
		
		//echo $sql;
		
		$query = $this->db->prepare( $sql );
		$sth = $query->execute();
	}
	
	public function deleteEvent($id)
	{


		$sql = "DELETE FROM tbl_calendar_events WHERE id = $id";
		
		//echo $sql;
		
		$query = $this->db->prepare( $sql );
		$sth = $query->execute();
	}
	

}
?>