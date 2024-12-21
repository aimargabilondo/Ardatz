<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';


if(isset($_POST['btn-del']))
{
	$Materiala_ID = $_GET['delete_Materiala_ID'];
	$materialaCrud->delete($Materiala_ID);
	header("Location: materiala_delete.php?deleted");	
}

?>
<?php include_once 'header.php'; ?>

<div class="container">

	<?php
	if(isset($_GET['deleted']))
	{
		?>
        <div class="alert alert-success">
    	Ondo borratu da!
		</div>
        <?php
	}
	else
	{
		?>
        <div class="alert alert-danger">
        ¿Seguro borratu nahi duzula?
		</div>
        <?php
	}
	?>	
</div>

<div class="container">
 	
	 <?php
	 if(isset($_GET['delete_Materiala_ID']))
	 {
		 ?>
         <table class='table table-bordered'>
         <tr>
         <th>N°</th>
         <th>Deskripzioa</th>
         <th>Prezioa</th>
         <th>Gutxieneko Stock-a </th>
         <th>Oraingo Stock-a </th>
         </tr>
         <?php
         $stmt = $DB_con->prepare("SELECT * FROM tbl_materialak WHERE Materiala_ID=:Materiala_ID");
         $stmt->execute(array(":Materiala_ID"=>$_GET['delete_Materiala_ID']));
         while($row=$stmt->fetch(PDO::FETCH_BOTH))
         {
             ?>
             <tr>
             <td><?php print($row['Materiala_ID']); ?></td>
             <td><?php print($row['Deskripzioa']); ?></td>
             <td><?php print($row['Prezioa']); ?></td>
             <td><?php print($row['Stock_Min']); ?></td>
         	 <td><?php print($row['Stock_Now']); ?></td>
             </tr>
             <?php
         }
         ?>
         </table>
         <?php
	 }
	 ?>
</div>

<div class="container">
<p>
<?php
if(isset($_GET['delete_Materiala_ID']))
{
	?>
  	<form method="post">
    <input type="hidden" name="Materiala_ID" value="<?php echo $row['Materiala_ID']; ?>" />
    <button class="btn btn-large btn-primary" type="submit" name="btn-del"><i class="glyphicon glyphicon-trash"></i> &nbsp; Bai</button>
    <a href="materialak.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Ez</a>
    </form>  
	<?php
}
else
{
	?> 
    <a href="materialak.php" class="btn btn-large btn-success" style="float: right;><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
    <?php
}
?>
</p>
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