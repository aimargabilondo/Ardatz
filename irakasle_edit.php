<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';

if(isset($_POST['btn-update']))
{
	$id = $_GET['edit_id'];
	$fname = $_POST['first_name'];
	$lname = $_POST['last_name'];
	$email = $_POST['email_id'];
	$contact = $_POST['contact_no'];
	$username = $_POST['username'];
	
	

	if(isset($_POST['active'])){
		$active = $_POST['active'];
		if($active == 'on'){
			$active = 1;
		}
		else{
			$active = 0;
		}
	}else{
		$active = 0;
	}
  
	if($irakasleCrud->update($id,$fname,$lname,$email,$contact,$username,$active))
	{
		$msg = "<div class='alert alert-info'>
				Ondo gorde da!
				</div>";
	}
	else
	{
		$msg = "<div class='alert alert-warning'>
				Ezin izan da gorde!
                </div>";
	}
}else if(isset($_POST['btn-update-password']))
{
	$id = $_GET['edit_id'];
	$password = Password::hash($_POST['password']);
  
	if($irakasleCrud->updatePassword($id,$password))
	{
		$msg = "<div class='alert alert-info'>
				Ondo gorde da!
				</div>";
	}
	else
	{
		$msg = "<div class='alert alert-warning'>
				Ezin izan da gorde!
                </div>";
	}
}

if(isset($_GET['edit_id']))
{
	$id = $_GET['edit_id'];
	extract($irakasleCrud->getById($id));	
}
?>

<?php include_once 'header.php'; ?>
<div class="container">
<?php
if(isset($msg))
{
	echo $msg;
}
?>
</div>
<div class="container">	 
    <form method='post'>
		<table class='table table-bordered'>
			<tr>
				<td>Izena</td>
				<td><input type='text' name='first_name' class='form-control' value="<?php echo $first_name; ?>" required></td>
			</tr>
	 
			<tr>
				<td>Abizena</td>
				<td><input type='text' name='last_name' class='form-control' value="<?php echo $last_name; ?>" required></td>
			</tr>
	 
			<tr>
				<td>E - mail</td>
				<td><input type='text' name='email_id' class='form-control' value="<?php echo $email_id; ?>" required></td>
			</tr>
	 
			<tr>
				<td>Telefonoa</td>
				<td><input type='text' name='contact_no' class='form-control' value="<?php echo $contact_no; ?>" required></td>
			</tr>
			<tr>
				<td>Erabiltzailea </td>
				<td><input type='text' name='username' value="<?php echo $username; ?>" class='form-control' required></td>
			</tr>
			<?php
			if($_SESSION['id'] == 0){
			?>
			<tr>
				<td>Aktibo </td>
				<td><input type='checkbox' name='active' <?php echo ($active=='1'?'checked':''); ?> class='form-control'></td>
			</tr>
			<?php		
			}
			?>

			<tr>
				<td colspan="2">
					<button type="submit" class="btn btn-primary" name="btn-update">
					<span class="glyphicon glyphicon-edit"></span>  Aldatu datuak
					</button>
			<?php
			if($_SESSION['id'] != 0 ){
			?>

					<a href="irakasle_user.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
			<?php		
			}
			?>
			<?php
			if($_SESSION['id'] == 0){
			?>
					<a href="irakasle_view.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
			<?php		
			}
			?>
				</td>
			</tr>
		</table>
	</form>
	   <form method='post'>
		<table class='table table-bordered'>
			
			<tr>
				<td>Pasahitza </td>
				<td><input type='password' name='password' value="AAAAAAAAA" class='form-control' required></td>			
			</tr>
			<tr>
				<td>Pasahitza errepikatu </td>
				<td><input type='password' name='password2' value="AAAAAAAAA" class='form-control' required></td>
				
			</tr>
 
			<tr>
				<td colspan="2">
					<button type="submit" class="btn btn-primary" name="btn-update-password">
					<span class="glyphicon glyphicon-edit"></span>  Aldatu pasagitza
					</button>
			<?php
			if($_SESSION['id'] != 0 ){
			?>

					<a href="irakasle_user.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
			<?php		
			}
			?>
			<?php
			if($_SESSION['id'] == 0){
			?>
					<a href="irakasle_view.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
			<?php		
			}
			?>
				</td>
			</tr>
		</table>
	</form>
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