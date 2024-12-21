<?php

class IkasleCrud // la class des operations avec la base de données.
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
	
	public function generarCodigo($longitud) {
		$key = '';
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
		$max = strlen($pattern)-1;
		for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		return $key;
	}
	
	public function create($fname,$lname,$email1,$contact_no1,$hours,$active,$image,$ncuenta,$ikasmaila,
		$guraso1, $guraso2, $jaiotze_data, $helbidea, $email2, $contact_no2, $dni1, $dni2, $tutorea, $email_tutorea,
		$ikastetxea, $oharra) // methode d'insertion des données.
	{
		try
		{
			// préparation de la requete :
			$stmt = $this->db->prepare(
				"INSERT INTO tbl_ikasle(first_name,last_name,email1,contact_no1,hours_per_week,active, image_name, ncuenta, ikasmaila_id,
										guraso1, guraso2, jaiotze_data, helbidea, email2, contact_no2, dni1, dni2, tutorea, email_tutorea,
										ikastetxea_id, oharra) 
						VALUES(:fname, :lname, :email1, :contact_no1, :hours, :active, :image_name, :ncuenta, :ikasmaila,
							   :guraso1, :guraso2, :jaiotze_data, :helbidea, :email2, :contact_no2, :dni1, :dni2, :tutorea, :email_tutorea,
							   :ikastetxea, :oharra); ");
			// affectations des valeurs :
			$stmt->bindparam(":fname",$fname);
			$stmt->bindparam(":lname",$lname);
			$stmt->bindparam(":email1",$email1);
			$stmt->bindparam(":contact_no1",$contact_no1);
			$stmt->bindparam(":hours",$hours);
			$stmt->bindparam(":active",$active);
			$stmt->bindparam(":image_name",$image);
			$stmt->bindparam(":ncuenta",$ncuenta);
			$stmt->bindparam(":ikasmaila",$ikasmaila);
			
			$stmt->bindparam(":guraso1",$guraso1);
			$stmt->bindparam(":guraso2",$guraso2);
			$stmt->bindparam(":jaiotze_data",$jaiotze_data);
			$stmt->bindparam(":helbidea",$helbidea);
			$stmt->bindparam(":email2",$email2);
			$stmt->bindparam(":contact_no2",$contact_no2);
			$stmt->bindparam(":dni1",$dni1);
			$stmt->bindparam(":dni2",$dni2);
			$stmt->bindparam(":tutorea",$tutorea);
			$stmt->bindparam(":email_tutorea",$email_tutorea);
			$stmt->bindparam(":ikastetxea",$ikastetxea);
			$stmt->bindparam(":oharra",$oharra);		

			return $stmt->execute();
		}
		catch(PDOException $e) // l'utilisation de "try catch" pour vérifier si on a des erreurs, 
		{					   // et afficher des messages.
			echo $e->getMessage();	
			error_log($e->getMessage());
			return false;
		}	
	}
	
	public function getById($id)  // return les informations de l'utilisateur qui est équivalant à l'id entré aux paramétre. 
	{
		$stmt = $this->db->prepare("SELECT *, date_format(jaiotze_data, '%Y-%m-%d') jaiotze_data_formated FROM tbl_ikasle WHERE id=:id"); // preparation de la requete sql avec l'id.
		$stmt->execute(array(":id"=>$id)); // execution de la requete.
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC); // affectation de la la résultat (un ligne de tableau). 
		return $editRow;
	}

	public function getAstekoEgunak($ikasleId)  // return les informations de l'utilisateur qui est équivalant à l'id entré aux paramétre. 
	{
		//error_log('IDDD: '.$ikasleId);
		$stmt = $this->db->prepare("
				SELECT CONCAT (
						CASE SUBSTRING(asteko_eguna, 1, 1) WHEN 1 THEN '1' ELSE '' END,
						CASE SUBSTRING(asteko_eguna, 2, 1) WHEN 1 THEN '2' ELSE '' END,
						CASE SUBSTRING(asteko_eguna, 3, 1) WHEN 1 THEN '3' ELSE '' END,
						CASE SUBSTRING(asteko_eguna, 4, 1) WHEN 1 THEN '4' ELSE '' END,
						CASE SUBSTRING(asteko_eguna, 5, 1) WHEN 1 THEN '5' ELSE '' END,
						CASE SUBSTRING(asteko_eguna, 6, 1) WHEN 1 THEN '6' ELSE '' END,
						CASE SUBSTRING(asteko_eguna, 7, 1) WHEN 1 THEN '0' ELSE '' END) as egunak
				FROM dbpdo.tbl_ikasle_egunak
				WHERE ikasle_id = :id");
		$stmt->bindparam(":id",$ikasleId);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($row){
			//error_log($r]);
			return $row['egunak'];
		}else{
			return '';
		}
		
	}


	
	public function getIkasleCount() 
	{
		$count = $this->db->query("SELECT count(*) FROM tbl_ikasle ")->fetchColumn();
		return $count;
	}
	
	public function getActiveIkasleCount() 
	{
		$count = $this->db->query("SELECT count(*) FROM tbl_ikasle where active = 1 ")->fetchColumn();
		return $count;
	}

	// modification d'un utilisateur avec tous les champs.
	public function update($id,$fname,$lname,$email1,$contact_no1,$hours,$active,$ncuenta,$ikasmaila,
		$guraso1, $guraso2, $jaiotze_data, $helbidea, $email2, $contact_no2, $dni1, $dni2, $tutorea, $email_tutorea,
		$ikastetxea, $oharra)
	{
		try
		{
			// préparation de la requete :
			$stmt=$this->db->prepare("UPDATE tbl_ikasle SET first_name=:fname, 
		                                               last_name=:lname, 
													   email1=:email1, 
													   contact_no1=:contact_no1,
													   hours_per_week=:hours,
													   active=:active,
													   ncuenta=:ncuenta,
													   ikasmaila_id=:ikasmaila,
													   guraso1=:guraso1,
													   guraso2=:guraso2,
													   jaiotze_data=:jaiotze_data,
													   helbidea=:helbidea,
													   email2=:email2,
													   contact_no2=:contact_no2,
													   dni1=:dni1,
													   dni2=:dni2,
													   tutorea=:tutorea,
													   email_tutorea=:email_tutorea,
													   ikastetxea_id=:ikastetxea,
													   oharra=:oharra
													WHERE id=:id ");

			// affectation des valeurs :
			$stmt->bindparam(":fname",$fname);
			$stmt->bindparam(":lname",$lname);
			$stmt->bindparam(":email1",$email1);
			$stmt->bindparam(":contact_no1",$contact_no1);
			$stmt->bindparam(":hours",$hours);
			$stmt->bindparam(":active",$active);
			$stmt->bindparam(":ncuenta",$ncuenta);
			$stmt->bindparam(":ikasmaila",$ikasmaila);
			
			$stmt->bindparam(":guraso1",$guraso1);
			$stmt->bindparam(":guraso2",$guraso2);
			$stmt->bindparam(":jaiotze_data",$jaiotze_data);
			$stmt->bindparam(":helbidea",$helbidea);
			$stmt->bindparam(":email2",$email2);
			$stmt->bindparam(":contact_no2",$contact_no2);
			$stmt->bindparam(":dni1",$dni1);
			$stmt->bindparam(":dni2",$dni2);
			$stmt->bindparam(":tutorea",$tutorea);
			$stmt->bindparam(":email_tutorea",$email_tutorea);
			$stmt->bindparam(":ikastetxea",$ikastetxea);
			$stmt->bindparam(":oharra",$oharra);
			
			$stmt->bindparam(":id",$id);
			// execution de la requete :
			$stmt->execute();
			return true;	
		}
		catch(PDOException $e) // vérification des erreurs.
		{
			echo $e->getMessage();	
			return false;
		}
	}
	

	// modification d'un utilisateur avec tous les champs.
	public function updateWithImage($id,$fname,$lname,$email1,$contact_no1,$hours,$active,$image,$ncuenta,$ikasmaila,
		$guraso1, $guraso2, $jaiotze_data, $helbidea, $email2, $contact_no2, $dni1, $dni2, $tutorea, $email_tutorea,
		$ikastetxea, $oharra)
	{
		try
		{
			// préparation de la requete :
			$stmt=$this->db->prepare("UPDATE tbl_ikasle SET first_name=:fname, 
		                                               last_name=:lname, 
													   email1=:email1, 
													   contact_no1=:contact_no1,
													   hours_per_week=:hours,
													   active=:active,
													   image_name=:image,
													   ncuenta=:ncuenta,
													   ikasmaila_id=:ikasmaila
													   guraso1=:guraso1,
													   guraso2=:guraso2,
													   jaiotze_data=:jaiotze_data,
													   helbidea=:helbidea,
													   email2=:email2,
													   contact_no2=:contact_no2,
													   dni1=:dni1,
													   dni2=:dni2,
													   tutorea=:tutorea,
													   email_tutorea=:email_tutorea,
													   ikastetxea_id=:ikastetxea,
													   oharra=:oharra
													WHERE id=:id ");
			// affectation des valeurs :
			$stmt->bindparam(":fname",$fname);
			$stmt->bindparam(":lname",$lname);
			$stmt->bindparam(":email1",$email1);
			$stmt->bindparam(":contact_no1",$contact_no1);
			$stmt->bindparam(":hours",$hours);
			$stmt->bindparam(":active",$active);
			$stmt->bindparam(":image",$image);
			$stmt->bindparam(":ncuenta",$ncuenta);
			$stmt->bindparam(":ikasmaila",$ikasmaila);
			
			$stmt->bindparam(":guraso1",$guraso1);
			$stmt->bindparam(":guraso2",$guraso2);
			$stmt->bindparam(":jaiotze_data",$jaiotze_data);
			$stmt->bindparam(":helbidea",$helbidea);
			$stmt->bindparam(":email2",$email2);
			$stmt->bindparam(":contact_no2",$contact_no2);
			$stmt->bindparam(":dni1",$dni1);
			$stmt->bindparam(":dni2",$dni2);
			$stmt->bindparam(":tutorea",$tutorea);
			$stmt->bindparam(":email_tutorea",$email_tutorea);
			$stmt->bindparam(":ikastetxea",$ikastetxea);
			$stmt->bindparam(":oharra",$oharra);
			
			$stmt->bindparam(":id",$id);
			// execution de la requete :
			$stmt->execute();
			return true;	
		}
		catch(PDOException $e) // vérification des erreurs.
		{
			echo $e->getMessage();	
			return false;
		}
	}
	
	public function delete($id) // suppression d'un utilisateur par l'id.
	{
		$stmt = $this->db->prepare("DELETE FROM tbl_ikasle WHERE id=:id"); // préparation.
		$stmt->bindparam(":id",$id); // affectation du valeur
		$stmt->execute(); // execution 
		return true; // toujoure on retourne true or false pour 
	}                // l'utiliation aprés dans les autres pages.
	
		
	public function dataview($query) // l'affichage des données, on passe en paramétre une requete.
	{
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete	
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				?>
                <tr>
                	<td><?php print($row['id']); ?></td> <!--utilisation de print pour l'affichage de id pour ce ligne-->
                	<td><?php print($row['first_name']); ?></td><!--affichage de nome-->
                	<td><?php print($row['last_name']); ?></td><!--affichage de prénom-->
					<td><?php print($row['hours_per_week']); ?></td>
					<td><?php print($row['ikasmaila']); ?></td>
					<td><?php print($row['ikastetxea']); ?></td><!--affichage de email-->
                	<td><?php print($row['oharra']); ?></td><!--affichage de tél-->
					<td><?php print($row['creation_date_formated']); ?></td>
					<td><?php print($row['active']); ?></td>
					<td>
						<img class="img-rounded zoom" src="/ardatz/images/<?php print($row['image_name']); ?>" width="40" height="40"/>
					</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="ikasle_data_view.php?edit_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-eye-open"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="ikasle_edit.php?edit_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-edit"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de suppression-->
                	<a href="ikasle_delete.php?delete_id=<?php print($row['id']); ?>">
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
            <td>Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
            <?php
		}
		?>
		<tr>
            <td colspan="14">
                <label><?php print($this->getIkasleCount()); ?>-tik <?php print($this->getActiveIkasleCount()); ?> ikasle altan 3N-n</label>
            </td>
        </tr>
		<?php
	}	
	
	public function dataviewLiveSearch($query) // l'affichage des données, on passe en paramétre une requete.
	{
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete
		?>
		
		<tr>
			<th>N°</th>
            <th>Izena </th>
            <th>Abizena</th>
			<th>Ordu astero</th>
			<th>Ikasmaila</th>
			<th>Ikastetxea</th>
            <th>Oharra</th>
			<th>Noiztik</th>
			<th>Aktibo</th>
			<th>Argazkia </th>
            <th colspan="3" align="center">Actions</th>
        </tr>
		
		<?php
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				?>
                <tr>            
                	<td><?php print($row['id']); ?></td>
                	<td><?php print($row['first_name']); ?></td>
                	<td><?php print($row['last_name']); ?></td>
					<td><?php print($row['hours_per_week']); ?></td>
					<td><?php print($row['ikasmaila']); ?></td>
					<td><?php print($row['ikastetxea']); ?></td>
                	<td><?php print($row['oharra']); ?></td>
					<td><?php print($row['creation_date_formated']); ?></td>
					<td><?php print($row['active']); ?></td>
					<td>
						<img class="img-rounded zoom" src="/ardatz/images/<?php print($row['image_name']); ?>" width="40" height="40"/>
					</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="ikasle_data_view.php?edit_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-eye-open"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="ikasle_edit.php?edit_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-edit"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de suppression-->
                	<a href="ikasle_delete.php?delete_id=<?php print($row['id']); ?>">
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
            <td colspan="16">Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
        <?php
		}
		?>
		<tr>
            <td colspan="16">
                <label><?php print($this->getIkasleCount()); ?>-tik <?php print($this->getActiveIkasleCount()); ?> ikasle altan 3N-n</label>
            </td>
        </tr>
		<tr>
            <td colspan="16">
                <a href="../index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atras</a>
            </td>
        </tr>
		<?php
	}
	
	
	public function altaTutor($irakaslea_id, $ikaslea_id) 
	{
		$this->bajaTutor($irakaslea_id, $ikaslea_id);
		
		$stmt = $this->db->prepare("INSERT INTO tbl_tutore (ikasle_id, irakasle_id) VALUES(:ikaslea_id, :irakaslea_id); ");
		$stmt->bindparam(":ikaslea_id",$ikaslea_id);
		$stmt->bindparam(":irakaslea_id",$irakaslea_id);
		if($stmt->execute()){
			return '1';
		}else{
			return '0';
		}
		
	}
	
	public function bajaTutor($irakaslea_id, $ikaslea_id) 
	{
		//$stmt = $this->db->prepare("DELETE FROM tbl_tutore WHERE ikasle_id=:ikaslea_id AND irakasle_id=:irakaslea_id; ");
		$stmt = $this->db->prepare("DELETE FROM tbl_tutore WHERE ikasle_id=:ikaslea_id ");
		$stmt->bindparam(":ikaslea_id",$ikaslea_id);
		//$stmt->bindparam(":irakaslea_id",$irakaslea_id);
		if($stmt->execute()){
			return '0';
		}else{
			return '1';
		}
	}
	
	public function setKlaseEgunak($egunak, $ikaslea_id) 
	{
		$stmt = $this->db->prepare("UPDATE tbl_ikasle_egunak SET asteko_eguna = :egunak WHERE ikasle_id = :ikaslea_id; ");
		$stmt->bindparam(":ikaslea_id",$ikaslea_id);
		$stmt->bindparam(":egunak",$egunak);
		if($stmt->execute()){
			return '1';
		}else{
			return '0';
		}
	}
	
	
	public function dataviewIkasleDatuakEtaKlaseEgunak($query) // l'affichage des données, on passe en paramétre une requete.
	{
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete	
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				?>
                <tr>            
                	<td><?php print($row['ikasle_id']); ?></td>
                	<td><?php print($row['first_name']); ?></td>
                	<td><?php print($row['last_name']); ?></td>
					<td><?php print($row['ikasmaila']); ?></td>
					<td><?php print($row['ikastetxea']); ?></td>
					<td><?php print($row['hours_per_week']); ?></td>
	
<?php
					if($row['astelehena'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-astelehena' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-astelehena' class='form-control'/></td>";
					}
					if($row['asteartea'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-asteartea' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-asteartea' class='form-control'/></td>";
					}
					if($row['asteazkena'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-asteazkena' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-asteazkena' class='form-control'/></td>";
					}
					if($row['osteguna'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-osteguna' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-osteguna' class='form-control'/></td>";
					}
					if($row['ostirala'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-ostirala' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-ostirala' class='form-control'/></td>";
					}
					if($row['larunbata'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-larunbata' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-larunbata' class='form-control'/></td>";
					}
					if($row['igandea'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-igandea' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-igandea' class='form-control'/></td>";
					}
?>
				</tr>
<?php
				
			}
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
			?>
            <tr>
            <td>Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
            <?php
		}
	}	
	
	public function dataviewIkasleDatuakEtaKlaseEgunakLiveSearch($query) // l'affichage des données, on passe en paramétre une requete.
	{
		?>
		
		<tr>
			<th>N°</th>
            <th>Izena </th>
            <th>Abizena</th>
			<th>Ikasmaila</th>
			<th>Ikastetxea</th>
			<th>Orduak astero</th>
			<th>Astelehena</th>
			<th>Asteartea</th>
			<th>Asteazkena</th>
			<th>Osteguna</th>
			<th>Ostirala</th>
			<th>Larunbata</th>
			<th>Igandea</th>
        </tr>
		
		<?php
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				?>
                <tr>            
                	<td><?php print($row['ikasle_id']); ?></td>
                	<td><?php print($row['first_name']); ?></td>
                	<td><?php print($row['last_name']); ?></td>
					<td><?php print($row['ikasmaila']); ?></td>
					<td><?php print($row['ikastetxea']); ?></td>
					<td><?php print($row['hours_per_week']); ?></td>
<?php

					if($row['astelehena'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-astelehena' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-astelehena' class='form-control'/></td>";
					}
					if($row['asteartea'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-asteartea' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-asteartea' class='form-control'/></td>";
					}
					if($row['asteazkena'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-asteazkena' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-asteazkena' class='form-control'/></td>";
					}
					if($row['osteguna'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-osteguna' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-osteguna' class='form-control'/></td>";
					}
					if($row['ostirala'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-ostirala' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-ostirala' class='form-control'/></td>";
					}
					if($row['larunbata'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-larunbata' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-larunbata' class='form-control'/></td>";
					}
					if($row['igandea'] == '1'){
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-igandea' checked class='form-control'/></td>";
					}else{
						echo "<td><input type='checkbox' name='ikasle_klase_eguna-".$row['ikasle_id']."-igandea' class='form-control'/></td>";
					}
				
				
?>
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
	

	
	public function dataviewIkasleTutore($query) // l'affichage des données, on passe en paramétre une requete.
	{
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete	
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				?>
                <tr>            
                	<td><?php print($row['ikasle_id']); ?></td>
                	<td><?php print($row['first_name']); ?></td>
                	<td><?php print($row['last_name']); ?></td>
					<td><?php print($row['guraso1']); ?></td>
					<td><?php print($row['email1']); ?></td>
					<td><?php print($row['contact_no1']); ?></td>
					<td><?php print($row['guraso2']); ?></td>
					<td><?php print($row['email2']); ?></td>
					<td><?php print($row['contact_no2']); ?></td>
					<td><?php print($row['ikasmaila']); ?></td>
					<td><?php print($row['ikastetxea']); ?></td>
<?php

					$stmtTutore = $this->db->prepare("SELECT id, CONCAT(first_name, ' ', last_name) irakaslea FROM tbl_irakasle where active = 1;"); // préparation de la requete 
					$stmtTutore->execute(); // exectuion de la requete
					if($stmtTutore->rowCount() > 0) // teste sur le nembres des ligne retourner, 
					{	// si il y a des ligne on va l'afficher :
						while($rowTutore=$stmtTutore->fetch(PDO::FETCH_ASSOC)) 
						{	
							if($row['irakasle_id'] != null && $row['irakasle_id'] == $rowTutore['id']){
								echo "<td><input type='checkbox' name='ikasle_irakasle-".$row['ikasle_id']."-".$rowTutore['id']."' checked class='form-control'/></td>";
							}else{
								echo "<td><input type='checkbox' name='ikasle_irakasle-".$row['ikasle_id']."-".$rowTutore['id']."' class='form-control'/></td>";
							}
							
						}
					}
?>
				</tr>
<?php
				
			}
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
			?>
            <tr>
            <td>Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
            <?php
		}
	}	
	
	
	
	public function dataviewIkasleTutoreLiveSearch($query) // l'affichage des données, on passe en paramétre une requete.
	{
		?>
		
		<tr>
			<th>N°</th>
            <th>Izena </th>
            <th>Abizena</th>
			<th>Guraso 1</th>
			<th>Email 1</th>
			<th>Telefonoa 1</th>
			<th>Guraso 2</th>
			<th>Email 1</th>
			<th>Telefonoa 2</th>
			<th>Ikasmaila</th>
			<th>Ikastetxea</th>
<?php
		$irakasleak = array();
		$index = 0;
		$stmtTutore = $this->db->prepare("SELECT id, CONCAT(first_name, ' ', last_name) irakaslea FROM tbl_irakasle where active = 1;"); // préparation de la requete 
		$stmtTutore->execute(); // exectuion de la requete
		if($stmtTutore->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($rowTutore=$stmtTutore->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{			
				$irakasleak[$index];
				$index++;
				echo "<th>".$rowTutore['irakaslea']."</th>";
			}
		}
?>
        </tr>
		
		<?php
		$stmt = $this->db->prepare($query); // préparation de la requete 
		$stmt->execute(); // exectuion de la requete
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				?>
                <tr>            
                	<td><?php print($row['ikasle_id']); ?></td>
                	<td><?php print($row['first_name']); ?></td>
                	<td><?php print($row['last_name']); ?></td>
					<td><?php print($row['guraso1']); ?></td>
					<td><?php print($row['email1']); ?></td>
					<td><?php print($row['contact_no1']); ?></td>
					<td><?php print($row['guraso2']); ?></td>
					<td><?php print($row['email2']); ?></td>
					<td><?php print($row['contact_no2']); ?></td>
					<td><?php print($row['ikasmaila']); ?></td>
					<td><?php print($row['ikastetxea']); ?></td>
<?php

					$stmtTutore = $this->db->prepare("SELECT id, CONCAT(first_name, ' ', last_name) irakaslea FROM tbl_irakasle where active = 1;"); // préparation de la requete 
					$stmtTutore->execute(); // exectuion de la requete
					if($stmtTutore->rowCount() > 0) // teste sur le nembres des ligne retourner, 
					{	// si il y a des ligne on va l'afficher :
						while($rowTutore=$stmtTutore->fetch(PDO::FETCH_ASSOC)) 
						{	
							if($row['irakasle_id'] != null && $row['irakasle_id'] == $rowTutore['id']){
								echo "<td><input type='checkbox' name='ikasle_irakasle-".$row['ikasle_id']."-".$rowTutore['id']."' checked class='form-control'/></td>";
							}else{
								echo "<td><input type='checkbox' name='ikasle_irakasle-".$row['ikasle_id']."-".$rowTutore['id']."' class='form-control'/></td>";
							}
							
						}
					}
				
				
?>
				</tr>
				
<?php
				
			}
		}
		else // si on a aucune ligen sur la table de la base de donées,
		{
			?>
            <tr>
            <td colspan="14">Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
        <?php
		}
		
		?>
		<tr>
            <td colspan="14">
                <a href="../index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atras</a>
            </td>
        </tr>
		<?php
	}
	
}
?>