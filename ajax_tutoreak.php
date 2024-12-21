<?php session_start(); ?>

<?php

//Including Database configuration file.

include_once "dbconfig.php";



if(isset($_GET['check_tutore'])){
	
	$irakaslea_id = $_POST['irakaslea_id'];
	$ikaslea_id = $_POST['ikaslea_id'];
	
	echo $ikasleCrud->altaTutor($irakaslea_id, $ikaslea_id); 
	
}else if(isset($_GET['uncheck_tutore'])){
	
	$irakaslea_id = $_POST['irakaslea_id'];
	$ikaslea_id = $_POST['ikaslea_id'];
	
	echo $ikasleCrud->bajaTutor($irakaslea_id, $ikaslea_id);
	
}




?>