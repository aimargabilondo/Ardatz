<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';


	$error = '';
	if(isset($_POST['btn-save'])){
		$Deskripzioa = $_POST['Deskripzioa'];
		$Prezioa = $_POST['Prezioa'];
		$Stock_Min = $_POST['Stock_Min'];
		$Stock_Now = $_POST['Stock_Now'];
		
		if($materialaCrud->create($Deskripzioa,$Prezioa,$Stock_Min,$Stock_Now)){ // test sur l'execution du requete, 
			header("Location: materiala_add.php?inserted");    // si tout passe bien returne true, et on recharge la page
		}else{
			$error = 'Arazo bat egon da eta ezin izan da gorde.';					
			//header("Location: materiala_add.php?failure");     // sinon on recharge la page avec "failure" comme paramétre.
		}
		
	}
	?>

	<?php
	if($error != ''){
		?>
		<div class="container">
		   <div class="alert alert-warning">
			<?php echo $error; ?>
		   </div>
		</div>
	<div class="container">
		<form method='post'>
		<table class='table table-bordered'>
			<tr>
				<td>Deskripzioa </td><td><input type='text' name='Deskripzioa' class='form-control' required></td>
			</tr>
			<tr>
				<td>Prezioa </td><td><input type="number" step="any" name='Prezioa' class='form-control' required></td>
			</tr>
			<tr>
				<td>Gutxieneko Stock-a </td><td><input type='number' name='Stock_Min' class='form-control'></td>
			</tr>
			<tr>
				<td>Oraingo Stock-a </td><td><input type='number' name='Stock_Now' class='form-control'></td>
			</tr>
			<tr>
				<td colspan="2">
				<!--btn-save : button de confirmation-->
				<button type="submit" class="btn btn-primary" name="btn-save">
				<span class="glyphicon glyphicon-plus"></span> Gorde</button>
				<!--lien de retour vers l'index-->  
				<a href="materialak.php" class="btn btn-large btn-success" style="float: right;">
				<i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
				</td>
			</tr>
		</table>
	</form>
	</div>
	<?php
	}else{

		if(isset($_GET['inserted'])){
		?>
			<div class="container">
			   <div class="alert alert-info">
				Ondo gorde da! <!-- le message a afficher avec un style de bootstrap de success--> 
			   </div>
			</div>	
		<?php } ?>

			<div class="container">
		<form method='post'>
		<table class='table table-bordered'>

			<tr>
				<td>Deskripzioa </td><td><input type='text' name='Deskripzioa' class='form-control' required></td>
			</tr>
			<tr>
				<td>Prezioa </td><td><input type="number" step="any" name='Prezioa' class='form-control' required></td>
			</tr>
			<tr>
				<td>Gutxieneko Stock-a </td><td><input type='number' name='Stock_Min' class='form-control'></td>
			</tr>
			<tr>
				<td>Oraingo Stock-a </td><td><input type='number' name='Stock_Now' class='form-control'></td>
			</tr>
			<tr>
				<td colspan="2">
				<!--btn-save : button de confirmation-->
				<button type="submit" class="btn btn-primary" name="btn-save">
				<span class="glyphicon glyphicon-plus"></span> Gorde</button>
				<!--lien de retour vers l'index-->  
				<a href="materialak.php" class="btn btn-large btn-success" style="float: right;">
				<i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
				</td>
			</tr>
		</table>
	</form>
	</div>
	<?php } ?>

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