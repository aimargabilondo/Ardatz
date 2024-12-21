<?php session_start(); ?>

<?php

//Including Database configuration file.

include_once "dbconfig.php";



if(isset($_GET['add-ikasle'])){
	
	$ikaslea_id = $_POST['ikasle_id'];
	$asteko_eguna = $_POST['asteko_eguna'];
	$eguneko_sesioa = $_POST['eguneko_sesioa'];
	$gela = $_POST['gela'];
	
	$sql = "INSERT INTO tbl_ikasle_ordutegia_details(ikasle_id, ikasle_ordutegia_id) values ($ikaslea_id, (SELECT o.id FROM tbl_ikasle_ordutegia o WHERE o.asteko_eguna = $asteko_eguna AND o.eguneko_sesioa = $eguneko_sesioa AND o.gela = $gela)); ";
	
	$query = $DB_con->prepare( $sql );
	$sth = $query->execute();
	
	
	$result_array = array();
	$stmt = $DB_con->query("
		SELECT
		ikasle.id as id, 
		CONCAT(ikasle.first_name, ' ', ikasle.last_name) as izena,
		ikastetxea.izena as ikastetxea,
		maila.ikasmaila as ikasmaila,
		ordutegia.asteko_eguna as asteko_eguna, 
		ordutegia.eguneko_sesioa as eguneko_sesioa
		FROM tbl_ikasle_ordutegia_details details
		JOIN tbl_ikasle_ordutegia ordutegia on ordutegia.id = details.ikasle_ordutegia_id 
		JOIN tbl_ikasle ikasle on ikasle.id = details.ikasle_id 
		JOIN tbl_ikastetxea ikastetxea on ikastetxea.id = ikasle.ikastetxea_id 
		JOIN tbl_tarifak maila on maila.id = ikasle.ikasmaila_id 
		WHERE ikasle.id = $ikaslea_id AND ordutegia.asteko_eguna = $asteko_eguna AND ordutegia.eguneko_sesioa = $eguneko_sesioa
	");
	
	while ($Result = $stmt->fetch()) {
		$result_array[] = $Result;
	}
	$json_array = json_encode($result_array);
	echo $json_array;
	
}else if(isset($_GET['delete-ikasle'])){
	
	$ikaslea_id = $_POST['ikasle_id'];
	$asteko_eguna = $_POST['asteko_eguna'];
	$eguneko_sesioa = $_POST['eguneko_sesioa'];
	$gela = $_POST['gela'];
	
	$sql = "DELETE FROM tbl_ikasle_ordutegia_details WHERE ikasle_id = $ikaslea_id AND ikasle_ordutegia_id = (SELECT o.id FROM tbl_ikasle_ordutegia o WHERE o.asteko_eguna = $asteko_eguna AND o.eguneko_sesioa = $eguneko_sesioa AND o.gela = $gela); ";
	
	$query = $DB_con->prepare( $sql );
	$sth = $query->execute();
}






?>