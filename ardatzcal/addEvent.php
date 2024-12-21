<?php

// Conexion a la base de datos
include_once "../dbconfig.php";

if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['type'])){
	
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$type = $_POST['type'];
	
	$eventsCrud->addEvent($title, $start, $end, $type);

}

header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>