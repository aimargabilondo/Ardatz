<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';


	$error = '';
	if(isset($_POST['btn-save'])){
		$fname = $_POST['first_name'];
		$lname = $_POST['last_name'];
		$email = $_POST['email_id'];
		$contact = $_POST['contact_no'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$active = $_POST['active'];
		
		if($password != $password2){
			$error = 'Pasahitzak ez dira berdinak!';
			//header("Location: irakasle_add.php?failure");
		}else{
			if($irakasleCrud->create($fname,$lname,$email,$contact,$username,$password,$active)){ // test sur l'execution du requete, 
				header("Location: irakasle_add.php?inserted");    // si tout passe bien returne true, et on recharge la page
			}else{
				$error = 'Arazo bat egon da eta ezin izan da gorde.';					
				//header("Location: irakasle_add.php?failure");     // sinon on recharge la page avec "failure" comme paramétre.
			}
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
				<td>Izena </td><td><input type='text' name='first_name' class='form-control' required></td>
			</tr>
			<tr>
				<td>Abizena </td><td><input type='text' name='last_name' class='form-control' required></td>
			</tr>
			<tr>
				<td>E-mail </td><td><input type='text' name='email_id' class='form-control'></td>
			</tr>
			<tr>
				<td>Telefonoa </td><td><input type='text' name='contact_no' class='form-control'></td>
			</tr>
			<tr>
				<td>Erabiltzailea </td><td><input type='text' name='username' class='form-control' required></td>
			</tr>
			<tr>
				<td>Pasahitza </td><td><input type='text' name='password' class='form-control' required></td>			
			</tr>
			<tr>
				<td>Pasahitza errepikatu </td><td><input type='text' name='password2' class='form-control' required></td>
				
			</tr>
			<tr>
				<td>Aktibo </td><td><input type='checkbox' name='active' value='<?php echo $_POST['active']; ?>' class='form-control'></td>
			</tr>
			<tr>
				<td colspan="2">
				<!--btn-save : button de confirmation-->
				<button type="submit" class="btn btn-primary" name="btn-save">
				<span class="glyphicon glyphicon-plus"></span> Gorde</button>
				<!--lien de retour vers l'index-->  
				<a href="irakasle_view.php" class="btn btn-large btn-success" style="float: right;">
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
			<form method='post'><!--creation de la form avec la method post-->
			<table class='table table-bordered'>
				<tr>
					<td>Izena </td><td><input type='text' name='first_name' class='form-control' required></td>
				</tr>
				<tr>
					<td>Abizena </td><td><input type='text' name='last_name' class='form-control' required></td>
				</tr>
				<tr>
					<td>E-mail </td><td><input type='text' name='email_id' class='form-control'></td>
				</tr>
				<tr>
					<td>Telefonoa </td><td><input type='text' name='contact_no' class='form-control'></td>
				</tr>
				<tr>
					<td>Erabiltzailea </td><td><input type='text' name='username' class='form-control' required></td>
				</tr>
				<tr>
					<td>Pasahitza </td><td><input type='text' name='password' class='form-control' required></td>			
				</tr>
				<tr>
					<td>Pasahitza errepikatu </td><td><input type='text' name='password2' class='form-control' required></td>
				</tr>
				<tr>
					<td>Aktibo </td><td><input type='checkbox' name='active' class='form-control'></td>
				</tr>
				<tr>
					<td colspan="2">
					<!--btn-save : button de confirmation-->
					<button type="submit" class="btn btn-primary" name="btn-save">
					<span class="glyphicon glyphicon-plus"></span> Gorde</button>
					<!--lien de retour vers l'index-->  
					<a href="irakasle_view.php" class="btn btn-large btn-success" style="float: right;">
					<i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
					</td>
				</tr>
			</table><!--fin du tableau-->
		</form><!--fin de form-->
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