<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
	
/*	if(isset($_POST['btn-update']))
	{
		$id = $_GET['edit_id'];
		$fname = $_POST['first_name'];
		$lname = $_POST['last_name'];
		$email = $_POST['email_id'];
		$contact = $_POST['contact_no'];
		
		if($egunerokoaCrud->update($id,$fname,$lname,$email,$contact))
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
	}*/

	if(isset($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		extract($egunerokoaCrud->getAllById($id));	
	}
	?>

	<?php include_once 'header.php'; ?>

	<script type="text/javascript">
	$(document).ready(function(){
		
		
		var today = new Date('<?php echo $eguna; ?>');
		var myToday = new Date(today.getFullYear(), today.getMonth(), today.getDate(), today.getHours(), 0, 0);
		
		$('#datetimepicker1').datetimepicker({
			locale: 'es',
			format: 'YYYY-MM-DD HH:mm:ss',
			date: myToday
		}).on('dp.show', function () {
			$('a.btn[data-action="incrementMinutes"], a.btn[data-action="decrementMinutes"]').removeAttr('data-action').attr('disabled', true);
			$('a.btn[data-action="incrementSeconds"], a.btn[data-action="decrementSeconds"]').removeAttr('data-action').attr('disabled', true);
			$('span.timepicker-minute[data-action="showMinutes"]').removeAttr('data-action').attr('disabled', true).text('00');
			$('span.timepicker-second[data-action="showSeconds"]').removeAttr('data-action').attr('disabled', true).text('00');
		}).on('dp.change', function () {
			$(this).val($(this).val().split(':')[0]+':00');
			$('span.timepicker-minute').text('00');
			$(this).val($(this).val().split(':')[0]+':00');
			$('span.timepicker-second').text('00');
		});
		
		$('#gelaselector').on("change", function(){
			var selectedValue = $(this).children("option:selected").val();
			$('#mahaiaselector').empty();
			
			$.post("ajax_search.php?search-mahaiak", {gela: selectedValue
														}).done(function(data){
				// Display the returned data in browser
				$('#mahaiaselector').append(data);
			});
			
		});

		
		$('.ikasle input[type="text"]').on("keyup input", function(){
			/* Get input value on change */
			var inputVal = $(this).val();
			var resultDropdown = $(this).siblings(".result");
			if(inputVal.length){
				$.post("live_search.php?ikasle", {search: inputVal}).done(function(data){
					// Display the returned data in browser
					resultDropdown.html(data);
				});
			} else{
				resultDropdown.empty();
			}
		});
		
		
		$('.ikasgai input[type="text"]').on("keyup input", function(){
			/* Get input value on change */
			var inputVal = $(this).val();
			var resultDropdown = $(this).siblings(".result");
			if(inputVal.length){
				$.post("live_search.php?ikasgai", {search: inputVal}).done(function(data){
					// Display the returned data in browser
					resultDropdown.html(data);
				});
			} else{
				resultDropdown.empty();
			}
		});
		
		// Set search input value on click of result item
		$(document).on("click", ".result p", function(){
			$(this).parents(".search-box").find('input[type="text"]').val($(this).text());
			$(this).parents(".search-box").find('input[type="hidden"]').val($(this).attr("id"));
			$(this).parent(".result").empty();
		});
		
		$(document).on('click', function (e) {
			if ($(e.target).closest(".ikasle, .ikasgai").length == 0) {
				$(".result").empty();
			}
		});
		
		$(document).on("click", ".btn-success", function(e){
				e.preventDefault();
				var idEgunerokoa = $(this).closest("form").attr('id');
				var mahaiValue = $("#mahaiaselector").val();
				var ikasleValue = $(this).parents(".table").find('input[name="ikasle"]').val();
				var ikasleIdValue = $(this).parents(".table").find('input[name="ikasle-id"]').val();
				var ikasgaiValue = $(this).parents(".table").find('input[name="ikasgai"]').val();
				var ikasgaiIdValue = $(this).parents(".table").find('input[name="ikasgai-id"]').val();
				var jarreraPertsonalaValue = $(this).parents(".table").find('select[name="jarrera_pertsonala"]').val();
				var lanerakoJarrera = $(this).parents(".table").find('select[name="lanerako_jarrera"]').val();
				var arreta = $(this).parents(".table").find('select[name="arreta"]').val();
				var oharra = $(this).parents(".table").find('textarea[name="oharra"]').val();
				var date = moment($(this).parents(".table").find('input[name="datetimepicker"]').val()).format('YYYY-MM-DD HH:mm:ss');

			
				$.post('ajax_egunerokoa.php?update_egunerokoa', 
					{
					   id: idEgunerokoa,
					   ikasle: ikasleValue,
					   mahai_id: mahaiValue,
					   ikasle_id: ikasleIdValue,
					   ikasgai: ikasgaiValue,
					   ikasgai_id: ikasgaiIdValue,
					   jarrera_pertsonala_id: jarreraPertsonalaValue,
					   lanerako_jarrera_id: lanerakoJarrera,
					   arreta_id: arreta,
					   oharra: oharra,
					   date:date
					}, 
					function (response) {
						//$('form[name="gela_2_mahai_1"] :input').prop("disabled", true);

						$('form[name="formedit"] :input').prop("disabled", true);
						
					// This is executed when the call to mail.php was succesful.
					// 'data' contains the response from the request
						/*$(this).prop( "disabled", true );
						$(this).parents(".table").find('input[type="text"]').prop( "disabled", true );
						$(this).parents(".table").find(".result").prop( "disabled", true );
						$(this).parents(".table").find('select').prop( "disabled", true );
						$(this).parents(".table").find('textarea').prop( "disabled", true );
						$(this).parents(".table").find('.btn-danger').prop( "disabled", true );
						$(this).prop( "disabled", true );*/
						//$(this).closest('form').find('input[type="text"]').prop( "disabled", true );
						
						//alert('ok');
				}).error(function() {
					// This is executed when the call to mail.php failed.
					alert('error');
				});
				
			});
	});
		
	</script> 


	<div class="container">
	<?php
	if(isset($msg))
	{
		echo $msg;
	}
	?>
	</div>
	<div class="container">
		 <div class="col-md-5">
			<div class="btn btn-block btn-lg btn-mesa" data-toggle="modal" data-target="#mymodal">
			<form method='post' id='<?php echo $id; ?>' name='formedit'>
				<table class='table table-bordered'>
					<tr>
						<td>Ikaslea </td>
						<td>
							<div class="search-box ikasle">
								<input type='text' autocomplete="off" placeholder="Ikaslea..." name='ikasle' value="<?php echo $ikasle_izena; ?>" class='search-input form-control' required>
								<div class="result"></div><input type='hidden' name='ikasle-id' value="<?php echo $ikasle_id; ?>" class='form-control'>
							</div>
						</td>
					</tr>
					<tr>
						<td>Ikasgaia </td>
						<td>
							<div class="search-box ikasgai">
								<input type='text' autocomplete="off" placeholder="Ikasgaia..." name='ikasgai' value="<?php echo $ikasgaia; ?>" class='search-input form-control' required>
								<div class="result"></div><input type='hidden' name='ikasgai-id' value="<?php echo $ikasgai_id; ?>" class='form-control'>
							</div>
						</td>
					</tr>
					<tr>
						<td>Jarrera pertsonala </td>
						<td>
							<select class="form-control" name="jarrera_pertsonala" required>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_jarrera order by id asc");

								while ($Result = $stmt->fetch()) {
									if($Result["id"] == $jarrera_id){
										echo "<option value='" . $Result["id"] . "' selected>" . $Result["name"] . "</option>";
									}else{
										echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
									}
								}
							?>
							</select>
						</td>
					</tr>			
					<tr>
						<td>Lanerako jarrera </td>
						<td>
							<select class="form-control" name="lanerako_jarrera" required>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_efizentzia order by id asc");

								while ($Result = $stmt->fetch()) {
									if($Result["id"] == $efizentzia_id){
										echo "<option value='" . $Result["id"] . "' selected>" . $Result["name"] . "</option>";
									}else{
										echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
									}
									
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Irakaslearen arreta </td>
						<td>
							<select class="form-control" name="arreta" required>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");

								while ($Result = $stmt->fetch()) {
									if($Result["id"] == $irakasle_arreta_id){
										echo "<option value='" . $Result["id"] . "' selected>" . $Result["name"] . "</option>";
									}else{
										echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
									}
									
								}
							?>
							</select>
						</td>
					</tr>				
					<tr>
						<td>Oharra </td>
						<td>
							<textarea class="form-control" style="resize:none" rows="3" name="oharra"><?php echo $oharra; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>Gela </td>
						<td>
							<select class="form-control" id="gelaselector" name="gela" required>
							<?php
								$stmt = $DB_con->query("SELECT gela, gela_name FROM tbl_mahai group by gela, gela_name order by gela asc");

								while ($Result = $stmt->fetch()) {
									if($Result["gela"] == $gela){
										echo "<option value='" . $Result["gela"] . "' selected>" . $Result["gela_name"] . "</option>";
									}else{
										echo "<option value='" . $Result["gela"] . "'>" . $Result["gela_name"] . "</option>";
									}
									
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Mahaia </td>
						<td>
							<select class="form-control" id="mahaiaselector" name="nahaia" required>
							<?php
								$stmt = $DB_con->query("SELECT id, mahaia, mahai_name FROM tbl_mahai where gela = ".$gela." order by id asc");

								while ($Result = $stmt->fetch()) {
									if($Result["id"] == $mahaia_id){
										echo "<option value='" . $Result["mahaia"] . "' selected>" . $Result["mahai_name"] . "</option>";
									}else{
										echo "<option value='" . $Result["mahaia"] . "'>" . $Result["mahai_name"] . "</option>";
									}
									
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Data </td>
						<td>
							<div class='input-group date' id='datetimepicker1'>
								<input type='text' class="form-control" name='datetimepicker'/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan='2'>
							<button type="reset" class="btn btn-danger" name="btn-save" style="float: right;">
							<span class="glyphicon glyphicon-trash"></span> &nbsp; Ezeztatu</button>
							
							<button class="btn btn-large btn-success" style="float: left;">
							<span class="glyphicon glyphicon-plus"></span> &nbsp; Gorde</button>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<a href="egunerokoa_view.php" class="btn btn-lar ge " style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
						</td>
					</tr>
				</table>
			</form>
			</div>
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