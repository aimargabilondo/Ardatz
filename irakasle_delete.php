<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';


if(isset($_POST['btn-del']))
{
	$id = $_GET['delete_id'];
	$irakasleCrud->delete($id);
	header("Location: irakasle_delete.php?deleted");	
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
	 if(isset($_GET['delete_id']))
	 {
		 ?>
         <table class='table table-bordered'>
         <tr>
         <th>N°</th>
         <th>Nome</th>
         <th>Prénom</th>
         <th>E - mail</th>
         <th>Tél</th>
         </tr>
         <?php
         $stmt = $DB_con->prepare("SELECT * FROM tbl_irakasle WHERE id=:id");
         $stmt->execute(array(":id"=>$_GET['delete_id']));
         while($row=$stmt->fetch(PDO::FETCH_BOTH))
         {
             ?>
             <tr>
             <td><?php print($row['id']); ?></td>
             <td><?php print($row['first_name']); ?></td>
             <td><?php print($row['last_name']); ?></td>
             <td><?php print($row['email_id']); ?></td>
         	 <td><?php print($row['contact_no']); ?></td>
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
if(isset($_GET['delete_id']))
{
	?>
  	<form method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
    <button class="btn btn-large btn-primary" type="submit" name="btn-del"><i class="glyphicon glyphicon-trash"></i> &nbsp; Bai</button>
    <a href="irakasle_view.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Ez</a>
    </form>  
	<?php
}
else
{
	?>
    <a href="irakasle_view.php" class="btn btn-large btn-success" style="float: right;><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
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