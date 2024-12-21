<?php

class IrakasleCrud // la class des operations avec la base de données.
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
	
	public function create($fname,$lname,$email,$contact,$username,$password,$active) // methode d'insertion des données.
	{
		try
		{
			// préparation de la requete :
			$stmt = $this->db->prepare(
				"INSERT INTO tbl_irakasle(first_name,last_name,email_id,contact_no,username,password,active) 
						VALUES(:fname, :lname, :email, :contact, :username, :password, :active)");
			// affectations des valeurs :
			$stmt->bindparam(":fname",$fname);
			$stmt->bindparam(":lname",$lname);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":contact",$contact);
			$stmt->bindparam(":username",$username);
			$stmt->bindparam(":password",$password);
			$stmt->bindparam(":active",$active);
			// execution de la reqeute :
			return $stmt->execute();
		}
		catch(PDOException $e) // l'utilisation de "try catch" pour vérifier si on a des erreurs, 
		{					   // et afficher des messages.
			echo $e->getMessage();	
			return false;
		}	
	}
	
	public function getById($id)  // return les informations de l'utilisateur qui est équivalant à l'id entré aux paramétre. 
	{
		$stmt = $this->db->prepare("SELECT * FROM tbl_irakasle WHERE id=:id"); // preparation de la requete sql avec l'id.
		$stmt->execute(array(":id"=>$id)); // execution de la requete.
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC); // affectation de la la résultat (un ligne de tableau). 
		return $editRow;
	}

	// modification d'un utilisateur avec tous les champs.
	public function update($id,$fname,$lname,$email,$contact,$username,$active)
	{
		try
		{
			// préparation de la requete :
			$stmt=$this->db->prepare("UPDATE tbl_irakasle SET first_name=:fname, 
		                                               last_name=:lname, 
													   email_id=:email, 
													   contact_no=:contact,
													   username=:username,
													   active=:active
													WHERE id=:id ");
			// affectation des valeurs :
			$stmt->bindparam(":fname",$fname);
			$stmt->bindparam(":lname",$lname);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":contact",$contact);
			$stmt->bindparam(":username",$username);
			$stmt->bindparam(":active",$active);
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
	
	public function updatePassword($id,$password)
	{
		try
		{
			// préparation de la requete :
			$stmt=$this->db->prepare("UPDATE tbl_irakasle SET password=:password WHERE id=:id ");
			// affectation des valeurs :
			$stmt->bindparam(":password",$password);
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
		$stmt = $this->db->prepare("DELETE FROM tbl_irakasle WHERE id=:id"); // préparation.
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
                	<td><?php print($row['email_id']); ?></td><!--affichage de email-->
                	<td><?php print($row['contact_no']); ?></td><!--affichage de tél-->
					<td><?php print($row['username']); ?></td>
					<td><?php print($row['creation_date']); ?></td>
					<td><?php print($row['active'])?'Bai':'Ez'; ?></td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="irakasle_edit.php?edit_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-edit"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de suppression-->
                	<a href="irakasle_delete.php?delete_id=<?php print($row['id']); ?>">
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
            <td colspan="10">Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
            <?php
		}
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
            <th>E-mail</th>
            <th>Telefonoa</th>
			<th>Erabiltzailea</th>
			<th>Noiztik</th>
			<th>Aktibo</th>
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
                	<td><?php print($row['first_name']); ?></td><!--affichage de nome-->
                	<td><?php print($row['last_name']); ?></td><!--affichage de prénom-->
                	<td><?php print($row['email_id']); ?></td><!--affichage de email-->
                	<td><?php print($row['contact_no']); ?></td><!--affichage de tél-->
					<td><?php print($row['username']); ?></td>
					<td><?php print($row['creation_date']); ?></td>
					<td><?php print($row['active'])?'Bai':'Ez'; ?></td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="irakasle_edit.php?edit_id=<?php print($row['id']); ?>">
					<i class="glyphicon glyphicon-edit"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de suppression-->
                	<a href="irakasle_delete.php?delete_id=<?php print($row['id']); ?>">
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
            <td colspan="10">Ez dago daturik...</td><!--on affiche la table vide-->
            </tr>
        <?php
		}
		
		?>
		<tr>
            <td colspan="10">
                <a href="../index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atras</a>
            </td>
        </tr>
		<?php
	}
	
}
?>