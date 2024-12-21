<?php session_start(); ?>

<?php

//Including Database configuration file.

include_once "dbconfig.php";



if(isset($_GET['alter_days'])){
	
	$egunak = $_POST['egunak'];
	$ikaslea_id = $_POST['ikaslea_id'];
	
	echo $ikasleCrud->setKlaseEgunak($egunak, $ikaslea_id); 
	
}else if(isset($_GET['asteko_egunak'])){
	$ikasleId = $_POST['ikasleId'];
	error_log("ID: ".$ikasleId);
	echo $ikasleCrud->getAstekoEgunak($ikasleId);
}




?>