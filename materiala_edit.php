<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';

if(isset($_POST['btn-update']))
{
	$Materiala_ID = $_GET['edit_Materiala_ID'];
	$Deskripzioa = $_POST['Deskripzioa'];
	$Prezioa = $_POST['Prezioa'];
	$Stock_Min = $_POST['Stock_Min'];
	$Stock_Now = $_POST['Stock_Now'];
	
	  
	if($materialaCrud->update($Materiala_ID,$Deskripzioa,$Prezioa,$Stock_Min,$Stock_Now))
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

if(isset($_GET['edit_Materiala_ID']))
{
	$Materiala_ID = $_GET['edit_Materiala_ID'];
	extract($materialaCrud->getById($Materiala_ID));	
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
				<td>Deskripzioa </td><td><input type='text' name='Deskripzioa' class='form-control' value="<?php echo $Deskripzioa; ?>" required></td>
			</tr>
			<tr>
				<td>Prezioa </td><td><input type="number" step="any" name='Prezioa' class='form-control' value="<?php echo $Prezioa; ?>" required></td>
			</tr>
			<tr>
				<td>Gutxieneko Stock-a </td><td><input type='number' name='Stock_Min' class='form-control' value="<?php echo $Stock_Min; ?>"></td>
			</tr>
			<tr>
				<td>Oraingo Stock-a </td><td><input type='number' name='Stock_Now' class='form-control' value="<?php echo $Stock_Now; ?>"></td>
			</tr>
			<tr>
	 
			<tr>
				<td colspan="2">
					<button type="submit" class="btn btn-primary" name="btn-update">
					<span class="glyphicon glyphicon-edit"></span>  Aldatu datuak
					</button>
					<a href="materialak.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
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