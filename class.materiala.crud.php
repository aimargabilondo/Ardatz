<?php

class materialaCrud // la class des operations avec la base de données.
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}

	
	public function create($Deskripzioa,$Prezioa,$Stock_Min,$Stock_Now) // methode d'insertion des données.
	{
		try
		{
			// préparation de la requete :
			$stmt = $this->db->prepare(
				"INSERT INTO tbl_materialak(Deskripzioa,Prezioa,Stock_Min,Stock_Now) 
						VALUES(:Deskripzioa, :Prezioa, :Stock_Min, :Stock_Now)");
			// affectations des valeurs :
			$stmt->bindparam(":Deskripzioa",$Deskripzioa);
			$stmt->bindparam(":Prezioa",$Prezioa);
			$stmt->bindparam(":Stock_Min",$Stock_Min);
			$stmt->bindparam(":Stock_Now",$Stock_Now);
			// execution de la reqeute :
			return $stmt->execute();
		}
		catch(PDOException $e) // l'utilisation de "try catch" pour vérifier si on a des erreurs, 
		{					   // et afficher des messages.
			echo $e->getMessage();	
			return false;
		}	
	}
	
	public function getById($Materiala_ID)  // return les informations de l'utilisateur qui est équivalant à l'id entré aux paramétre. 
	{
		$stmt = $this->db->prepare("SELECT * FROM tbl_materialak WHERE Materiala_ID=:Materiala_ID"); // preparation de la requete sql avec l'id.
		$stmt->execute(array(":Materiala_ID"=>$Materiala_ID)); // execution de la requete.
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC); // affectation de la la résultat (un ligne de tableau). 
		return $editRow;
	}

	// modification d'un utilisateur avec tous les champs.
	public function update($Materiala_ID,$Deskripzioa,$Prezioa,$Stock_Min,$Stock_Now)
	{
		try
		{
			// préparation de la requete :
			$stmt=$this->db->prepare("UPDATE tbl_materialak SET 
		                                               Deskripzioa=:Deskripzioa, 
													   Prezioa=:Prezioa, 
													   Stock_Min=:Stock_Min,
													   Stock_Now=:Stock_Now
													WHERE Materiala_ID=:Materiala_ID ");
			// affectation des valeurs :

			$stmt->bindparam(":Deskripzioa",$Deskripzioa);
			$stmt->bindparam(":Prezioa",$Prezioa);
			$stmt->bindparam(":Stock_Min",$Stock_Min);
			$stmt->bindparam(":Stock_Now",$Stock_Now);
			$stmt->bindparam(":Materiala_ID",$Materiala_ID);
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
			
	public function delete($Materiala_ID) // suppression d'un utilisateur par l'id.
	{
		$stmt = $this->db->prepare("DELETE FROM tbl_materialak WHERE Materiala_ID=:Materiala_ID"); // préparation.
		$stmt->bindparam(":Materiala_ID",$Materiala_ID); // affectation du valeur
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
                	<td><?php print($row['Materiala_ID']); ?></td> <!--utilisation de print pour l'affichage de id pour ce ligne-->
                	<td><?php print($row['Deskripzioa']); ?></td><!--affichage de nome-->
                	<td><?php print($row['Prezioa']); ?></td><!--affichage de prénom-->
                	<td><?php print($row['Stock_Min']); ?></td><!--affichage de email-->
                	<td><?php print($row['Stock_Now']); ?></td><!--affichage de tél-->
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="materiala_edit.php?edit_Materiala_ID=<?php print($row['Materiala_ID']); ?>">
					<i class="glyphicon glyphicon-edit"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de suppression-->
                	<a href="materiala_delete.php?delete_Materiala_ID=<?php print($row['Materiala_ID']); ?>">
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
            <th>Deskripzioa </th>
            <th>Prezioa</th>
            <th>Stock_Min</th>
            <th>Stock_Now</th>
            <th colspan="2" align="center">Actions</th>
        </tr>
		
		<?php
		if($stmt->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				?>
                <tr>
                	<td><?php print($row['Materiala_ID']); ?></td> <!--utilisation de print pour l'affichage de id pour ce ligne-->
                	<td><?php print($row['Deskripzioa']); ?></td><!--affichage de nome-->
                	<td><?php print($row['Prezioa']); ?></td><!--affichage de prénom-->
                	<td><?php print($row['Stock_Min']); ?></td><!--affichage de email-->
                	<td><?php print($row['Stock_Now']); ?></td><!--affichage de tél-->
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de modification-->
                	<a href="materiala_edit.php?edit_Materiala_ID=<?php print($row['Materiala_ID']); ?>">
					<i class="glyphicon glyphicon-edit"></i> <!--utilisation d'une icone de bootstrap-->
					</a>
                	</td>
                	<td align="center">
					<!--ici on va crée par l'id de la ligne courant, un lien vers la page de suppression-->
                	<a href="materiala_delete.php?delete_Materiala_ID=<?php print($row['Materiala_ID']); ?>">
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
                <a href="../index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
            </td>
        </tr>
		<?php
	}
	
}
?>