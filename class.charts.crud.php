<?php

class ChartsCrud // la class des operations avec la base de données.
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
	
	public function getById($id)  // return les informations de l'utilisateur qui est équivalant à l'id entré aux paramétre. 
	{
		$stmt = $this->db->prepare("SELECT * FROM tbl_ikasle WHERE id=:id"); // preparation de la requete sql avec l'id.
		$stmt->execute(array(":id"=>$id)); // execution de la requete.
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC); // affectation de la la résultat (un ligne de tableau). 
		return $editRow;
	}
	


		
	public function searchIkasleIkasgaiChartData($ikasleid, $startDate, $endDate) // l'affichage des données, on passe en paramétre une requete.
	{
		$ikasgai_array = Array();
		$color_array = Array();
		$total_array = Array();
		$result_array = Array();
		$ikasle_izena = '';
		
		$condicionFecha = "";
		if($startDate != "" && $endDate != ""){
			$condicionFecha = " AND egunerokoa.creation_date between '" . $startDate . "' AND '" . $endDate . "' ";
		}else if($startDate != ""){
			$condicionFecha = "AND egunerokoa.creation_date >= '" . $startDate . "' ";
		}else if($endDate != ""){
			$condicionFecha = "AND egunerokoa.creation_date <= '" . $endDate . "' ";
		}
		
		$select = "
		SELECT CONCAT(ikasle.first_name, ' ', ikasle.last_name) as ikasle_izena, ikasgai.name as ikasgai, ikasgai.color as color, COUNT(ikasgai.id) as total FROM tbl_ikasle ikasle 
		 JOIN tbl_egunerokoa egunerokoa on ikasle.id = egunerokoa.ikaslea_id
         JOIN tbl_ikasgai ikasgai on ikasgai.id = egunerokoa.ikasgai_id
         WHERE ikasle.id = " . $ikasleid . " " . $condicionFecha . "
		 GROUP by ikasgai.id";
		 
		 //echo $select;
		 
		$stmt = $this->db->prepare($select); // préparation de la requete 
		 
		$stmt->execute(); // exectuion de la requete	
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				$ikasgai_array[] = $row['ikasgai'];
				$color_array[] = $row['color'];
				$total_array[] = (int)$row['total'];
				$ikasle_izena = $row['ikasle_izena'];
			}
			
			$result_array['ikaslea'] = $ikasle_izena;
			$result_array['ikasgai'] = $ikasgai_array;
			$result_array['color'] = $color_array;
			$result_array['total'] = $total_array;
			$json_array = json_encode($result_array);
			echo $json_array;
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
			echo "{}";
		}
	}	
	
	
	public function searchIkasleJarreraChartData($ikasleid, $startDate, $endDate) // l'affichage des données, on passe en paramétre une requete.
	{
		$result_array = array();
		
		$condicionFecha = "";
		if($startDate != "" && $endDate != ""){
			$condicionFecha = " AND egunerokoa.creation_date between '" . $startDate . "' AND '" . $endDate . "' ";
		}else if($startDate != ""){
			$condicionFecha = "AND egunerokoa.creation_date >= '" . $startDate . "' ";
		}else if($endDate != ""){
			$condicionFecha = "AND egunerokoa.creation_date <= '" . $endDate . "' ";
		}
		
		$stmt = $this->db->prepare("
		 SELECT CONCAT(ikasle.first_name, ' ', ikasle.last_name) as ikasle_izena, egunerokoa.creation_date, ikasgai.name as ikasgai, egunerokoa.jarrera_id, ikasgai.color as kolorea
		 FROM tbl_ikasle ikasle 
		 JOIN tbl_egunerokoa egunerokoa on ikasle.id = egunerokoa.ikaslea_id
         JOIN tbl_ikasgai ikasgai on ikasgai.id = egunerokoa.ikasgai_id
         WHERE ikasle.id = " . $ikasleid . " " . $condicionFecha . "
		 order by ikasgai.id, egunerokoa.creation_date"
		 ); // préparation de la requete 
		 
		$stmt->execute(); // exectuion de la requete	
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{		
				$data['datetime'] = $row['creation_date'];
				$data['jarrera'] = $row['jarrera_id'];
				$data['ikasgai'] = $row['ikasgai'];
				$data['kolorea'] = $row['kolorea'];
				
				$result_array[$row['ikasgai']][] = $data;
				
			}

			$json_array = json_encode($result_array);
			echo $json_array;
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
			echo "{}";
		}
	}	
	
	
	public function searchIkasleEfizientziaChartData($ikasleid, $startDate, $endDate) // l'affichage des données, on passe en paramétre une requete.
	{
		$result_array = array();
		
		$condicionFecha = "";
		if($startDate != "" && $endDate != ""){
			$condicionFecha = " AND egunerokoa.creation_date between '" . $startDate . "' AND '" . $endDate . "' ";
		}else if($startDate != ""){
			$condicionFecha = "AND egunerokoa.creation_date >= '" . $startDate . "' ";
		}else if($endDate != ""){
			$condicionFecha = "AND egunerokoa.creation_date <= '" . $endDate . "' ";
		}
		
		$stmt = $this->db->prepare("
		 SELECT CONCAT(ikasle.first_name, ' ', ikasle.last_name) as ikasle_izena, egunerokoa.creation_date, ikasgai.name as ikasgai, egunerokoa.efizentzia_id, ikasgai.color as kolorea 
		 FROM tbl_ikasle ikasle 
		 JOIN tbl_egunerokoa egunerokoa on ikasle.id = egunerokoa.ikaslea_id
         JOIN tbl_ikasgai ikasgai on ikasgai.id = egunerokoa.ikasgai_id
         WHERE ikasle.id = " . $ikasleid . " " . $condicionFecha . "
		 order by ikasgai.id, egunerokoa.creation_date"
		 ); // préparation de la requete 
		 
		$stmt->execute(); // exectuion de la requete	
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{		
				$data['datetime'] = $row['creation_date'];
				$data['efizientzia'] = $row['efizentzia_id'];
				$data['ikasgai'] = $row['ikasgai'];
				$data['kolorea'] = $row['kolorea'];
				$result_array[$row['ikasgai']][] = $data;
				
			}

			$json_array = json_encode($result_array);
			
			echo $json_array;
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
			echo "{}";
		}
	}	
	
	
		public function searchIkasleOharraData($ikasleid, $startDate, $endDate) // l'affichage des données, on passe en paramétre une requete.
	{
		$result_array = array();
		
		$condicionFecha = "";
		if($startDate != "" && $endDate != ""){
			$condicionFecha = " AND egunerokoa.creation_date between '" . $startDate . "' AND '" . $endDate . "' ";
		}else if($startDate != ""){
			$condicionFecha = "AND egunerokoa.creation_date >= '" . $startDate . "' ";
		}else if($endDate != ""){
			$condicionFecha = "AND egunerokoa.creation_date <= '" . $endDate . "' ";
		}
		
		$stmt = $this->db->prepare("
		 SELECT CONCAT(ikasle.first_name, ' ', ikasle.last_name) as ikasle_izena, egunerokoa.creation_date, ikasgai.name as ikasgai, egunerokoa.oharra as oharra, ikasgai.color as kolorea, CONCAT(irakasle.first_name, ' ', irakasle.last_name) as irakaslea
		 FROM tbl_ikasle ikasle 
		 JOIN tbl_egunerokoa egunerokoa on ikasle.id = egunerokoa.ikaslea_id
         JOIN tbl_ikasgai ikasgai on ikasgai.id = egunerokoa.ikasgai_id
		 JOIN tbl_irakasle irakasle on irakasle.id = egunerokoa.irakaslea_id
         WHERE egunerokoa.oharra != '' AND ikasle.id = " . $ikasleid . " " . $condicionFecha . "
		 order by egunerokoa.creation_date desc"
		 ); // préparation de la requete 
		 
		$stmt->execute(); // exectuion de la requete	
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{		
				$data['datetime'] = $row['creation_date'];
				$data['oharra'] = $row['oharra'];
				$data['ikasgai'] = $row['ikasgai'];
				$data['kolorea'] = $row['kolorea'];
				$data['irakaslea'] = $row['irakaslea'];
				array_push($result_array, $data);
				
			}

			$json_array = json_encode($result_array);
			error_log($json_array);
			echo $json_array;
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
			echo "{}";
		}
	}	
}
?>