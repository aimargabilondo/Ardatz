<?php
    include_once "../dbconfig.php";
	
	
	
	
	if(isset($_GET['get-events'])){
		
		$startDate = $_POST['start'];
		$endDate = $_POST['end'];
		$ikasleId = $_POST['ikasleId'];
		if($ikasleId == ''){
			$ikasleId = 0;
		}

		$json = array();
		$sqlQuery = "
			SELECT 
				egunerokoa.id as egunerokoaId,
				ikasgai.name as title,
				egunerokoa.creation_date as start,
				ADDDATE(egunerokoa.creation_date, interval 1 hour) as end,
				date_format(egunerokoa.creation_date, '%Y-%m-%d') as startFormated,
				date_format(ADDDATE(egunerokoa.creation_date, interval 1 hour), '%Y-%m-%d') as endFormated,
				egunerokoa.ikasgai_id as ikasgaiId,
				ikasgai.color as ikasgaiColor
			FROM tbl_egunerokoa egunerokoa  
			LEFT JOIN tbl_ikasgai ikasgai ON egunerokoa.ikasgai_id = ikasgai.id 
			WHERE egunerokoa.creation_date BETWEEN '$startDate' AND '$endDate' 
			AND egunerokoa.ikaslea_id = $ikasleId
			 ";

		$stmt = $DB_con->query($sqlQuery);
		$eventArray = array();
		while ($Result = $stmt->fetch()) {
			 array_push($eventArray, $Result);
		}
		echo json_encode($eventArray);
		
		
	}else if(isset($_GET['show-modal'])){
		$idEgunerokoa = $_POST['idEgunerokoa'];
		$egunerokoaCrud->egunerokoaModal($idEgunerokoa);
	}
?>