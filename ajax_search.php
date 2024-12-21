<?php

//Including Database configuration file.
include_once "dbconfig.php";


/*
echo '<table>';
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }

echo '</table>';

echo '<table>';
    foreach ($_GET as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }

echo '</table>';*/

if(isset($_GET['ikasle'])){
	if (isset($_POST['search'])) {
		//Search box value assigning to $Name variable.

	   $Name = $_POST['search'];

		//Query execution

		$stmt = $DB_con->query("SELECT id, CONCAT(first_name, ' ', last_name) as name FROM `tbl_ikasle` WHERE CONCAT(first_name, ' ', last_name) LIKE '%$Name%' AND active = 1 LIMIT 10 ");

	   //Fetching result from database.
		while ($Result = $stmt->fetch()) {
			echo "<p id='" . $Result["id"] . "'>" . $Result["name"] . "</p>";
		}
	}
}else if(isset($_GET['ikasgai'])){
	if (isset($_POST['search'])) {
		//Search box value assigning to $Name variable.

	   $Name = $_POST['search'];

		//Query execution

		$stmt = $DB_con->query("SELECT id, name FROM tbl_ikasgai WHERE name LIKE '%$Name%' LIMIT 10");


	   //Fetching result from database.
		while ($Result = $stmt->fetch()) {
			echo "<p id='" . $Result["id"] . "'>" . $Result["name"] . "</p>";
		}
	}
}else if(isset($_GET['ikastetxe'])){
	if (isset($_POST['search'])) {
		//Search box value assigning to $Name variable.

	   $Name = $_POST['search'];

		//Query execution

		$stmt = $DB_con->query("SELECT id, izena FROM tbl_ikastetxea WHERE izena LIKE '%$Name%' LIMIT 10");


	   //Fetching result from database.
		while ($Result = $stmt->fetch()) {
			echo "<p id='" . $Result["id"] . "'>" . $Result["izena"] . "</p>";
		}
	}
}else if(isset($_GET['maila'])){
	if (isset($_POST['search'])) {
		//Search box value assigning to $Name variable.

	   $Name = $_POST['search'];

		//Query execution

		$stmt = $DB_con->query("SELECT id, ikasmaila FROM tbl_tarifak WHERE ikasmaila LIKE '%$Name%' LIMIT 10");


	   //Fetching result from database.
		while ($Result = $stmt->fetch()) {
			echo "<p id='" . $Result["id"] . "'>" . $Result["ikasmaila"] . "</p>";
		}
	}
}else if(isset($_GET['irakasle'])){
	if (isset($_POST['search'])) {
		//Search box value assigning to $Name variable.

	   $Name = $_POST['search'];

		//Query execution

		$stmt = $DB_con->query("SELECT id, CONCAT(first_name, ' ', last_name) as name FROM `tbl_irakasle` WHERE CONCAT(first_name, ' ', last_name) LIKE '%$Name%'  AND active = 1  LIMIT 10");


	   //Fetching result from database.
		while ($Result = $stmt->fetch()) {
			echo "<p id='" . $Result["id"] . "'>" . $Result["name"] . "</p>";
		}
	}
}else if(isset($_GET['search-box-ikasle'])){
	if (isset($_POST['ikasle'])) {

		$Name = $_POST['ikasle'];

		$stmt = $DB_con->query("SELECT CONCAT(id, ': ', first_name, ' ', last_name) as text FROM `tbl_ikasle` WHERE CONCAT(first_name, ' ', last_name) LIKE '%$Name%' AND active = 1 LIMIT 10");

		while ($Result = $stmt->fetch()) {
			echo "<p onclick='selectOption(this);'>" . $Result["text"] . "</p>";
		}
	}
}else if(isset($_GET['search-box-irakasle'])){
	if (isset($_POST['irakasle'])) {

		$Name = $_POST['irakasle'];

		$stmt = $DB_con->query("SELECT CONCAT(id, ': ', first_name, ' ', last_name) as text FROM `tbl_irakasle` WHERE CONCAT(first_name, ' ', last_name) LIKE '%$Name%'  AND active = 1 LIMIT 10");

		while ($Result = $stmt->fetch()) {
			echo "<p onclick='selectOption(this);'>" . $Result["text"] . "</p>";
		}
	}
}else if(isset($_GET['search-irakasle'])){
	if(isset($_POST['irakasle'])){

		$Name = $_POST['irakasle'];
		
		$irakasleCrud->dataviewLiveSearch("SELECT * FROM tbl_irakasle WHERE first_name LIKE '%$Name%'");
	}else{
		//Throw error
	}
}else if(isset($_GET['search-ikasle'])){
	
	$sql = "SELECT ikasle.*, tarifa.ikasmaila, etxea.izena ikastetxea, date_format(ikasle.creation_date, '%Y-%m-%d') creation_date_formated 
									FROM tbl_ikasle ikasle 
									join tbl_tarifak tarifa on tarifa.id = ikasle.ikasmaila_id  
									join tbl_ikastetxea etxea on etxea.id = ikasle.ikastetxea_id 
									WHERE 1=1 ";
									
	if (isset($_POST['ikasle_id']) || isset($_POST['ikastetxe_id']) || isset($_POST['maila_id']) || isset($_POST['egoera'])) {
		$ikasle_id = $_POST['ikasle_id'];
		$ikastetxe_id = $_POST['ikastetxe_id'];
		$maila_id = $_POST['maila_id'];
		$egoera = $_POST['egoera'];

		if($ikasle_id != ''){
			$sql = $sql." and ikasle.id = ".$ikasle_id." ";
		}
		if($ikastetxe_id != ''){
			$sql = $sql." and etxea.id = ".$ikastetxe_id." ";
		}
		if($maila_id != ''){
			$sql = $sql." and tarifa.id = ".$maila_id." ";
		}		
		if($egoera != '2'){
			$sql = $sql." and ikasle.active = ".$egoera." ";
		}		
											
	}
	
	$sql = $sql." order by ikasle.id";
	$ikasleCrud->dataviewLiveSearch($sql);
		
}else if(isset($_GET['search-ikasle-klase-egunak'])){
	
	$ikasle_id = $_POST['ikasle_id'];
	$irakasle_id = $_POST['irakasle_id'];
	$ikastetxe_id = $_POST['ikastetxe_id'];
	$maila_id = $_POST['maila_id'];

	$sql = "
		select
				ikasle.id ikasle_id,
				ikasle.first_name,
				ikasle.last_name,
				tarifa.ikasmaila,
				etxea.izena ikastetxea,
				ikasle.hours_per_week,
				SUBSTRING(egunak.asteko_eguna, 1, 1) as astelehena,
				SUBSTRING(egunak.asteko_eguna, 2, 1) as asteartea,
				SUBSTRING(egunak.asteko_eguna, 3, 1) as asteazkena,
				SUBSTRING(egunak.asteko_eguna, 4, 1) as osteguna,
				SUBSTRING(egunak.asteko_eguna, 5, 1) as ostirala,
				SUBSTRING(egunak.asteko_eguna, 6, 1) as larunbata,
				SUBSTRING(egunak.asteko_eguna, 7, 1) as igandea
			  from tbl_ikasle ikasle
			  join tbl_ikasle_egunak egunak on egunak.ikasle_id = ikasle.id
			  join tbl_tarifak tarifa on tarifa.id = ikasle.ikasmaila_id
			  join tbl_ikastetxea etxea on etxea.id = ikasle.ikastetxea_id
		WHERE 1=1  AND ikasle.active = 1 ";
		
		if($ikasle_id!=''){
			$sql=$sql."AND ikasle.id = $ikasle_id ";
		}		
		if($ikastetxe_id!=''){
			$sql=$sql."AND etxea.id = $ikastetxe_id ";
		}
		if($maila_id!=''){
			$sql=$sql."AND tarifa.id = $maila_id ";
		}
		
		
		$sql=$sql."order by ikasle.id;;";
		//error_log($sql);

	$ikasleCrud->dataviewIkasleDatuakEtaKlaseEgunakLiveSearch($sql);
	
}else if(isset($_GET['search-tutoreak'])){
	
	$ikasle_id = $_POST['ikasle_id'];
	$irakasle_id = $_POST['irakasle_id'];
	
	$sql = "
		select		
			ikasle.id ikasle_id,
			ikasle.first_name,
			ikasle.last_name,
			ikasle.guraso1,
			ikasle.email1,
			ikasle.contact_no1,
			ikasle.guraso2,
			ikasle.email2,
			ikasle.contact_no2,
			tarifa.ikasmaila,
			etxea.izena ikastetxea,
			irakasle.id irakasle_id
		  from tbl_tutore tutore 
		  RIGHT join tbl_ikasle ikasle on ikasle.id = tutore.ikasle_id
		  left join tbl_irakasle irakasle on irakasle.id = tutore.irakasle_id
		  join tbl_tarifak tarifa on tarifa.id = ikasle.ikasmaila_id
		  join tbl_ikastetxea etxea on etxea.id = ikasle.ikastetxea_id
		WHERE 1=1  AND ikasle.active = 1 ";
		
		if($ikasle_id!=''){
			$sql=$sql."AND ikasle.id = $ikasle_id ";
		}
		if($irakasle_id!=''){
			$sql=$sql."AND irakasle.id = $irakasle_id ";
		}
		
		
		$sql=$sql."order by ikasle.id;";
		//error_log($sql);

	$ikasleCrud->dataviewIkasleTutoreLiveSearch($sql);
	
}else if(isset($_GET['search-egunerokoa'])){
	
	$ikasle_id = $_POST['ikasle_id'];
	$irakasle_id = $_POST['irakasle_id'];
	$ikasgai_id = $_POST['ikasgai_id'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	
	$sql = "
		SELECT e.id as id,
		e.creation_date as eguna,
		CONCAT(ikasle.first_name, ' ', ikasle.last_name) as ikasle_izena,
		ikasle.image_name,
		ikasgai.name as ikasgaia,
		CONCAT(irakasle.first_name, '', irakasle.last_name) as irakasle_izena,
		j.name as jarrera,
		ef.name as efizentzia,
		ia.name as irakasle_arreta,
		m.gela as gela,
		m.mahaia as mahaia,
		e.oharra as oharra
		FROM tbl_egunerokoa e 
		JOIN tbl_mahai m on m.id = e.mahai_id
		JOIN tbl_jarrera j on j.id = e.jarrera_id
		join tbl_irakasle_arreta ia on ia.id = e.irakasle_arreta_id
		join tbl_irakasle irakasle on irakasle.id = e.irakaslea_id
		join tbl_ikasle ikasle on ikasle.id = e.ikaslea_id
		join tbl_ikasgai ikasgai on ikasgai.id = e.ikasgai_id
		join tbl_efizentzia ef on ef.id = e.efizentzia_id
		WHERE 1=1 ";
		
		if($ikasle_id!=''){
			$sql=$sql."AND ikasle.id = $ikasle_id ";
		}
		if($irakasle_id!=''){
			$sql=$sql."AND irakasle.id = $irakasle_id ";
		}
		if($ikasgai_id!=''){
			$sql=$sql."AND ikasgai.id = $ikasgai_id ";
		}
		if($start_date!='' && $end_date!=''){
			$sql=$sql."AND e.creation_date BETWEEN '$start_date' AND '$end_date' ";
		}else if($start_date!='' && $end_date==''){
			$sql=$sql."AND e.creation_date > '$start_date' ";
		}else if($start_date=='' && $end_date!=''){
			$sql=$sql."AND e.creation_date < '$end_date' ";
		}
		
		$sql=$sql."order by eguna desc;";
		error_log($sql);

	$egunerokoaCrud->dataviewLiveSearch($sql);
	
}else if(isset($_GET['search-mahaiak'])){
	if(isset($_POST['gela'])){
		$egunerokoaCrud->findMahaiakByGela($_POST['gela']);
	}else{
		//Throw error
	}
}else if(isset($_GET['chart-ikasle-ikasgai'])){
		if(isset($_POST['ikasleId'])){

			$ikasleId = $_POST['ikasleId'];
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			//echo $ikasleId;
			
			$chartsCrud->searchIkasleIkasgaiChartData($ikasleId, $startDate, $endDate);
		}else{
			//Throw error
		}
}else if(isset($_GET['chart-ikasle-jarrera'])){
		if(isset($_POST['ikasleId'])){

			$ikasleId = $_POST['ikasleId'];
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			//echo $ikasleId;
			
			$chartsCrud->searchIkasleJarreraChartData($ikasleId, $startDate, $endDate);
		}else{
			//Throw error
		}
}else if(isset($_GET['chart-ikasle-efizientzia'])){
		if(isset($_POST['ikasleId'])){

			$ikasleId = $_POST['ikasleId'];
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			//echo $ikasleId;
			
			$chartsCrud->searchIkasleEfizientziaChartData($ikasleId, $startDate, $endDate);
		}else{
			//Throw error
		}
}else if(isset($_GET['chart-oharra'])){
		if(isset($_POST['ikasleId'])){

			$ikasleId = $_POST['ikasleId'];
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			//echo $ikasleId;
			
			$chartsCrud->searchIkasleOharraData($ikasleId, $startDate, $endDate); 
		}else{
			//Throw error
		}
}else if(isset($_GET['search-ikasle-remesa'])){
	
	$sql = "SELECT true as checked, 
					false as matrikula,
					ikasle.id, 
					ikasle.hours_per_week, 
					ikasle.ncuenta, 
					ikasle.guraso1,
					ikasle.guraso2,
					ikasle.helbidea,
		    (ikasle.hours_per_week * 4) as hours_per_month,
		    ROUND(COALESCE((SELECT totala from tbl_tarifa_details details where details.tarifak_id = tarifa.id and details.orduak = ikasle.hours_per_week),0), 2) as prezioa_hilero,
			ROUND(COALESCE((SELECT totala from tbl_tarifa_details details where details.tarifak_id = tarifa.id and details.orduak = ikasle.hours_per_week),0), 2) as prezioa_hilero_zuzenduta,
	        CONCAT(ikasle.last_name, ', ', ikasle.first_name) as izena, tarifa.ikasmaila ikasmaila, etxea.izena ikastetxea, date_format(ikasle.creation_date, '%Y-%m-%d') creation_date_formated 
									FROM tbl_ikasle ikasle 
									join tbl_tarifak tarifa on tarifa.id = ikasle.ikasmaila_id  
									join tbl_ikastetxea etxea on etxea.id = ikasle.ikastetxea_id 
									WHERE 1=1  ";
									
	if (isset($_POST['ikasle_id']) || isset($_POST['ikastetxe_id']) || isset($_POST['maila_id']) || isset($_POST['egoera'])) {
		$ikasle_id = $_POST['ikasle_id'];
		$ikastetxe_id = $_POST['ikastetxe_id'];
		$maila_id = $_POST['maila_id'];
		$egoera = $_POST['egoera'];

		if($ikasle_id != ''){
			$sql = $sql." and ikasle.id = ".$ikasle_id." ";
		}
		if($ikastetxe_id != ''){
			$sql = $sql." and etxea.id = ".$ikastetxe_id." ";
		}
		if($maila_id != ''){
			$sql = $sql." and tarifa.id = ".$maila_id." ";
		}		
		if($egoera != '2'){
			$sql = $sql." and ikasle.active = ".$egoera." ";
		}		
											
	}
	
	$sql = $sql." order by CONCAT(ikasle.last_name, ', ', ikasle.first_name) ";
	echo $remesaCrud->searchIkasleRemesa($sql);
		
}else if(isset($_GET['ordutegia-weekday'])){
	if (isset($_POST['json']) && isset($_POST['asteko_eguna'])) {
		$asteko_eguna = $_POST['asteko_eguna'];
		$result_array = array();
		$stmt = $DB_con->query("
			SELECT
			ikasle.id as id, 
			CONCAT(ikasle.first_name, ' ', ikasle.last_name) as izena,
			ikastetxea.izena as ikastetxea,
			maila.ikasmaila as ikasmaila,
			ordutegia.asteko_eguna as asteko_eguna, 
			ordutegia.eguneko_sesioa as eguneko_sesioa,
			ordutegia.gela as gela 
			FROM tbl_ikasle_ordutegia_details details
			JOIN tbl_ikasle_ordutegia ordutegia on ordutegia.id = details.ikasle_ordutegia_id 
			JOIN tbl_ikasle ikasle on ikasle.id = details.ikasle_id 
			JOIN tbl_ikastetxea ikastetxea on ikastetxea.id = ikasle.ikastetxea_id 
			JOIN tbl_tarifak maila on maila.id = ikasle.ikasmaila_id 
			WHERE ordutegia.asteko_eguna = '$asteko_eguna'
		");
		
		while ($Result = $stmt->fetch()) {
			$result_array[] = $Result;
		}
		$json_array = json_encode($result_array);
		echo $json_array;
	}
}else if(isset($_GET['search-materiala'])){
if(isset($_POST['materiala'])){

		$Name = $_POST['materiala'];
		
		$materialaCrud->dataviewLiveSearch("SELECT * FROM tbl_materialak WHERE Deskripzioa LIKE '%$Name%'");
	}else{
		//Throw error
	}
}
?>

