<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>

<script src="ikasle_live_search.js"></script>
<div class="container">
    <!--lien vers la page d'ajoute d'utilisateur-->
    <a href="ikasle_add.php" class="btn btn-large btn-info">
        <i class="glyphicon glyphicon-plus"></i> &nbsp; Gehitu ikaslea
		<a href="index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
    </a>
</div>
<br />
<div class="container"> 
    <div class="search-box">
        <input type="text" name="ikasle" autocomplete="off" placeholder="Ikaslea..." />
        <div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
    </div>
	
	<div class="search-box">
        <input type="text" name="ikastetxe" autocomplete="off" placeholder="Ikastetxea..." />
        <div class="result"></div><input type='hidden' name='ikastetxe-id' class='form-control'>
    </div>
	
	<div class="search-box">
        <input type="text" name="maila" autocomplete="off" placeholder="Maila..." />
        <div class="result"></div><input type='hidden' name='maila-id' class='form-control'>
    </div>
	</br>
	<label>Ikaslearen egoera:</label>
	<input type="radio" id="todos" name="estado" value="2"> Denak
	<input type="radio" id="activados" name="estado" value="1" checked> Aktibatuta
	<input type="radio" id="desactivados" name="estado" value="0"> Desaktibatuta
	</br>

	<div style="display:inline-block;">
		<button name="search" class="btn btn-default" onclick="">Bilatu</button>
		<button name="clean" class="btn btn-default" onclick="">Garbitu</button>&nbsp;
		<button class="btn btn-danger" name="btn-export" style="float: right;">
		
		<span class="glyphicon glyphicon-send"></span> &nbsp; Exportatu</button>
		<!-- Image loader -->
		<div id='loader' style='display: none;'>
		  <img src='reload.gif' width='32px' height='32px'>
		</div>
		<!-- Image loader -->
	</div>
	

	
    <!--creation du tableau-->
	<table class='table table-bordered table-responsive' id='values_table'> 
        <tr>
            <th>N°</th>
            <th>Izena </th>
            <th>Abizena </th>
            <th>Orduak astero </th>
			<th>Ikasmaila</th>
            <th>Ikastetxea </th>
			<th>Oharra </th>
			<th>Noiztik </th>
			<th>Aktibo </th>
			<th>Argazkia </th>
            <th colspan="3" align="center">Actions</th>
        </tr>
        <?php    
		  $ikasleCrud->dataview("SELECT ikasle.*, tarifa.ikasmaila, etxea.izena ikastetxea, date_format(ikasle.creation_date, '%Y-%m-%d') creation_date_formated FROM tbl_ikasle ikasle join tbl_tarifak tarifa on tarifa.id = ikasle.ikasmaila_id join tbl_ikastetxea etxea on etxea.id = ikasle.ikastetxea_id where ikasle.active=1 order by ikasle.id"); // l'appele du méthode d'affichage.
	    ?>
		<tr>
            <td colspan="16">
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