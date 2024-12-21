<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';

	if(isset($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		extract($ikasleCrud->getById($id));
	}
	?>

	<?php include_once 'header.php'; ?>
	<link id="bsdp-css" href="bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="bootstrap-datepicker.min.js"></script>
	<script src="bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
	<script src="bootstrap-datepicker.eu.min.js" charset="UTF-8"></script>
	<div class="container">
	<?php
	if(isset($msg))
	{
		echo $msg;
	}
	?>
	</div>
	
	<div class="container">	 
		<form method='post' enctype="multipart/form-data">
		<input readonly type="hidden" name="size" value="1000000">
		<table class='table table-bordered'>
			<tr>
				<td>Aktibo </td><td colspan='2'><input readonly type='checkbox' name='active' checked='<?php $active?'true':'false' ?>' class='form-control'></td>
			</tr>
			<tr>
				<td>Izena</td>
				<td colspan='2'><input readonly type='text' name='first_name' class='form-control' value="<?php echo $first_name; ?>" ></td>
			</tr>
	 
			<tr>
				<td>Abizena</td>
				<td colspan='2'><input readonly type='text' name='last_name' class='form-control' value="<?php echo $last_name; ?>" ></td>
			</tr>
			<tr>
				<td>Jaiotze data </td>
				<td>					
					<input readonly type='text' name='jaiotze_data' class="form-control" placeholder="Jaiotze data..." value="<?php echo $jaiotze_data_formated; ?>" readonly />
				</td>
			</tr>
			<tr>
				<td>Ikasmaila </td>
				<td>
					<select class="form-control" name="ikasmaila" >
					<?php
						$stmt = $DB_con->query("SELECT id, ikasmaila FROM tbl_tarifak order by id asc");

						while ($Result = $stmt->fetch()) {
							if($Result["id"] == $ikasmaila_id){
								echo "<option selected value='" . $Result["id"] . "'>" . $Result["ikasmaila"] . "</option>";
							}else{
								//echo "<option value='" . $Result["id"] . "'>" . $Result["ikasmaila"] . "</option>";
							}
							
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Klase kopurua astero </td><td colspan='2'><input readonly type="number" name="hours" value='<?php echo $hours_per_week; ?>' step='0.5' min="1" max="20" class='form-control'></td>
			</tr>
			<tr>
				<td>Oharra</td>
				<td colspan='2'><input readonly type='text' name='oharra' class='form-control' value="<?php echo $oharra; ?>" ></td>
			</tr>
			<tr>
				<td>Guraso 1</td>
				<td colspan='2'><input readonly type='text' name='guraso1' class='form-control' value="<?php echo $guraso1; ?>" ></td>
			</tr>
			<tr>
				<td>E - mail 1</td>
				<td colspan='2'><input readonly type='text' name='email1' class='form-control' value="<?php echo $email1; ?>" ></td>
			</tr>
			<tr>
				<td>Telefonoa 1</td>
				<td colspan='2'><input readonly type='text' name='contact_no1' class='form-control' value="<?php echo $contact_no1; ?>" ></td>
			</tr>
			<tr>
				<td>DNI 1</td>
				<td colspan='2'><input readonly type='text' name='dni1' class='form-control' value="<?php echo $dni1; ?>" ></td>
			</tr>
			<tr>
				<td>Guraso 2</td>
				<td colspan='2'><input readonly type='text' name='guraso2' class='form-control' value="<?php echo $guraso2; ?>" ></td>
			</tr>
			<tr>
				<td>E - mail 2</td>
				<td colspan='2'><input readonly type='text' name='email2' class='form-control' value="<?php echo $email2; ?>" ></td>
			</tr>
			<tr>
				<td>Telefonoa 2</td>
				<td colspan='2'><input readonly type='text' name='contact_no2' class='form-control' value="<?php echo $contact_no2; ?>" ></td>
			</tr>
			<tr>
				<td>DNI 2</td>
				<td colspan='2'><input readonly type='text' name='dni2' class='form-control' value="<?php echo $dni2; ?>" ></td>
			</tr>
			<tr>
				<td>Helbidea</td>
				<td colspan='2'><input readonly type='text' name='helbidea' class='form-control' value="<?php echo $helbidea; ?>" ></td>
			</tr>
			<tr>
				<td>Argazkia</td>
				<td><img class="img-rounded zoom" src="/ardatz/images/<?php echo $image_name; ?>" width="40" height="40"/></td>
			</tr>
			
			<tr>
				<td>Ikastetxea </td>
				<td>
					<select class="form-control" name="ikastetxea" >
					<?php
						$stmt = $DB_con->query("SELECT id, izena FROM tbl_ikastetxea order by id asc");

						while ($Result = $stmt->fetch()) {
							if($Result["id"] == $ikastetxea_id){
								echo "<option selected value='" . $Result["id"] . "'>" . $Result["izena"] . "</option>";
							}else{
								//echo "<option value='" . $Result["id"] . "'>" . $Result["izena"] . "</option>";
							}
							
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Tutorea</td>
				<td colspan='2'><input readonly type='text' name='tutorea' class='form-control' value="<?php echo $tutorea; ?>" ></td>
			</tr>
			<tr>
				<td>E - mail tutorea</td>
				<td colspan='2'><input readonly type='text' name='email_tutorea' class='form-control' value="<?php echo $email_tutorea; ?>" ></td>
			</tr>
			<tr>
				<td>Kontu korrontea </td><td><input readonly type="text" name="ncuenta" value='<?php echo $ncuenta; ?>' class='form-control' ></td>
			</tr>
			<tr>
				<td colspan="3">
					<a href="ikasle_view.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
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