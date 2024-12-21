<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>
<script src="irakasle_live_search.js"></script>
<div class="container">
    <!--lien vers la page d'ajoute d'utilisateur-->
    <a href="irakasle_add.php" class="btn btn-large btn-info">
        <i class="glyphicon glyphicon-plus"></i> &nbsp; Gehitu irakaslea
		<a href="index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
    </a>
</div>
<br />
<div class="container"> 
    <div class="search-box">
        <input type="text" autocomplete="off" placeholder="Bilatu izena..." />
        <div class="result"></div>
    </div>
    <!--creation du tableau-->
	<table class='table table-bordered table-responsive' id='values_table'> 
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
		  $irakasleCrud->dataview("SELECT * FROM tbl_irakasle order by id"); // l'appele du méthode d'affichage.
	    ?>
		<tr>
            <td colspan="10">
                <a href="index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
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