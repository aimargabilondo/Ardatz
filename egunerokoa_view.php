<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>


<script src="moment.min.js"></script>
<link id="bsdp-css" href="bootstrap-datepicker3.min.css" rel="stylesheet">
<script src="bootstrap-datepicker.min.js"></script>
<script src="bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
<script src="bootstrap-datepicker.eu.min.js" charset="UTF-8"></script>


<script type="text/javascript">

$(document).ready(function(){

	$('.search-box input[name="ikasle"]').on("keyup input", function(){
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
	
	$('.search-box input[name="irakasle"]').on("keyup input", function(){
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.post("ajax_search.php?irakasle", {search: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
	
	$('.search-box input[name="ikasgai"]').on("keyup input", function(){
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
	
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
		  event.preventDefault();
		  return false;
		}
	});
	
	// Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
		$(this).parents(".search-box").find('input[type="hidden"]').val($(this).attr("id"));
        $(this).parent(".result").empty();
    });
	
	/*$(document).on('click', function (e) {
		if ($(e.target).closest(".ikasle, .ikasgai").length == 0) {
			$(".result").empty();
		}
	});*/
	
	
	$("#startDate").datepicker({
	   language: 'eu',
	   format: 'yyyy-mm-dd',
	   autoclose: true,
	   todayBtn: 'linked',
	   date: moment(),
	   todayHighlight: true
    }).on('changeDate', function(e) {
        var minDate = new Date(e.date.valueOf());
        $('#endDate').datepicker('setStartDate', minDate);
		$('#endDate').datepicker('setDate', minDate);
    });

    $("#endDate").datepicker({
		language: 'eu',
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: 'linked',
		date: moment(),
		todayHighlight: true
	}).on('changeDate', function(e) {
        // do something
    });
	
	
	$(document).on("click", "button[name='clean']", function(e){
		$("#startDate").datepicker('update','');
		$("#endDate").datepicker('update','');
		$('.search-box input[name="ikasle"]').val('');
		$('.search-box input[name="ikasle-id"]').val('');
		$('.search-box input[name="irakasle"]').val('');
		$('.search-box input[name="irakasle-id"]').val('');
		$('.search-box input[name="ikasgai"]').val('');
		$('.search-box input[name="ikasgai-id"]').val('');
		$('button[name="search"]').click();
	});
	
	
	$(document).on("click", "button[name='search']", function(e){
		
		var startDate = '';
		var endDate = '';
		if($("#startDate").datepicker('getDate') != null){
			startDate = moment($("#startDate").datepicker('getDate')).format('YYYY-MM-DD');
		}
		
		if($("#endDate").datepicker('getDate') != null){
			endDate = moment($("#endDate").datepicker('getDate')).add(1, 'days').format('YYYY-MM-DD');
		}
		
		var ikasleId = $('.search-box input[name="ikasle-id"]').val();
		var irakasleId = $('.search-box input[name="irakasle-id"]').val();
		var ikasgaiId = $('.search-box input[name="ikasgai-id"]').val();
		var resultTable = document.getElementById("values_table");
		$.post("ajax_search.php?search-egunerokoa", {
													 ikasle_id: ikasleId,
													 irakasle_id: irakasleId,
													 ikasgai_id: ikasgaiId,
													 start_date: startDate,
													 end_date: endDate
													}).done(function(data){
			// Display the returned data in browser
			resultTable.innerHTML = data;
		});
		
	});
});

</script>
<br />
<div class="container"> 
    <div class="search-box">
        <input type="text" name="ikasle" autocomplete="off" placeholder="Ikaslea..." />
        <div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
    </div>
	
	<div class="search-box">
        <input type="text" name="irakasle" autocomplete="off" placeholder="Irakaslea..." />
        <div class="result"></div><input type='hidden' name='irakasle-id' class='form-control'>
    </div>
	
	<div class="search-box">
        <input type="text" name="ikasgai" autocomplete="off" placeholder="Ikasgaia..." />
        <div class="result"></div><input type='hidden' name='ikasgai-id' class='form-control'>
    </div>
	<div class="search-box">
		<div class='input-group date' id='startDate' style="width: 180px;">
			<input type='text' class="form-control" placeholder="Hasiera data..." readonly />
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
	

		<div class='input-group date' id='endDate' style="width: 180px;">
			<input type='text' class="form-control" placeholder="Bukaera data..." readonly />
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<div style="display:inline-block;">
			<button name="search" class="btn btn-default" onclick="">Bilatu</button>
			<button name="clean" class="btn btn-default" onclick="">Garbitu</button>
		</div>
	</div>
	
    <!--creation du tableau-->
	<table class='table table-bordered table-responsive' id='values_table'> 
        <tr>
			<th>N° </th>
			<th width='100'>Data </th>
            <th>Ikaslea </th>
            <th>Ikasgaia </th>
            <th>Irakaslea </th>
            <th>Jarrera </th>
			<th>Efizentzia </th>
			<th>Irakaslearen arreta </th>
			<th>Oharra </th>
			<th>Gela </th>
			<th>Mahaia </th>
            <th colspan="2" align="center">Actions</th>
        </tr>
<?php
		
		$registro_por_pagina = 10; /*Cantidad de registros que aparecen en la pagina */
		$pagina = '';
		$allRows = 0;
		if(isset($_GET["pagina"]))
		{
		 $pagina = $_GET["pagina"];
		 if($pagina == 0){
			 $allRows = 1;
			 $registro_por_pagina = 99999999;
			 $pagina = 1;
		 }
		}
		else
		{
		 $pagina = 1;
		}

		$start_from = ($pagina-1)*$registro_por_pagina;

?>	
		
		
        <?php    
		
		$sqlString = "
				SELECT e.id as id,
				e.creation_date as eguna,
				CONCAT(ikasle.first_name, ' ', ikasle.last_name) as ikasle_izena,
				ikasle.image_name,
				ikasgai.name as ikasgaia,
				CONCAT(irakasle.first_name, ' ', irakasle.last_name) as irakasle_izena,
				j.name as jarrera,
				ef.name as efizentzia,
				ia.name as irakasle_arreta,
				m.gela as gela,
				m.mahaia as mahaia,
				e.oharra as oharra
				FROM tbl_egunerokoa e 
				JOIN tbl_mahai m on m.id = e.mahai_id
				JOIN tbl_jarrera j on j.id = e.jarrera_id
				join tbl_irakasle_arreta ia on ia.id = e.irakasle_arreta_id
				join tbl_irakasle irakasle on irakasle.id = e.irakaslea_id
				join tbl_ikasle ikasle on ikasle.id = e.ikaslea_id
				join tbl_ikasgai ikasgai on ikasgai.id = e.ikasgai_id
				join tbl_efizentzia ef on ef.id = e.efizentzia_id  ";
			$egunerokoaCrud->dataview($sqlString."ORDER BY eguna desc LIMIT $start_from, $registro_por_pagina ");
			
			$sqlCountString = "SELECT count(id) as total from tbl_egunerokoa ";
			$total_records = $egunerokoaCrud->dataviewCount($sqlCountString);
			
			
			//error_log($total_records);
	    ?>
		<tr>
		<td colspan="13">
			<div class='pagination'>
<?php
			if($allRows == 0){
				$total_pages = ceil($total_records/$registro_por_pagina);
				$start_loop = $pagina;
				$diferencia = $total_pages - $pagina;
				if($diferencia <= 5)
				{
				 $start_loop = $total_pages - 5;
				}
				$end_loop = $start_loop + 4;
				if($pagina > 1)
				{
				 echo "<a href='egunerokoa_view.php?pagina=1'>Lehena</a>";
				 echo "<a href='egunerokoa_view.php?pagina=".($pagina - 1)."'><<</a>";
				}
				for($i=$start_loop; $i<=$end_loop; $i++)
				{     
					if($i==$pagina){
						echo "<span class='current'>$i</span>";
					}else{
						echo "<a class='pagina' href='egunerokoa_view.php?pagina=".$i."'>".$i."</a>";
					}
				}
				if($pagina <= $end_loop)
				{
				 echo "<a href='egunerokoa_view.php?pagina=".($pagina + 1)."'>>></a>";
				 echo "<a href='egunerokoa_view.php?pagina=".$total_pages."'>Azkena</a>";
				}
				echo "<a href='egunerokoa_view.php?pagina=0'>Denak ikusi</a>";
			}else{
				echo "<a href='egunerokoa_view.php?pagina=1'>Paginaziora itzuli</a>";
			}
?>
			</div>
		</td>		
		</tr>
		<tr>
            <td colspan="13">
                <a href="index.php" class="btn btn-large btn-success" style="float: right;"><i class="glyphicon glyphicon-backward"></i> &nbsp; Atzera</a>
            </td>
        </tr>
    </table> 
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