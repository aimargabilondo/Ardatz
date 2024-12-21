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
		$email1 = $_POST['email1'];
		$contact_no1 = $_POST['contact_no1'];
		$hours = $_POST['hours'];
		//$active = $_POST['active'];
		if($_POST['active'] == 'on'){
			$active = 1;
		}else{
			$active = 0;
		}
		$ncuenta = $_POST['ncuenta'];
		$ikasmaila = $_POST['ikasmaila'];
		
		$guraso1 = $_POST['guraso1'];
		$guraso2 = $_POST['guraso2'];
		$jaiotze_data = $_POST['jaiotze_data'];
		$helbidea = $_POST['helbidea'];
		$email2 = $_POST['email2'];
		$contact_no2 = $_POST['contact_no2'];
		$dni1 = $_POST['dni1'];
		$dni2 = $_POST['dni2'];
		$tutorea = $_POST['tutorea'];
		$email_tutorea = $_POST['email_tutorea'];
		$ikastetxea = $_POST['ikastetxea'];
		$oharra = $_POST['oharra'];
		
		$msg = '';
		$image = '';
		
		//error_log('Name>'.$_FILES['image']['name'].'<', 3, "./my-errors.log"); 
		
		if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
			// Get image name
			$image = $ikasleCrud->generarCodigo(8).'.'.pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			// image file directory
			$target = "./images/".$image;

			if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
				$msg = "Image uploaded successfully";
			}else{
				$msg = "Failed to upload image";
			}
			
			//error_log($msg, 3, "./my-errors.log"); 
			
			if($ikasleCrud->updateWithImage($id,$fname,$lname,$email1,$contact_no1,$hours,$active,$image,$ncuenta,$ikasmaila,
		$guraso1, $guraso2, $jaiotze_data, $helbidea, $email2, $contact_no2, $dni1, $dni2, $tutorea, $email_tutorea,
		$ikastetxea, $oharra))
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
		}else{
			if($ikasleCrud->update($id,$fname,$lname,$email1,$contact_no1,$hours,$active,$ncuenta,$ikasmaila,
		$guraso1, $guraso2, $jaiotze_data, $helbidea, $email2, $contact_no2, $dni1, $dni2, $tutorea, $email_tutorea,
		$ikastetxea, $oharra))
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
			//error_log("No image uploaded", 3, "./my-errors.log");
		}

	}

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
	
	<script type="text/javascript">

		$(document).ready(function(){
			
			$("#jaiotze_data_div").datepicker({
			   language: 'eu',
			   format: 'yyyy-mm-dd',
			   autoclose: true,
			   todayBtn: 'linked',
			   date: moment(),
			   todayHighlight: true,
			   ignoreReadonly: true
			});
			
		});
	
	</script>
	
	<div class="container">	 
		<form method='post' enctype="multipart/form-data">
		<input type="hidden" name="size" value="1000000">
		<table class='table table-bordered'>
			<tr>
				<td>Aktibo </td><td colspan='2'><input type='checkbox' name='active' <?php echo ($active=='1'?'checked':''); ?> class='form-control'></td>
			</tr>
			<tr>
				<td>Izena</td>
				<td colspan='2'><input type='text' name='first_name' class='form-control' value="<?php echo $first_name; ?>" required></td>
			</tr>
	 
			<tr>
				<td>Abizena</td>
				<td colspan='2'><input type='text' name='last_name' class='form-control' value="<?php echo $last_name; ?>" required></td>
			</tr>
			<tr>
				<td>Jaiotze data </td>
				<td>					
					<div class='input-group date' id='jaiotze_data_div'>
						<input type='text' name='jaiotze_data' class="form-control" placeholder="Jaiotze data..." value="<?php echo $jaiotze_data_formated; ?>" readonly />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Ikasmaila </td>
				<td>
					<select class="form-control" name="ikasmaila" required>
					<?php
						$stmt = $DB_con->query("SELECT id, ikasmaila FROM tbl_tarifak order by id asc");

						while ($Result = $stmt->fetch()) {
							if($Result["id"] == $ikasmaila_id){
								echo "<option selected value='" . $Result["id"] . "'>" . $Result["ikasmaila"] . "</option>";
							}else{
								echo "<option value='" . $Result["id"] . "'>" . $Result["ikasmaila"] . "</option>";
							}
							
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Klase kopurua astero </td><td colspan='2'><input type="number" name="hours" value='<?php echo $hours_per_week; ?>' step='0.5' min="1" max="20" class='form-control'></td>
			</tr>
			<tr>
				<td>Oharra</td>
				<td colspan='2'><input type='text' name='oharra' class='form-control' value="<?php echo $oharra; ?>" ></td>
			</tr>
			<tr>
				<td>Guraso 1</td>
				<td colspan='2'><input type='text' name='guraso1' class='form-control' value="<?php echo $guraso1; ?>" ></td>
			</tr>
			<tr>
				<td>E - mail 1</td>
				<td colspan='2'><input type='text' name='email1' class='form-control' value="<?php echo $email1; ?>" ></td>
			</tr>
			<tr>
				<td>Telefonoa 1</td>
				<td colspan='2'><input type='text' name='contact_no1' class='form-control' value="<?php echo $contact_no1; ?>" ></td>
			</tr>
			<tr>
				<td>DNI 1</td>
				<td colspan='2'><input type='text' name='dni1' class='form-control' value="<?php echo $dni1; ?>" ></td>
			</tr>
			<tr>
				<td>Guraso 2</td>
				<td colspan='2'><input type='text' name='guraso2' class='form-control' value="<?php echo $guraso2; ?>" ></td>
			</tr>
			<tr>
				<td>E - mail 2</td>
				<td colspan='2'><input type='text' name='email2' class='form-control' value="<?php echo $email2; ?>" ></td>
			</tr>
			<tr>
				<td>Telefonoa 2</td>
				<td colspan='2'><input type='text' name='contact_no2' class='form-control' value="<?php echo $contact_no2; ?>" ></td>
			</tr>
			<tr>
				<td>DNI 2</td>
				<td colspan='2'><input type='text' name='dni2' class='form-control' value="<?php echo $dni2; ?>" ></td>
			</tr>
			<tr>
				<td>Helbidea</td>
				<td colspan='2'><input type='text' name='helbidea' class='form-control' value="<?php echo $helbidea; ?>" ></td>
			</tr>
			<tr>
				<td>Argazkia</td>
				<td><img class="img-rounded zoom" src="/ardatz/images/<?php echo $image_name; ?>" width="40" height="40"/></td>
				<td><input type='file' name='image' class='form-control' accept="image/*"></td>
			</tr>
			
			<tr>
				<td>Ikastetxea </td>
				<td>
					<select class="form-control" name="ikastetxea" required>
					<?php
						$stmt = $DB_con->query("SELECT id, izena FROM tbl_ikastetxea order by id asc");

						while ($Result = $stmt->fetch()) {
							if($Result["id"] == $ikastetxea_id){
								echo "<option selected value='" . $Result["id"] . "'>" . $Result["izena"] . "</option>";
							}else{
								echo "<option value='" . $Result["id"] . "'>" . $Result["izena"] . "</option>";
							}
							
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Tutorea</td>
				<td colspan='2'><input type='text' name='tutorea' class='form-control' value="<?php echo $tutorea; ?>" ></td>
			</tr>
			<tr>
				<td>E - mail tutorea</td>
				<td colspan='2'><input type='text' name='email_tutorea' class='form-control' value="<?php echo $email_tutorea; ?>" ></td>
			</tr>
			<tr>
				<td>Kontu korrontea </td><td><input type="text" name="ncuenta" value='<?php echo $ncuenta; ?>' class='form-control' required></td>
			</tr>
			<tr>
				<td colspan="3">
					<button type="submit" class="btn btn-primary" name="btn-update">
					<span class="glyphicon glyphicon-edit"></span>  Aldatu
					</button>
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