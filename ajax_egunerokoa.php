<?php session_start(); ?>

<?php

//Including Database configuration file.

include_once "dbconfig.php";



if(isset($_GET['save_egunerokoa'])){
	
	$irakaslea_id = $_SESSION['id'];
	$mahai_id = $_POST['mahai_id'];
	$ikasle = $_POST['ikasle'];
	$ikasle_id = $_POST['ikasle_id'];
	$ikasgai = $_POST['ikasgai'];
	$ikasgai_id = $_POST['ikasgai_id'];
	$jarrera_pertsonala_id = $_POST['jarrera_pertsonala_id'];
	$lanerako_jarrera_id = $_POST['lanerako_jarrera_id'];
	$arreta_id = $_POST['arreta_id'];
	$oharra = $_POST['oharra'];
	$date = $_POST['date'];
	
	$error = $egunerokoaCrud->create($mahai_id, $irakaslea_id, $ikasle_id, $jarrera_pertsonala_id, $lanerako_jarrera_id, $oharra, $ikasgai_id, $arreta_id, $date);
	
}else if(isset($_GET['update_egunerokoa'])){
	
	$irakaslea_id = $_SESSION['id'];
	$id = $_POST['id'];
	$mahai_id = $_POST['mahai_id'];
	$ikasle = $_POST['ikasle'];
	$ikasle_id = $_POST['ikasle_id'];
	$ikasgai = $_POST['ikasgai'];
	$ikasgai_id = $_POST['ikasgai_id'];
	$jarrera_pertsonala_id = $_POST['jarrera_pertsonala_id'];
	$lanerako_jarrera_id = $_POST['lanerako_jarrera_id'];
	$arreta_id = $_POST['arreta_id'];
	$oharra = $_POST['oharra'];
	$creation_date = $_POST['date'];
	
	$error = $egunerokoaCrud->update($id, $mahai_id, $irakaslea_id, $ikasle_id, $jarrera_pertsonala_id, $lanerako_jarrera_id, $oharra, $ikasgai_id, $arreta_id, $creation_date);
	
}




?>