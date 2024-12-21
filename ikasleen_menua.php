
<?php session_start(); ?>
	<?php
	if(isset($_SESSION['valid'])) {			
		include_once 'dbconfig.php';
		include_once 'header.php';
	?>

<div class="container" style="width: 100%;
    color: #333333;
    margin: 0 auto;
    overflow: hidden;
    padding: 10px 0;
    align-items: center;
    justify-content: space-around;
    display: flex;
    float: none;">
     <div class="col-md-3" onclick="location.href='chart-ikasle-denak.php';">
        <a class="btn btn-block btn-lg btn-success" data-toggle="modal" data-target="#mymodal" href='chart-ikasle-denak.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">Estadistikak</span></a>
      </div>
      <div class="col-md-3" onclick="location.href='ordutegia_view.php';">
        <a class="btn btn-block btn-lg btn-danger" data-toggle="modal" data-target="#mymodal" href='ordutegia_view.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">Ordutegia</span></a>
      </div>
</div>
<br>
<div center class="container" style="width: 100%;
    color: #333333;
    margin: 0 auto;
	
    overflow: hidden;
    padding: 10px 0;
    align-items: center;
    justify-content: space-around;
    display: flex;
    float: none;">
	  
      <div class="col-md-3" onclick="location.href='tutoreak_view.php';">
        <a class="btn btn-block btn-lg btn-primary" data-toggle="modal" data-target="#mymodal" href='tutoreak_view.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">Datuak</span></a>
      </div> 
      <div class="col-md-3" onclick="location.href='egunerokoa_view.php';">
        <a class="btn btn-block btn-lg btn-info" data-toggle="modal" data-target="#mymodal" href='egunerokoa_view.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">Egunerokoa</span></a>
      </div>
</div>
<br>
<div center class="container" style="width: 100%;
    color: #333333;
    margin: 0 auto;
    overflow: hidden;
    padding: 10px 0;
    align-items: center;
    justify-content: space-around;
    display: flex;
    float: none;">
	  <a href="index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
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