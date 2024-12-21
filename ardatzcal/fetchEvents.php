<?php
    include_once "../dbconfig.php";
	
	if(isset($_GET['get-events'])){
		
		$startDate = $_POST['start'];
		$endDate = $_POST['end'];
		echo $eventsCrud->searchEvents($startDate, $endDate);
	}
?>