<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>
<style>
table {
  font-size: small;
}
</style>
<script src="tutoreak_live_search.js"></script>

<div class="scrollable"> 
    <div class="search-box">
        <input type="text" name="ikasle" autocomplete="off" placeholder="Ikaslea..." />
        <div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
    </div>
	
	<div class="search-box">
        <input type="text" name="irakasle" autocomplete="off" placeholder="Irakaslea..." />
        <div class="result"></div><input type='hidden' name='irakasle-id' class='form-control'>
    </div>
	
	<div style="display:inline-block;">
		<button name="search" class="btn btn-default" onclick="">Bilatu</button>
		<button name="clean" class="btn btn-default" onclick="">Garbitu</button>&nbsp;
		<!--<button class="btn btn-danger" name="btn-copy" style="float: right;">
		<span class="glyphicon glyphicon-send"></span> &nbsp; Exportatu</button>-->
	</div>
    <!--creation du tableau-->
	<table class='table table-bordered table-responsive' id='values_table'> 
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
		$stmtTutore = $DB_con->prepare("SELECT id, CONCAT(first_name, ' ', last_name) irakaslea FROM tbl_irakasle where active = 1;"); // préparation de la requete 
		$stmtTutore->execute(); // exectuion de la requete
		if($stmtTutore->rowCount() > 0) // teste sur le nembres des ligne retourner, 
		{	// si il y a des ligne on va l'afficher :
			while($rowTutore=$stmtTutore->fetch(PDO::FETCH_ASSOC)) // tant qu'on a la ligne, on affecte ce ligne 
			{									       // et on affiche ce ligne sur le tableau html 
				echo "<th>".$rowTutore['irakaslea']."</th>";
			}
		}
?>
        </tr>
        <?php    
		  $ikasleCrud->dataviewIkasleTutore(" select
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
								  where ikasle.active = 1
								  order by ikasle.id;");
	    ?>
		<tr>
            <td colspan="12">
                <a href="index.php" class="btn btn-lar ge btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
            </td>
        </tr>
    </table> 
</div>
	<?php	
	} else {
		//session_start();
		//session_destroy();
		header("Location:login.php");
		
	}
	?>
	<div id="footer">
		<?php include_once 'footer.php'; ?> <!--inclure le footer de la page -->
	</div>
</body>
</html>