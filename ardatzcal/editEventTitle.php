<?php
// Conexion a la base de datos
include_once "../dbconfig.php";

if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];
	
	$eventsCrud->deleteEvent($id);
	
}elseif (isset($_POST['title']) && isset($_POST['type']) && isset($_POST['id'])){
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$type = $_POST['type'];
	
	$eventsCrud->updateEventTitle($id, $title, $type);

}
header('Location: ../calendar_ardatz.php');

	
?>