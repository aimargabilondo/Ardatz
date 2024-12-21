<?php
include_once 'class.defaults.crud.php';

class EgunerokoaCrud // la class des operations avec la base de données.
{
	private $db;
	private $defaultsCrud;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
		$this->defaultsCrud = new DefaultsCrud($DB_con);
	}




	
	public function create($mahai_id, $irakaslea_id, $ikaslea_id, $jarrera_id, $efizentzia_id, $oharra, $ikasgai_id, $irakasle_arreta_id, $date) // methode d'insertion des données.
	{
		try
		{
			// préparation de la requete :
			$stmt = $this->db->prepare(
				"INSERT INTO tbl_egunerokoa(irakaslea_id, ikaslea_id, jarrera_id, efizentzia_id, oharra, ikasgai_id, irakasle_arreta_id, mahai_id, creation_date) VALUES
				(:irakaslea_id, :ikaslea_id, :jarrera_id, :efizentzia_id, :oharra, :ikasgai_id, :irakasle_arreta_id, :mahai_id, :date);");
			$stmt->bindparam(":irakaslea_id",$irakaslea_id);
			$stmt->bindparam(":ikaslea_id",$ikaslea_id);
			$stmt->bindparam(":jarrera_id",$jarrera_id);
			$stmt->bindparam(":efizentzia_id",$efizentzia_id);
			$stmt->bindparam(":oharra",$oharra);
			$stmt->bindparam(":ikasgai_id",$ikasgai_id);
			$stmt->bindparam(":irakasle_arreta_id",$irakasle_arreta_id);
			$stmt->bindparam(":mahai_id",$mahai_id);
			$stmt->bindparam(":date",$date);
			return $stmt->execute();
			return true;
		}
		catch(PDOException $e) // l'utilisation de "try catch" pour vérifier si on a des erreurs, 
		{					   // et afficher des messages.
			echo $e->getMessage();	
			return false;
		}	
	}
	
	public function getById($id)  // return les informations de l'utilisateur qui est équivalant à l'id entré aux paramétre. 
	{
		$stmt = $this->db->prepare("SELECT * FROM tbl_egunerokoa WHERE id=:id"); // preparation de la requete sql avec l'id.
		$stmt->execute(array(":id"=>$id)); // execution de la requete.
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC); // affectation de la la résultat (un ligne de tableau). 
		return $editRow;
	}
	
	public function getAllById($id)  // return les informations de l'utilisateur qui est équivalant à l'id entré aux paramétre. 
	{
		$stmt = $this->db->prepare("
			SELECT e.id as id,
			e.creation_date as eguna,
			CONCAT(ikasle.first_name, ' ', ikasle.last_name) as ikasle_izena,
			ikasle.id as ikasle_id,
			ikasle.image_name,
			ikasgai.name as ikasgaia,
			ikasgai.id as ikasgai_id,
			CONCAT(irakasle.first_name, '', irakasle.last_name) as irakasle_izena,
			j.name as jarrera,
			j.id as jarrera_id,
			ef.name as efizentzia,
			ef.id as efizentzia_id,
			ia.name as irakasle_arreta,
			ia.id as irakasle_arreta_id,
			m.id as mahaia_id,
			m.gela_name as gela_name,
			m.gela as gela,
			m.mahai_name as mahaia_name,
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
			WHERE e.id=:id"); 
			$stmt->bindparam(":id",$id);
		$stmt->execute(); // execution de la requete.
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC); // affectation de la la résultat (un ligne de tableau). 
		return $editRow;
	}

	
	public function update($id, $mahai_id, $irakaslea_id, $ikaslea_id, $jarrera_id, $efizentzia_id, $oharra, $ikasgai_id, $irakasle_arreta_id, $creation_date) // methode d'insertion des données.
	{
		try
		{
			// préparation de la requete :
			$stmt = $this->db->prepare(
				"UPDATE tbl_egunerokoa 
				SET irakaslea_id=:irakaslea_id, ikaslea_id=:ikaslea_id, jarrera_id=:jarrera_id, efizentzia_id=:efizentzia_id, oharra=:oharra, ikasgai_id=:ikasgai_id, irakasle_arreta_id=:irakasle_arreta_id, mahai_id=:mahai_id, creation_date=:creation_date 
				WHERE id=:id ;");
			$stmt->bindparam(":irakaslea_id",$irakaslea_id);
			$stmt->bindparam(":ikaslea_id",$ikaslea_id);
			$stmt->bindparam(":jarrera_id",$jarrera_id);
			$stmt->bindparam(":efizentzia_id",$efizentzia_id);
			$stmt->bindparam(":oharra",$oharra);
			$stmt->bindparam(":ikasgai_id",$ikasgai_id);
			$stmt->bindparam(":irakasle_arreta_id",$irakasle_arreta_id);
			$stmt->bindparam(":mahai_id",$mahai_id);
			$stmt->bindparam(":creation_date", $creation_date);
			$stmt->bindparam(":id",$id);
			return $stmt->execute();
			return true;
		}
		catch(PDOException $e) // l'utilisation de "try catch" pour vérifier si on a des erreurs, 
		{					   // et afficher des messages.		
			echo $e->getMessage();	
			return false;
		}	
	}
	
	public function delete($id) // suppression d'un utilisateur par l'id.
	{
		$stmt = $this->db->prepare("DELETE FROM tbl_egunerokoa WHERE id=:id"); // préparation.
		$stmt->bindparam(":id",$id); // affectation du valeur
		$stmt->execute(); // execution 
		return true; // toujoure on retourne true or false pour 
	}               
	
	
	public function egunerokoaModal($id){
		$jarrera_pertsonala_str = '';
		$efizientzia_str = '';
		$arreta_str = '';
		$gela_str = '';
		$mahai_str = '';
		extract($this->getAllById($id));	
								
		$stmt = $this->db->query("SELECT id, name FROM tbl_jarrera order by id asc");
		while ($Result = $stmt->fetch()) {
			if($Result["id"] == $jarrera_id){
				$jarrera_pertsonala_str =  "<option value='" . $Result["id"] . "' selected>" . $Result["name"] . "</option>";
			}
		}
		
		$stmt = $this->db->query("SELECT id, name FROM tbl_efizentzia order by id asc");
		while ($Result = $stmt->fetch()) {
			if($Result["id"] == $efizentzia_id){
				$efizientzia_str =  "<option value='" . $Result["id"] . "' selected>" . $Result["name"] . "</option>";
			}
		}
		
		$stmt = $this->db->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");
		while ($Result = $stmt->fetch()) {
			if($Result["id"] == $irakasle_arreta_id){
				$arreta_str = "<option value='" . $Result["id"] . "' selected>" . $Result["name"] . "</option>";
			}
		}				

		$stmt = $this->db->query("SELECT gela, gela_name FROM tbl_mahai group by gela, gela_name order by gela asc");
		while ($Result = $stmt->fetch()) {
			if($Result["gela"] == $gela){
				$gela_str = "<option value='" . $Result["gela"] . "' selected>" . $Result["gela_name"] . "</option>";
			}
		}		
		
		$stmt = $this->db->query("SELECT id, mahaia, mahai_name FROM tbl_mahai where gela = ".$gela." order by id asc");
		while ($Result = $stmt->fetch()) {
			if($Result["id"] == $mahaia_id){
				$mahai_str = "<option value='" . $Result["mahaia"] . "' selected>" . $Result["mahai_name"] . "</option>";
			}
		}
		
		print('
		<div class="col-md-10"></br></br>
			<div class="btn btn-block btn-lg btn-mesa">
			<form method="post" id="$id" name="formedit">
				<table class="table table-bordered">
					<tr>
						<td>Ikaslea </td>
						<td>
							<div class="search-box ikasle">
								<input type="text" autocomplete="off" placeholder="Ikaslea..." name="ikasle" value="'.$ikasle_izena.'" class="search-input form-control" required>
								<div class="result"></div><input type="hidden" name="ikasle-id" value="'.$ikasle_id.'" class="form-control">
							</div>
						</td>
					</tr>
					<tr>
						<td>Ikasgaia </td>
						<td>
							<div class="search-box ikasgai">
								<input type="text" autocomplete="off" placeholder="Ikasgaia..." name="ikasgai" value="'.$ikasgaia.'" class="search-input form-control" required>
								<div class="result"></div><input type="hidden" name="ikasgai-id" value="'.$ikasgai_id.'" class="form-control">
							</div>
						</td>
					</tr>
					<tr>
						<td>Jarrera pertsonala </td>
						<td>
							<select class="form-control" name="jarrera_pertsonala" required>
								'.$jarrera_pertsonala_str.'
							</select>
						</td>
					</tr>			
					<tr>
						<td>Lanerako jarrera </td>
						<td>
							<select class="form-control" name="lanerako_jarrera" required>
								'.$efizientzia_str.'
							</select>
						</td>
					</tr>
					<tr>
						<td>Irakaslearen arreta </td>
						<td>
							<select class="form-control" name="arreta" required>
								'.$arreta_str.'
							</select>
						</td>
					</tr>				
					<tr>
						<td>Oharra </td>
						<td>
							<textarea class="form-control" style="resize:none" rows="3" name="oharra">'.$oharra.'</textarea>
						</td>
					</tr>
					<tr>
						<td>Gela </td>
						<td>
							<select class="form-control" id="gelaselector" name="gela" required>
								'.$gela_str.'
							</select>
						</td>
					</tr>
					<tr>
						<td>Mahaia </td>
						<td>
							<select class="form-control" id="mahaiaselector" name="nahaia" required>
								'.$mahai_str.'
							</select>
						</td>
					</tr>
				</table>
			</form>
			</div>
		 </div>');
		
	}
	

	public function checkLastDayWork() // l'affichage des données, on passe en paramétre une requete.
	{
		/*$query = "
				SELECT  COUNT(egunerokoa.id) as zenbat, irakasle.id as irakasleId, 
						CONCAT(irakasle.first_name, ' ', irakasle.last_name) as irakasle_izena
						FROM tbl_irakasle irakasle
						LEFT JOIN tbl_egunerokoa egunerokoa on irakasle.id = egunerokoa.irakaslea_id
						WHERE (egunerokoa.creation_date is null OR DATE_FORMAT(egunerokoa.creation_date, '%Y-%m-%d') = DATE_FORMAT(subdate(current_date, 1), '%Y-%m-%d'))
						GROUP BY  irakasle.id
		";*/
		$query = "
				SELECT  
				(SELECT COUNT(egunerokoa.id) 
							FROM tbl_egunerokoa egunerokoa
							WHERE irakasle.id = egunerokoa.irakaslea_id
							AND CASE WHEN (DAYOFWEEK(subdate(current_date, 1)) = 1) THEN
								(DATE_FORMAT(egunerokoa.creation_date, '%Y-%m-%d') = DATE_FORMAT(subdate(current_date, 3), '%Y-%m-%d'))
							ELSE
								(DATE_FORMAT(egunerokoa.creation_date, '%Y-%m-%d') = DATE_FORMAT(subdate(current_date, 1), '%Y-%m-%d'))
							END
							
				) as zenbat, irakasle.id as irakasleId, 
				CONCAT(irakasle.first_name, ' ', irakasle.last_name) as irakasle_izena
				FROM tbl_irakasle irakasle
				WHERE irakasle.active = 1
		";
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete		
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{			
?>
                <tr>
					<td style="width: 200px;">
					<?php 
						echo "<br>";
						print($row['irakasle_izena']);						
					?>
					</td>
					<td style="width: 100px;">
					<?php 
					$min = $this->defaultsCrud->getValueByIrakasleIdAndParamName($row['irakasleId'], 'IKASLE_KOPURUA_EGUNEAN_MIN');
					if($row['zenbat'] >= $min){
						print($row['zenbat']); 	
						print("<img src='berdea.gif' alt='Dena ondo!' height='60' width='60'>");
					}else{
						print($row['zenbat']);
						print("<img src='gorria.gif' alt='Mesedez bete atzoko egunerokoak!' height='60' width='60'>"); 	
					}
					?>
					</td>
					<td style="width: 100px;">&nbsp;&nbsp;</td>
					<?php 
					$row=$stmt->fetch(PDO::FETCH_ASSOC); 
					if($row){ 
						?>
						<td style="width: 200px; test">
						<?php
						echo "<br>";
						print($row['irakasle_izena']);
						?>
						</td>
						<td style="width: 100px;">
						<?php 
						$min = $this->defaultsCrud->getValueByIrakasleIdAndParamName($row['irakasleId'], 'IKASLE_KOPURUA_EGUNEAN_MIN');
						if($row['zenbat'] >= $min){
							print($row['zenbat']); 							
							print("<img src='berdea.gif' alt='Dena ondo!' height='60' width='60'>"); 							
						}else{
							print($row['zenbat']); 
							print("<img src='gorria.gif' alt='Mesedez bete atzoko egunerokoak!' height='60' width='60'>");	
						}
						 ?>
						</td>
					<?php 
					}else{
					?>
						<td style="width: 200px;"></td>
						<td style="width: 60px;"></td>
					<?php 
					}
					?>	
                </tr>
<?php
			}
		}
	}
		
	public function dataview($query) // l'affichage des données, on passe en paramétre une requete.
	{
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete
		$totalLineas = $stmt->rowCount();		
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
?>
                <tr>
                	<td><?php print($row['id']); ?></td> <!--utilisation de print pour l'affichage de id pour ce ligne-->
					<td width='100'><?php print($row['eguna']); ?></td>
                	<td>
						<img class="img-rounded zoom" src="/ardatz/images/<?php print($row['image_name']); ?>" width="40" height="40"/><?php print($row['ikasle_izena']); ?>
					</td><!--affichage de nome-->
                	<td><?php print($row['ikasgaia']); ?></td><!--affichage de prénom-->
                	<td><?php print($row['irakasle_izena']); ?></td><!--affichage de email-->
                	<td><?php print($row['jarrera']); ?></td><!--affichage de tél-->
					<td><?php print($row['efizentzia']); ?></td>
					<td><?php print($row['irakasle_arreta']); ?></td>
					<td><?php print($row['oharra']); ?></td>
					<td><?php print($row['gela']); ?></td>
					<td><?php print($row['mahaia']); ?></td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="egunerokoa_edit.php?edit_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-edit"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de suppression-->
                	<a href="egunerokoa_delete.php?delete_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-remove-circle"></i><!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                </tr>
<?php
			}
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
?>
            <tr>
            <td colspan="13">Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
<?php
		}
		return $totalLineas;
	}	
	
	public function dataviewCount($query) // l'affichage des données, on passe en paramétre une requete.
	{
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete
		$row = $stmt->fetch();	
		$totalLineas = $row['total'];
		return $totalLineas;
	}
	
	
	
	public function findMahaiakByGela($gela) // l'affichage des données, on passe en paramétre une requete.
	{
		$stmt = $this->db->prepare("SELECT id, mahaia, mahai_name FROM tbl_mahai where gela = ".$gela." order by id asc"); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete	
		
?>
		<option value="" disabled selected hidden>--Irakaslearen arreta--</option>
<?php
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{									       
?>
			<option value='<?php print($row['id']); ?>'><?php print($row['mahai_name']); ?></option>
<?php
		}
		
		
	}	
	
		public function dataviewLiveSearch($query) // l'affichage des données, on passe en paramétre une requete.
	{
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete
?>
		
		<tr>
			<th>N° </th>
			<th>Data </th>
            <th>Ikaslea </th>
            <th>Ikasgaia </th>
            <th>Irakaslea </th>
            <th>Jarrera </th>
			<th>Efizentzia </th>
			<th>Irakaslearen arreta </th>
			<th>Oharra </th>
			<th>Gela </th>
			<th>Mahaia </th>
            <th colspan="2" align="center">Actions</th>
        </tr>
		
<?php
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
?>
                <tr>
                	<td><?php print($row['id']); ?></td> <!--utilisation de print pour l'affichage de id pour ce ligne-->
					<td><?php print($row['eguna']); ?></td>
                	<td>
						<img class="img-rounded zoom" src="/ardatz/images/<?php print($row['image_name']); ?>" width="40" height="40"/><?php print($row['ikasle_izena']); ?>
					</td><!--affichage de nome-->
                	<td><?php print($row['ikasgaia']); ?></td><!--affichage de prénom-->
                	<td><?php print($row['irakasle_izena']); ?></td><!--affichage de email-->
                	<td><?php print($row['jarrera']); ?></td><!--affichage de tél-->
					<td><?php print($row['efizentzia']); ?></td>
					<td><?php print($row['irakasle_arreta']); ?></td>
					<td><?php print($row['oharra']); ?></td>
					<td><?php print($row['gela']); ?></td>
					<td><?php print($row['mahaia']); ?></td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="egunerokoa_edit.php?edit_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-edit"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de suppression-->
                	<a href="egunerokoa_delete.php?delete_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-remove-circle"></i><!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                </tr>
				
<?php
			}
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
?>
            <tr>
            <td colspan="13">Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
<?php
		}
		
?>
		<tr>
            <td colspan="13">
                <a href="../index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atras</a>
            </td>
        </tr>
<?php
	}
	
}
?>