<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
	include_once 'session_restart.php';
?>
	
<script type="text/javascript">
$(document).ready(function(){
	
	var DEFAULT_IKASGAI = '<?php echo $defaultsCrud->getValueByGelaAndParamName(3, 'IKASGAI'); ?>';
	var DEFAULT_IKASGAI_ID = '<?php echo $defaultsCrud->getValueByGelaAndParamName(3, 'IKASGAI-ID'); ?>';
	var DEFAULT_JARRERA_PERTSONALA = '<?php echo $defaultsCrud->getValueByGelaAndParamName(3, 'JARRERA_PERTSONALA'); ?>';
	var DEFAULT_LANERAKO_JARRERA = '<?php echo $defaultsCrud->getValueByGelaAndParamName(3, 'LANERAKO_JARRERA'); ?>';
	var DEFAULT_ARRETA = '<?php echo $defaultsCrud->getValueByGelaAndParamName(3, 'ARRETA'); ?>';
	
	var today = new Date();
	var myToday = new Date(today.getFullYear(), today.getMonth(), today.getDate(), today.getHours()-1, 0, 0);
	
	$('#datetimepicker0').datetimepicker({
		locale: 'es',
		format: 'YYYY-MM-DD HH:mm:ss',
		date: myToday,
		ignoreReadonly: true
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
	
	$('#datetimepicker1').datetimepicker({
		locale: 'es',
		format: 'YYYY-MM-DD HH:mm:ss',
		date: myToday,
		ignoreReadonly: true
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


	$('#datetimepicker2').datetimepicker({
		locale: 'es',
		format: 'YYYY-MM-DD HH:mm:ss',
		date: myToday,
		ignoreReadonly: true
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
	
	$('#datetimepicker3').datetimepicker({
		locale: 'es',
		format: 'YYYY-MM-DD HH:mm:ss',
		date: myToday,
		ignoreReadonly: true
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
	
	$('#datetimepicker4').datetimepicker({
		locale: 'es',
		format: 'YYYY-MM-DD HH:mm:ss',
		date: myToday,
		ignoreReadonly: true
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
	
	$('#datetimepicker5').datetimepicker({
		locale: 'es',
		format: 'YYYY-MM-DD HH:mm:ss',
		date: myToday,
		ignoreReadonly: true
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
	
	$('#datetimepicker6').datetimepicker({
		locale: 'es',
		format: 'YYYY-MM-DD HH:mm:ss',
		date: myToday,
		ignoreReadonly: true
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
	
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
		  event.preventDefault();
		  return false;
		}
	});
	
	
	
    $('.ikasle input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.post("ajax_search.php?ikasle", {search: inputVal}).done(function(data){
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
            $.post("ajax_search.php?ikasgai", {search: inputVal}).done(function(data){
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
		if($(this).parents(".search-box").find('input[type="text"]').attr('name') != null && $(this).parents(".search-box").find('input[type="text"]').attr('name').includes('-all')){
			if($('input[name="ikasgai-id-all"]').val() == '99'){
				$('select[name="jarrera_pertsonala-all"]').val('99');
				$('select[name="lanerako_jarrera-all"]').val('99');
				$('select[name="arreta-all"]').val('99');
				$('select[name="jarrera_pertsonala-all"]').prop('disabled', 'disabled');
				$('select[name="lanerako_jarrera-all"]').prop('disabled', 'disabled');
				$('select[name="arreta-all"]').prop('disabled', 'disabled');
			}else{
				if($('select[name="jarrera_pertsonala-all"]').val() == '99'){
					$('select[name="jarrera_pertsonala-all"]').val(DEFAULT_JARRERA_PERTSONALA);
				}
				if($('select[name="lanerako_jarrera-all"]').val() == '99'){
					$('select[name="lanerako_jarrera-all"]').val(DEFAULT_LANERAKO_JARRERA);
				}
				if($('select[name="arreta-all"]').val() == '99'){
					$('select[name="arreta-all"]').val(DEFAULT_ARRETA);
				}
				$('select[name="jarrera_pertsonala-all"]').prop('disabled', false);
				$('select[name="lanerako_jarrera-all"]').prop('disabled', false);
				$('select[name="arreta-all"]').prop('disabled', false);
			}
		}else{
			if($(this).parents(".table").find('input[name="ikasgai-id"]').val() == '99'){
				$(this).parents(".table").find('select[name="jarrera_pertsonala"]').val('99');
				$(this).parents(".table").find('select[name="lanerako_jarrera"]').val('99');
				$(this).parents(".table").find('select[name="arreta"]').val('99');
				$(this).parents(".table").find('select[name="jarrera_pertsonala"]').prop('disabled', 'disabled');
				$(this).parents(".table").find('select[name="lanerako_jarrera"]').prop('disabled', 'disabled');
				$(this).parents(".table").find('select[name="arreta"]').prop('disabled', 'disabled');
			}else{
				if($(this).parents(".table").find('select[name="jarrera_pertsonala"]').val() == '99'){
					$(this).parents(".table").find('select[name="jarrera_pertsonala"]').val(DEFAULT_JARRERA_PERTSONALA);
				}
				if($(this).parents(".table").find('select[name="lanerako_jarrera"]').val() == '99'){
					$(this).parents(".table").find('select[name="lanerako_jarrera"]').val(DEFAULT_LANERAKO_JARRERA);
				}
				if($(this).parents(".table").find('select[name="arreta"]').val() == '99'){
					$(this).parents(".table").find('select[name="arreta"]').val(DEFAULT_ARRETA);
				}
				$(this).parents(".table").find('select[name="jarrera_pertsonala"]').prop('disabled', false);
				$(this).parents(".table").find('select[name="lanerako_jarrera"]').prop('disabled', false);
				$(this).parents(".table").find('select[name="arreta"]').prop('disabled', false);
			}
		}
        $(this).parent(".result").empty();
    });
	
	$(document).on('click', function (e) {
		if ($(e.target).closest(".ikasle, .ikasgai").length == 0) {
			$(".result").empty();
		}
	});
	
	$(document).on("click", "button[name='btn-copy']", function(e){
		e.preventDefault();
		$('input[name="ikasgai"]').val($('input[name="ikasgai-all"]').val());
		$('input[name="ikasgai-id"]').val($('input[name="ikasgai-id-all"]').val());
		$('select[name="jarrera_pertsonala"]').val($('select[name="jarrera_pertsonala-all"]').val());
		$('select[name="lanerako_jarrera"]').val($('select[name="lanerako_jarrera-all"]').val());
		$('select[name="arreta"]').val($('select[name="arreta-all"]').val());
		$('input[name="datetimepicker"]').val($('input[name="datetimepicker-all"]').val());
		$('textarea[name="oharra"]').val($('textarea[name="oharra-all"]').val());
		$('select[name="jarrera_pertsonala"]').prop('disabled', $('select[name="jarrera_pertsonala-all"]').prop('disabled'));
		$('select[name="lanerako_jarrera"]').prop('disabled', $('select[name="lanerako_jarrera-all"]').prop('disabled'));
		$('select[name="arreta"]').prop('disabled', $('select[name="arreta-all"]').prop('disabled'));
																							   
	});
	
	$(document).on("click", ".btn-success", function(e){
			e.preventDefault();
			var formularioName = $(this).closest("form").attr('name');
			var mahaiValue = $(this).closest("form").attr('id');
			var ikasleValue = $(this).parents(".table").find('input[name="ikasle"]').val();
			var ikasleIdValue = $(this).parents(".table").find('input[name="ikasle-id"]').val();
			var ikasgaiValue = $(this).parents(".table").find('input[name="ikasgai"]').val();
			var ikasgaiIdValue = $(this).parents(".table").find('input[name="ikasgai-id"]').val();
			var jarreraPertsonalaValue = $(this).parents(".table").find('select[name="jarrera_pertsonala"]').val();
			var lanerakoJarrera = $(this).parents(".table").find('select[name="lanerako_jarrera"]').val();
			var arreta = $(this).parents(".table").find('select[name="arreta"]').val();
			var oharra = $(this).parents(".table").find('textarea[name="oharra"]').val();
			var date = moment($(this).parents(".table").find('input[name="datetimepicker"]').val()).format('YYYY-MM-DD HH:mm:ss');
		
			var alertText = '';
			if(ikasleValue =='' || ikasleIdValue == ''){
				alertText += '<li>Ikasle datua falta da!</li>';
			}
			if(ikasgaiValue == '' &&  ikasgaiIdValue == ''){
				alertText += '<li>Ikasgai datua falta da!</li>';
			}
			if(jarreraPertsonalaValue == null){
				alertText += '<li>Jarrera pertsonaleko datua falta da!</li>';
			}
			if(lanerakoJarrera == null){
				alertText += '<li>Lanerako jarrera datua falta da!</li>';
			}
			if(arreta == null){
				alertText += '<li>Arreta datua falta da!</li>';
			}
			if(date == ''){
				alertText += '<li>Eguna/hordua falta da!</li>';
			}
			if(alertText != ''){
				//alert(alertText);
				alertText = '<ul>' + alertText + '</ul>'
				$('#ErrorModalBody').html(alertText);
				$('#ErrorModal').modal('show');
				return;
			}
		
			$.post('ajax_egunerokoa.php?save_egunerokoa', 
				{
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
					if(response.includes('SQLSTATE')){
						alert('Error: ' + response);
					}else{
						$('form[name="' + formularioName + '"] :input').prop("disabled", true);
						var div = $('form[name="' + formularioName + '"] :input').closest(".btn-mesa");
						div.css("background-color","#000000");
					}
			}).error(function() {
				alert('Can´t connect to the server!');
			});
			
		});
		
	$('input[name="ikasgai-all"]').val(DEFAULT_IKASGAI);
	$('input[name="ikasgai-id-all"]').val(DEFAULT_IKASGAI_ID);
	$('select[name="jarrera_pertsonala-all"]').val(DEFAULT_JARRERA_PERTSONALA);
	$('select[name="lanerako_jarrera-all"]').val(DEFAULT_LANERAKO_JARRERA);
	$('select[name="arreta-all"]').val(DEFAULT_ARRETA);
});
	
$(function(){
  var $jittery = $('.jittery'),
      aText    = $jittery.text().split(''),
      letters = '';
  
  for(var i = 0; i < aText.length; i++){
    letters += '<span>'+aText[i]+'</span>';
  }
  
  $jittery.empty().append(letters);
  
  $.each($('span', $jittery), function(i){
    $(this).css('animation-delay', '-'+i+'70ms');
  });
  
  var $jittery1 = $('.jittery1'),
      aText1    = $jittery1.text().split(''),
      letters1 = '';
  
  for(var i = 0; i < aText1.length; i++){
    letters1 += '<span>'+aText1[i]+'</span>';
  }
  
  $jittery1.empty().append(letters1);
  
  $.each($('span', $jittery1), function(i){
    $(this).css('animation-delay', '-'+i+'70ms');
  });
});
</script> 

<!-- Modal Jarrera -->
<div class="modal fade" id="JarreraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Errubrika: Jarrera Pertsonala</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  	<table class="table table-striped">
          <thead>
            <tr>
              <th width='100'>Maila</th>
              <th>Irizpideak</th>
              <th>Adierazleak</th>
            </tr>
<?php
$stmt = $DB_con->prepare('SELECT name, irizpideak, adierazleak FROM tbl_jarrera'); // préparation de la requete 
$stmt->execute(); 	
if($stmt->rowCount() > 0)  
{
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
	{
?>
			<tr>
              <td width='100'><?php echo $row['name']; ?></td>
              <td><?php echo $row['irizpideak']; ?></td>
              <td><?php echo $row['adierazleak']; ?></td>
            </tr>
			
<?php
	}
}
?>
          </thead>
        </table>

	   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Efizientzia -->
<div class="modal fade" id="EfizientziaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Errubrika: Lanerako Efizientzia</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  	<table class="table table-striped">
          <thead>
            <tr>
              <th width='100'>Maila</th>
              <th>Irizpideak</th>
              <th>Adierazleak</th>
            </tr>
<?php
$stmt = $DB_con->prepare('SELECT name, irizpideak, adierazleak FROM tbl_efizentzia'); // préparation de la requete 
$stmt->execute(); 	
if($stmt->rowCount() > 0)  
{
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
	{
?>
			<tr>
              <td width='100'><?php echo $row['name']; ?></td>
              <td><?php echo $row['irizpideak']; ?></td>
              <td><?php echo $row['adierazleak']; ?></td>
            </tr>
			
<?php
	}
}
?>
          </thead>
        </table>

	   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Arreta -->
<div class="modal fade" id="ArretaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Errubrika: Irakaslearen Arreta</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  	<table class="table table-striped">
          <thead>
            <tr>
              <th width='100'>Maila</th>
              <th>Irizpideak</th>
              <th>Adierazleak</th>
            </tr>
<?php
$stmt = $DB_con->prepare('SELECT name, irizpideak, adierazleak FROM tbl_irakasle_arreta'); // préparation de la requete 
$stmt->execute(); 	
if($stmt->rowCount() > 0)  
{
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
	{
?>
			<tr>
              <td width='100'><?php echo $row['name']; ?></td>
              <td><?php echo $row['irizpideak']; ?></td>
              <td><?php echo $row['adierazleak']; ?></td>
            </tr>
			
<?php
	}
}
?>
          </thead>
        </table>

	   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="ErrorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Kontuz!</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="ErrorModalBody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="content">
<div class="container">
	<div class="center">
		<span class="jittery titulo-clase">3.</span>
		<span class="jittery1 titulo-clase">GELA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	</div>
</div>
<table>
	<tr>
		<td>
			<div class="search-box ikasgai">
				<input type='text' autocomplete="off" placeholder="Ikasgaia..." name='ikasgai-all' class='search-input form-control' required>
				<div class="result"></div><input type='hidden' name='ikasgai-id-all' class='form-control'>
			</div>
		</td>
		<td>
			<div class='input-group' >
				<select class="form-control" name="jarrera_pertsonala-all" required>
					<option value="" disabled selected hidden>--Jarrera pertsonala--</option>
				<?php
					$stmt = $DB_con->query("SELECT id, name FROM tbl_jarrera order by id asc");

					while ($Result = $stmt->fetch()) {
						echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
					}
				?>
				</select>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#JarreraModal"></span>
				</span>
			</div>
		</td>
		<td>
			<div class='input-group' >
				<select class="form-control" name="lanerako_jarrera-all" required>
					<option value="" disabled selected hidden>--Lanerako jarrera--</option>
				<?php
					$stmt = $DB_con->query("SELECT id, name FROM tbl_efizentzia order by id asc");

					while ($Result = $stmt->fetch()) {
						echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
					}
				?>
				</select>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#EfizientziaModal"></span>
				</span>
			</div>
		</td>
		<td>
			<div class='input-group' >
				<select class="form-control" name="arreta-all" required>
					<option value="" disabled selected hidden>--Irakaslearen arreta--</option>
				<?php
					$stmt = $DB_con->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");

					while ($Result = $stmt->fetch()) {
						echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
					}
				?>
				</select>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#ArretaModal"></span>
				</span>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<div class='input-group date' id='datetimepicker0'>
				<input type='text' name='datetimepicker-all' readonly class="form-control" />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-time"></span>
				</span>
			</div>
		</td>
		<td colspan='1'>
			<textarea class="form-control" style="resize:none" rows="2" name="oharra-all"  placeholder="Oharra..."></textarea>
		</td>
		<td colspan='2'>
			<button class="btn btn-danger" name="btn-copy" style="float: right;">
			<span class="glyphicon glyphicon-send"></span> &nbsp; Kopiatu</button>
		</td>
	</tr>
</table>
</br>
<div class="container">

     <div class="col-md-4">
        <div class="btn btn-block btn-lg btn-mesa" data-toggle="modal" data-target="#mymodal">
		<form method='post' id='31' name='gela_3_mahai_1'>
			<table class='table table-bordered'>
				<tr>
					<td>
						<div class="search-box ikasle">
							<input type='text' autocomplete="off" placeholder="Ikaslea..." name='ikasle' class='search-input form-control' required>
							<div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="search-box ikasgai">
							<input type='text' autocomplete="off" placeholder="Ikasgaia..." name='ikasgai' class='search-input form-control' required>
							<div class="result"></div><input type='hidden' name='ikasgai-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="jarrera_pertsonala" required>
								<option value="" disabled selected hidden>--Jarrera pertsonala--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_jarrera order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#JarreraModal"></span>
							</span>
						</div>
					</td>
				</tr>			
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="lanerako_jarrera" required>
								<option value="" disabled selected hidden>--Lanerako jarrera--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_efizentzia order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#EfizientziaModal"></span>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="arreta" required>
								<option value="" disabled selected hidden>--Irakaslearen arreta--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#ArretaModal"></span>
							</span>
						</div>
					</td>
				</tr>				
				<tr>
					<td>
						<textarea class="form-control" style="resize:none" rows="3" name="oharra"></textarea>
					</td>
				</tr>
				<tr>
						<td>
							<div class='input-group date' id='datetimepicker1'>
								<input type='text' name='datetimepicker' readonly class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</td>
				</tr>
        <tr>
            <td>
				<button type="reset" class="btn btn-danger" name="btn-save" style="float: right;">
				<span class="glyphicon glyphicon-trash"></span> &nbsp; Ezeztatu</button>
				
				<button class="btn btn-large btn-success" style="float: left;">
				<span class="glyphicon glyphicon-plus"></span> &nbsp; Gorde</button>
            </td>
        </tr>
			</table>
		</form>
        </div>
	 </div>
	 <div class="col-md-1"></div>
<div class="col-md-4">
        <div class="btn btn-block btn-lg btn-mesa" data-toggle="modal" data-target="#mymodal">
		<form method='post' id='32' name='gela_3_mahai_2'>
			<table class='table table-bordered'>
				<tr>
					<td>
						<div class="search-box ikasle">
							<input type='text' autocomplete="off" placeholder="Ikaslea..." name='ikasle' class='search-input form-control' required>
							<div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="search-box ikasgai">
							<input type='text' autocomplete="off" placeholder="Ikasgaia..." name='ikasgai' class='search-input form-control' required>
							<div class="result"></div><input type='hidden' name='ikasgai-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="jarrera_pertsonala" required>
								<option value="" disabled selected hidden>--Jarrera pertsonala--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_jarrera order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#JarreraModal"></span>
							</span>
						</div>
					</td>
				</tr>			
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="lanerako_jarrera" required>
								<option value="" disabled selected hidden>--Lanerako jarrera--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_efizentzia order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#EfizientziaModal"></span>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="arreta" required>
								<option value="" disabled selected hidden>--Irakaslearen arreta--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#ArretaModal"></span>
							</span>
						</div>
					</td>
				</tr>				
				<tr>
					<td>
						<textarea class="form-control" style="resize:none" rows="3" name="oharra"></textarea>
					</td>
				</tr>
				<tr>
						<td>
							<div class='input-group date' id='datetimepicker2'>
								<input type='text' name='datetimepicker' readonly class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</td>
				</tr>
        <tr>
            <td>
				<button type="reset" class="btn btn-danger" name="btn-save" style="float: right;">
				<span class="glyphicon glyphicon-trash"></span> &nbsp; Ezeztatu</button>
				
				<button class="btn btn-large btn-success" style="float: left;">
				<span class="glyphicon glyphicon-plus"></span> &nbsp; Gorde</button>
            </td>
        </tr>
			</table>
		</form>
        </div>
	 </div>
</div>
</br>
<div class="container">
     
     <div class="col-md-4">
        <div class="btn btn-block btn-lg btn-mesa" data-toggle="modal" data-target="#mymodal">
		<form method='post' id='33' name='gela_3_mahai_3'>
			<table class='table table-bordered'>
				<tr>
					<td>
						<div class="search-box ikasle">
							<input type='text' autocomplete="off" placeholder="Ikaslea..." name='ikasle' class='search-input form-control' required>
							<div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="search-box ikasgai">
							<input type='text' autocomplete="off" placeholder="Ikasgaia..." name='ikasgai' class='search-input form-control'required>
							<div class="result"></div><input type='hidden' name='ikasgai-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="jarrera_pertsonala" required>
								<option value="" disabled selected hidden>--Jarrera pertsonala--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_jarrera order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#JarreraModal"></span>
							</span>
						</div>
					</td>
				</tr>			
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="lanerako_jarrera" required>
								<option value="" disabled selected hidden>--Lanerako jarrera--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_efizentzia order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#EfizientziaModal"></span>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="arreta" required>
								<option value="" disabled selected hidden>--Irakaslearen arreta--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#ArretaModal"></span>
							</span>
						</div>
					</td>
				</tr>				
				<tr>
					<td>
						<textarea class="form-control" style="resize:none" rows="3" name="oharra"></textarea>
					</td>
				</tr>
				<tr>
						<td>
							<div class='input-group date' id='datetimepicker3'>
								<input type='text' name='datetimepicker' readonly class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</td>
				</tr>
        <tr>
            <td>
				<button type="reset" class="btn btn-danger" name="btn-save" style="float: right;">
				<span class="glyphicon glyphicon-trash"></span> &nbsp; Ezeztatu</button>
				
				<button class="btn btn-large btn-success" style="float: left;">
				<span class="glyphicon glyphicon-plus"></span> &nbsp; Gorde</button>
            </td>
        </tr>
			</table>
		</form>
        </div>
	 </div>
	 <div class="col-md-1"></div>
<div class="col-md-4">
        <div class="btn btn-block btn-lg btn-mesa" data-toggle="modal" data-target="#mymodal">
		<form method='post' id='34' name='gela_3_mahai_4'>
			<table class='table table-bordered'>
				<tr>
					<td>
						<div class="search-box ikasle">
							<input type='text' autocomplete="off" placeholder="Ikaslea..." name='ikasle' class='search-input form-control'>
							<div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="search-box ikasgai">
							<input type='text' autocomplete="off" placeholder="Ikasgaia..." name='ikasgai' class='search-input form-control'>
							<div class="result"></div><input type='hidden' name='ikasgai-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="jarrera_pertsonala" required>
								<option value="" disabled selected hidden>--Jarrera pertsonala--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_jarrera order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#JarreraModal"></span>
							</span>
						</div>
					</td>
				</tr>			
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="lanerako_jarrera" required>
								<option value="" disabled selected hidden>--Lanerako jarrera--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_efizentzia order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#EfizientziaModal"></span>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="arreta" required>
								<option value="" disabled selected hidden>--Irakaslearen arreta--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#ArretaModal"></span>
							</span>
						</div>
					</td>
				</tr>				
				<tr>
					<td>
						<textarea class="form-control" style="resize:none" rows="3" name="oharra"></textarea>
					</td>
				</tr>
				<tr>
						<td>
							<div class='input-group date' id='datetimepicker4'>
								<input type='text' name='datetimepicker' readonly class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</td>
				</tr>
        <tr>
            <td>
				<button type="reset" class="btn btn-danger" name="btn-save" style="float: right;">
				<span class="glyphicon glyphicon-trash"></span> &nbsp; Ezeztatu</button>
				
				<button class="btn btn-large btn-success" style="float: left;">
				<span class="glyphicon glyphicon-plus"></span> &nbsp; Gorde</button>
            </td>
        </tr>
			</table>
		</form>
        </div>
	 </div>
</div>
</br>
<div class="container">
     
     <div class="col-md-4">
        <div class="btn btn-block btn-lg btn-mesa" data-toggle="modal" data-target="#mymodal">
		<form method='post' id='35' name='gela_3_mahai_5'>
			<table class='table table-bordered'>
				<tr>
					<td>
						<div class="search-box ikasle">
							<input type='text' autocomplete="off" placeholder="Ikaslea..." name='ikasle' class='search-input form-control'>
							<div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="search-box ikasgai">
							<input type='text' autocomplete="off" placeholder="Ikasgaia..." name='ikasgai' class='search-input form-control'>
							<div class="result"></div><input type='hidden' name='ikasgai-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="jarrera_pertsonala" required>
								<option value="" disabled selected hidden>--Jarrera pertsonala--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_jarrera order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#JarreraModal"></span>
							</span>
						</div>
					</td>
				</tr>			
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="lanerako_jarrera" required>
								<option value="" disabled selected hidden>--Lanerako jarrera--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_efizentzia order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#EfizientziaModal"></span>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="arreta" required>
								<option value="" disabled selected hidden>--Irakaslearen arreta--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#ArretaModal"></span>
							</span>
						</div>
					</td>
				</tr>	
				<tr>
					<td>
						<textarea class="form-control" style="resize:none" rows="3" name="oharra"></textarea>
					</td>
				</tr>
				<tr>
						<td>
							<div class='input-group date' id='datetimepicker5'>
								<input type='text' name='datetimepicker' readonly class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</td>
				</tr>
        <tr>
            <td>
				<button type="reset" class="btn btn-danger" name="btn-save" style="float: right;">
				<span class="glyphicon glyphicon-trash"></span> &nbsp; Ezeztatu</button>
				
				<button class="btn btn-large btn-success" style="float: left;">
				<span class="glyphicon glyphicon-plus"></span> &nbsp; Gorde</button>
            </td>
        </tr>
			</table>
		</form>
        </div>
	 </div>
<div class="col-md-1"></div>
	 <div class="col-md-4">
        <div class="btn btn-block btn-lg btn-mesa" data-toggle="modal" data-target="#mymodal">
		<form method='post' id='36' name='gela_3_mahai_6'>
			<table class='table table-bordered'>
				<tr>
					<td>
						<div class="search-box ikasle">
							<input type='text' autocomplete="off" placeholder="Ikaslea..." name='ikasle' class='search-input form-control'>
							<div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="search-box ikasgai">
							<input type='text' autocomplete="off" placeholder="Ikasgaia..." name='ikasgai' class='search-input form-control'>
							<div class="result"></div><input type='hidden' name='ikasgai-id' class='form-control'>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="jarrera_pertsonala" required>
								<option value="" disabled selected hidden>--Jarrera pertsonala--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_jarrera order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#JarreraModal"></span>
							</span>
						</div>
					</td>
				</tr>			
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="lanerako_jarrera" required>
								<option value="" disabled selected hidden>--Lanerako jarrera--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_efizentzia order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#EfizientziaModal"></span>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class='input-group' >
							<select class="form-control" name="arreta" required>
								<option value="" disabled selected hidden>--Irakaslearen arreta--</option>
							<?php
								$stmt = $DB_con->query("SELECT id, name FROM tbl_irakasle_arreta order by id asc");

								while ($Result = $stmt->fetch()) {
									echo "<option value='" . $Result["id"] . "'>" . $Result["name"] . "</option>";
								}
							?>
							</select>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#ArretaModal"></span>
							</span>
						</div>
					</td>
				</tr>			
				<tr>
					<td>
						<textarea class="form-control" style="resize:none" rows="3" name="oharra"></textarea>
					</td>
				</tr>
				<tr>
						<td>
							<div class='input-group date' id='datetimepicker6'>
								<input type='text' name='datetimepicker' readonly class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</td>
				</tr>
        <tr>
            <td>
				<button type="reset" class="btn btn-danger" name="btn-save" style="float: right;">
				<span class="glyphicon glyphicon-trash"></span> &nbsp; Ezeztatu</button>
				
				<button class="btn btn-large btn-success" style="float: left;">
				<span class="glyphicon glyphicon-plus"></span> &nbsp; Gorde</button>
            </td>
        </tr>
			</table>
		</form>
        </div>
	 </div>
</div>
</br>
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
