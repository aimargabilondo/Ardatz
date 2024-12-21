<?php session_start(); ?>


<?php
	if(isset($_SESSION['valid'])) {			
		include_once 'dbconfig.php';
		include_once 'header.php';

		if(isset($_POST['btn-save'])){ 
			$fname = $_POST['first_name'];
			$lname = $_POST['last_name'];
			$email1 = $_POST['email1'];
			$contact_no1 = $_POST['contact_no1'];
			$hours = $_POST['hours'];
			$ncuenta = $_POST['ncuenta'];
			$ikasmaila = $_POST['ikasmaila'];
			//$active = $_POST['active'];
			if($_POST['active'] == 'on'){
				$active = 1;
			}else{
				$active = 0;
			}
			
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
			$image = 'default_ikasle_logo.png';
			if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
				// Get image name
				$image = $ikasleCrud->generarCodigo(8).'.'.pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
				
				// image file directory
				$target = "./images/".$image;

				if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
					if($ikasleCrud->create($fname,$lname,$email1,$contact_no1,$hours,$active,$image,$ncuenta,$ikasmaila,
											$guraso1, $guraso2, $jaiotze_data, $helbidea, $email2, $contact_no2, $dni1, $dni2, $tutorea, $email_tutorea,
											$ikastetxea, $oharra)){
						header("Location: ikasle_add.php?inserted"); 
					}else{                                            
						header("Location: ikasle_add.php?failure&msg=Datu basean gordetzen arazo bat gertatu da.");
					}
				}else{
					header("Location: ikasle_add.php?failure&msg=Arazo bat egon da irudia gordetzen.");
				}
			}else{
				if($ikasleCrud->create($fname,$lname,$email1,$contact_no1,$hours,$active,$image,$ncuenta,$ikasmaila,
										$guraso1, $guraso2, $jaiotze_data, $helbidea, $email2, $contact_no2, $dni1, $dni2, $tutorea, $email_tutorea,
										$ikastetxea, $oharra)){
					header("Location: ikasle_add.php?inserted"); 
				}else{                                            
					header("Location: ikasle_add.php?failure&msg=Datu basean gordetzen arazo bat gertatu da.");
				}
			}
			

		}?>
		<?php
		if(isset($_GET['inserted'])){
			?>
			<div class="container">
			   <div class="alert alert-info">
				Ondo gorde da!
			   </div>
			</div>
			<?php
		}else if(isset($_GET['failure'])){ 
			?>
			<div class="container">
			   <div class="alert alert-warning">
				Ezin izan da gorde! <?php echo $_GET['msg']; ?>
			   </div>
			</div>
			<?php
			}
		?>
	<link id="bsdp-css" href="bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="bootstrap-datepicker.min.js"></script>
	<script src="bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
	<script src="bootstrap-datepicker.eu.min.js" charset="UTF-8"></script>
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
			<form method='post' enctype="multipart/form-data"><!--creation de la form avec la method post-->
			<input type="hidden" name="size" value="1000000">
			<table class='table table-bordered'>
				<tr>
					<td>Aktibo </td><td colspan='2'><input type='checkbox' name='active' checked='true' class='form-control'></td>
				</tr>
				<tr>
					<td>Izena</td>
					<td colspan='2'><input type='text' name='first_name' class='form-control' value="" required></td>
				</tr>
		 
				<tr>
					<td>Abizena</td>
					<td colspan='2'><input type='text' name='last_name' class='form-control' value="" required></td>
				</tr>
				<tr>
					<td>Jaiotze data </td>
					<td>					
						<div class='input-group date' id='jaiotze_data_div'>
							<input type='text' name='jaiotze_data' class="form-control" placeholder="Jaiotze data..." value="" readonly />
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
								echo "<option value='" . $Result["id"] . "'>" . $Result["ikasmaila"] . "</option>";
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Klase kopurua astero </td><td colspan='2'><input type="number" name="hours" value='' step='0.5' min="1" max="20" class='form-control'></td>
				</tr>
				<tr>
					<td>Oharra</td>
					<td colspan='2'><input type='text' name='oharra' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>Guraso 1</td>
					<td colspan='2'><input type='text' name='guraso1' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>E - mail 1</td>
					<td colspan='2'><input type='text' name='email1' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>Telefonoa 1</td>
					<td colspan='2'><input type='text' name='contact_no1' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>DNI 1</td>
					<td colspan='2'><input type='text' name='dni1' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>Guraso 2</td>
					<td colspan='2'><input type='text' name='guraso2' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>E - mail 2</td>
					<td colspan='2'><input type='text' name='email2' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>Telefonoa 2</td>
					<td colspan='2'><input type='text' name='contact_no2' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>DNI 2</td>
					<td colspan='2'><input type='text' name='dni2' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>Helbidea</td>
					<td colspan='2'><input type='text' name='helbidea' class='form-control' value="" ></td>
				</tr>
				<tr>
					<td>Argazkia</td>
					<td><img class="img-rounded zoom" src="/ardatz/images/default_ikasle_logo.png" width="40" height="40"/></td>
					<td><input type='file' name='image' class='form-control' accept="image/*"></td>
				</tr>
				
				<tr>
					<td>Ikastetxea </td>
					<td>
						<select class="form-control" name="ikastetxea" required>
						<?php
							$stmt = $DB_con->query("SELECT id, izena FROM tbl_ikastetxea order by id asc");

							while ($Result = $stmt->fetch()) {
								echo "<option value='" . $Result["id"] . "'>" . $Result["izena"] . "</option>";	
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Tutorea</td>
					<td colspan='2'><input type='text' name='tutorea' class='form-control' ></td>
				</tr>
				<tr>
					<td>E - mail tutorea</td>
					<td colspan='2'><input type='text' name='email_tutorea' class='form-control' ></td>
				</tr>
				<tr>
					<td>Kontu korrontea </td><td colspan='2'><input type="text" name="ncuenta" value='' class='form-control' required></td>
				</tr>
				<tr>
					<td colspan="3">
					<!--btn-save : button de confirmation-->
					<button type="submit" class="btn btn-primary" name="btn-save">
					<span class="glyphicon glyphicon-plus"></span> Gorde</button>
					<!--lien de retour vers l'index-->  
					<a href="ikasle_view.php" class="btn btn-large btn-success" style="float: right;">
					<i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
					</td>
				</tr>
			</table><!--fin du tableau-->
		</form><!--fin de form-->
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