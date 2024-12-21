<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>

<script src="asteko_egunak_live_search.js"></script>

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
	<div style="display:inline-block;">
		<button name="search" class="btn btn-default" onclick="">Bilatu</button>
		<button name="clean" class="btn btn-default" onclick="">Garbitu</button>&nbsp;
		<button class="btn btn-danger" name="btn-copy" style="float: right;">
		<span class="glyphicon glyphicon-send"></span> &nbsp; Exportatu</button>
	</div>
    <!--creation du tableau-->
	<table class='table table-bordered table-responsive' id='values_table'> 
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
		  $ikasleCrud->dataviewIkasleDatuakEtaKlaseEgunak(" 			
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
			  order by ikasle.id;");
	    ?>
		<tr>
            <td colspan="13">
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