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
     <div class="col-md-3" onclick="location.href='1_gela.php';">
        <a class="btn btn-block btn-lg btn-success" data-toggle="modal" data-target="#mymodal" href='1_gela.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">1. gela - LH</span></a>
      </div>
      <div class="col-md-3" onclick="location.href='2_gela.php';">
        <a class="btn btn-block btn-lg btn-danger" data-toggle="modal" data-target="#mymodal" href='2_gela.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">2. gela</span></a>
      </div> 
	  <div class="col-md-3" onclick="location.href='3_gela.php';">
        <a class="btn btn-block btn-lg btn-primary" data-toggle="modal" data-target="#mymodal" href='3_gela.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">3. gela</span></a>
      </div>
</div>
</br>
<div center class="container" style="width: 100%;
    color: #333333;
    margin: 0 auto;
	
    overflow: hidden;
    padding: 10px 0;
    align-items: center;
    justify-content: space-around;
    display: flex;
    float: none;">
	  
      <div class="col-md-3" onclick="location.href='4_gela.php';">
        <a class="btn btn-block btn-lg btn-warning" data-toggle="modal" data-target="#mymodal" href='4_gela.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">4. gela</span></a>
      </div> 
      <div class="col-md-3" onclick="location.href='5_gela.php';">
        <a class="btn btn-block btn-lg btn-info" data-toggle="modal" data-target="#mymodal" href='5_gela.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">5. gela</span></a>
      </div>
	  <div class="col-md-3" onclick="location.href='ikasleen_menua.php';">
        <a class="btn btn-block btn-lg btn-success" data-toggle="modal" data-target="#mymodal" href='ikasleen_menua.php'>
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande">Ikasleak</span></a>
      </div>


</div>
</br>
<div class="container" style="width: 100%;
    color: #333333;
    margin: 0 auto;
    overflow: hidden;
    padding: 10px 0;
    align-items: center;
    justify-content: space-around;
    display: flex;
    float: none;">
	<div class="col-md-4">
        <table class="table table-dark w-auto" >
		  <thead>
			<tr>
			  <th scope="col">Izena </th>
			  <th scope="col">Egoera </th>
			  <th scope="col">&nbsp; </th>
			  <th scope="col">Izena </th>
			  <th scope="col">Egoera </th>
			</tr>
		  </thead>
		  <tbody>
            <?php $egunerokoaCrud->checkLastDayWork(); ?>
		  </tbody>
		</table>
	</div>
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
