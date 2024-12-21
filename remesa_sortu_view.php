<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>

<link href="tabulator/css/tabulator.min.css" rel="stylesheet">
<script type="text/javascript" src="tabulator/js/tabulator.min.js"></script>
<script type="text/javascript" src="tabulator/js/xlsx.full.min.js"></script>
<script type="text/javascript" src="tabulator/js/jspdf.min.js"></script>
<script type="text/javascript" src="tabulator/js/jspdf.plugin.autotable.js"></script>
<script type="text/javascript" src="moment.min.js"></script>
<style>
#data-table {
  width: 1380px;
}
</style>



<script type="text/javascript">

$(document).ready(function(){
	
	var table = null;
	
	//trigger download of data.xlsx file
	$("#download-xlsx").click(function(){
		if(table != null){
			table.download("xlsx", "Remesak.xlsx", {sheetName:"Remesak"});
		}
		
	});

	//trigger download of data.pdf file
	$("#download-pdf").click(function(){
		if(table != null){
			table.download("pdf", "Remesak.pdf", {
				orientation:"landscape", //set page orientation to landscape
				title:"Remesak", //add title to report
			});
		}
	});
	
	
	
	$(document).on("click", "button[name='clean']", function(e){
		$("#startDate").datepicker('update','');
		$("#endDate").datepicker('update','');
		$(".result").empty();
		$('.ikasle input[type="text"]').val('');
		$('input[name="ikasle-id"]').val('');
		table = null
		$('#container').empty();
		$('#container').append("<div id='data-table'></div><br>");
	});

	
	$(document).on("click", "button[name='search']", function(e){
		$('#container').empty();
		$('#container').append("<div id='data-table'></div>");
		
		
		var ikasleId = $('.search-box input[name="ikasle-id"]').val();
		var ikastetxeId = $('.search-box input[name="ikastetxe-id"]').val();
		var mailaId = $('.search-box input[name="maila-id"]').val();
		var egoera = $('input:radio[name=estado]:checked').val();


		//trigger AJAX load on "Load Data via AJAX" button click
			//Build Tabulator
		table = new Tabulator("#data-table", {
			height:"80%",
			layout:"fitColumns",
			placeholder:"No Data Set",
			clipboard:true,
			columns:[
				{title:"Id", field:"id", sorter:"number", align:"right", width:80, headerSort:true, headerFilter:"input", headerFilterPlaceholder:"..."},
				{title:"Ikaslea", field:"izena", sorter:"string", align:"left", width:240, headerSort:true, headerFilterPlaceholder:"...", headerFilter:"input"},
				{title:"Egoera", tooltip:function(cell){
									//column - column component

									//function should return a string for the header tooltip of false to hide the tooltip
									return  cell.getRow().getData()['validationErrors'];
								}, 
								align:"center", field:"validated", headerSort:true, formatter:"tickCross", width:100, headerFilter:"tickCross",  headerFilterParams:{"tristate":true},headerFilterEmptyCheck:function(value){return value === null}},
				{title:"Ikastetxea", field:"ikastetxea", sorter:"string", align:"left", width:240, headerSort:true, headerSort:true, headerFilterPlaceholder:"...", headerFilter:"input"},
				{title:"Ikasmaila", field:"ikasmaila", sorter:"string", width:120, headerSort:true, headerSort:true, headerFilterPlaceholder:"...", headerFilter:"input"},
				{title:"Orduak astero", field:"hours_per_week", sorter:"number", width:120, headerSort:true, headerFilter:"number", headerFilter:minMaxFilterEditor, headerFilterFunc:minMaxFilterFunction},
				{title:"Orduak hilero", field:"hours_per_month", sorter:"number", width:120, headerSort:true, headerFilter:"number", headerFilter:minMaxFilterEditor, headerFilterFunc:minMaxFilterFunction},
				{title:"Prezioa hilero", field:"prezioa_hilero", sorter:"number", width:120, headerSort:true, bottomCalc:"sum", bottomCalcParams:{precision:2}, headerFilter:"number", headerFilter:minMaxFilterEditor, headerFilterFunc:minMaxFilterFunction},
				{title:"Prezioa zuzenduta", field:"prezioa_hilero_zuzenduta", editor: 'input', sorter:"number", width:120, headerSort:true, bottomCalc:"sum", bottomCalcParams:{precision:2}, headerFilter:"number", headerFilter:minMaxFilterEditor, headerFilterFunc:minMaxFilterFunction},
				{title:"Matrikula", align:"center", field:"matrikula", headerSort:true, editor: true, formatter:"tickCross", width:100, headerFilter:"tickCross",  headerFilterParams:{"tristate":true},headerFilterEmptyCheck:function(value){return value === null}},
				{title:"Aukeratu", align:"center", field:"checked", headerSort:true, editor: true, formatter:"tickCross", width:100, headerFilter:"tickCross",  headerFilterParams:{"tristate":true},headerFilterEmptyCheck:function(value){return value === null}}
			],
			footerElement:"<button class='tabulator-footer' name='doCheckAllRows'><i class='fa fa-check'></i>Check all</button>" +
						  "<button class='tabulator-footer' name='doUnCheckAllRows'><i class='fa fa-times'></i>UnCheck all</button>",
			cellEdited: function (cell) {
				var field = cell.getColumn().getField();
				if(field == 'checked'){
					//cell.setValue(!cell.getValue());
					//table.navigateDown();
					
				}
				
			},
			//footerElement:"<button id='save' class='pull-left' title='Save'>Save</button> ",
			ajaxResponse:function(url, params, response){
				//url - the URL of the request
				//params - the parameters passed with the request
				//response - the JSON object returned in the body of the response.

				return response; //return the response data to tabulator
			},
			ajaxError:function(xhr, textStatus, errorThrown){
				//xhr - the XHR object
				//textStatus - error type
				//errorThrown - text portion of the HTTP status
			},
		});
		
		table.setData("ajax_search.php?search-ikasle-remesa", {
												 ikasle_id: ikasleId,
												 ikastetxe_id: ikastetxeId,
												 maila_id: mailaId,
												 egoera: egoera
												}, "POST")
			.then(function(){
				//run code after table has been successfuly updated
				var rows_ = table.getRows();
				var edited_ = new Array();

				rows_.forEach(function(row_){
					var data_ = row_.getData();
					data_['checked'] = false;
					edited_.push(data_);
				});
				table.updateData(edited_);
				rows_.forEach(function(row_){
					var data_ = row_.getData();
					data_['checked'] = true;
					edited_.push(data_);
				});
				table.updateData(edited_);
			})
			.catch(function(error){
				alert(error);
			});


	});
	
	
	$(document).on("click", "button[name='doCheckAllRows']", function(e){
		var rows = table.getRows('active');
		var edited = new Array();

		rows.forEach(function(row){
			var data = row.getData();
			data['checked'] = true;
			edited.push(data);
		});
		table.updateData(edited);

	});
	
	$(document).on("click", "button[name='doUnCheckAllRows']", function(e){
		var rows = table.getRows('active');
		var edited = new Array();

		rows.forEach(function(row){
			var data = row.getData();
			data['checked'] = false;
			edited.push(data);
		});
		table.updateData(edited);
		
	});
	
	
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
	
	$('.search-box input[name="ikastetxe"]').on("click", function(){
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
		$.post("ajax_search.php?ikastetxe", {search: inputVal}).done(function(data){
			// Display the returned data in browser
			resultDropdown.html(data);
		});
    });
	
	$('.search-box input[name="maila"]').on("click", function(){
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
		$.post("ajax_search.php?maila", {search: inputVal}).done(function(data){
			// Display the returned data in browser
			resultDropdown.html(data);
		});
    });
	

	
	

    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
		var ikasleName = $(this).text();
		var ikasleId = $(this).attr("id");
        $(this).parents(".search-box").find('input[type="text"]').val(ikasleName);
		$(this).parents(".search-box").find('input[type="hidden"]').val(ikasleId);
        $(this).parent(".result").empty();
		
		
    });
	
	


	
	$(document).on('click', function (e) {
		if ($(e.target).closest(".ikasle").length == 0) {
			$(".result").empty();
			if($('input[name="ikasle-id"]').val() == '' || $('input[name="ikasle-id"]').val() == 'undefined'){
				$('.ikasle input[type="text"]').val('');
			}
			
		}
	});
	
	//custom max min header filter
	var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){

		var end;

		var container = document.createElement("span");

		//create and style inputs
		var start = document.createElement("input");
		start.setAttribute("type", "number");
		start.setAttribute("placeholder", "Min");
		start.setAttribute("min", 0);
		start.setAttribute("max", 100);
		start.style.padding = "4px";
		start.style.width = "50%";
		start.style.boxSizing = "border-box";

		start.value = cell.getValue();

		function buildValues(){
			success({
				start:start.value,
				end:end.value,
			});
		}

		function keypress(e){
			if(e.keyCode == 13){
				buildValues();
			}

			if(e.keyCode == 27){
				cancel();
			}
		}

		end = start.cloneNode();
		end.setAttribute("placeholder", "Max");

		start.addEventListener("change", buildValues);
		start.addEventListener("blur", buildValues);
		start.addEventListener("keydown", keypress);

		end.addEventListener("change", buildValues);
		end.addEventListener("blur", buildValues);
		end.addEventListener("keydown", keypress);


		container.appendChild(start);
		container.appendChild(end);

		return container;
	 }

	//custom max min filter function
	function minMaxFilterFunction(headerValue, rowValue, rowData, filterParams){
		//headerValue - the value of the header filter element
		//rowValue - the value of the column in this row
		//rowData - the data for the row being filtered
		//filterParams - params object passed to the headerFilterFuncParams property

			if(rowValue){
				if(headerValue.start != ""){
					if(headerValue.end != ""){
						return rowValue >= headerValue.start && rowValue <= headerValue.end;
					}else{
						return rowValue >= headerValue.start;
					}
				}else{
					if(headerValue.end != ""){
						return rowValue <= headerValue.end;
					}
				}
			}

		return false; //must return a boolean, true if it passes the filter.
	}
	
	function sortuFakturak(){ 
	
		var processedList = new Array();
		var tableData = table.getData();
		
		tableData.forEach(function(element, i) { 
			if(element['checked'] == '1' || element['checked'] == true){
				processedList.push(element);
			}
		});
		
		var json = JSON.stringify(processedList);


		$.ajax({
			async:true,
			type:"POST",
			dataType:"html",//html
			contentType:"application/x-www-form-urlencoded",
			url:"ajax_remesa_sortu.php?ikasle-fakturak",
			data:{
				 json: json
			},
			beforeSend: function(){
				$('button[name="btn-export"]').prop('disabled', true);;
				$("#loader").attr("style", "display:inline");
				$("#loader").show();
			},
			success:function(data){
				$("#temp").html(data);
								
			},
			error:function(data){
				alert(data.responseText);
				$("#loader").hide();
				$('button[name="btn-export"]').prop('disabled', false);
			},
			complete:function(data){
				// Hide image container
				$("#loader").hide();
				$('button[name="btn-export"]').prop('disabled', false);
			},
			timeout: (1000*60*20) // sets timeout to 20 min
		});

	}
	
	var modalConfirmFakturak = function(callback){
  
	  $("#btn-confirm-fakturak").on("click", function(){
			if(table != null){
				$("#mi-modal-fakturak").modal('show');
			}
	  });

	  $("#modal-btn-si-fakturak").on("click", function(){
		callback(true);
		$("#mi-modal-fakturak").modal('hide');
	  });
	  
	  $("#modal-btn-no-fakturak").on("click", function(){
		callback(false);
		$("#mi-modal-fakturak").modal('hide');
	  });
	};

	modalConfirmFakturak(function(confirm){
	  if(confirm){
		//Acciones si el usuario confirma
		sortuFakturak();
	  }
	});
	
	
	
	function sortuSEPA(){ 
	
		var processedList = new Array();
		var tableData = table.getData();
		
		tableData.forEach(function(element, i) { 
			if(element['checked'] == '1' || element['checked'] == true){
				processedList.push(element);
			}
		});
		
		var json = JSON.stringify(processedList);


		$.ajax({
			async:true,
			type:"POST",
			dataType:"html",//html
			contentType:"application/x-www-form-urlencoded",
			url:"ajax_remesa_sortu.php?ikasle-sepa",
			data:{
				 json: json
			},
			beforeSend: function(){
				$('button[name="btn-export"]').prop('disabled', true);;
				$("#loader").attr("style", "display:inline");
				$("#loader").show();
			},
			success:function(data){
				var opResult = JSON.parse(data);
				var $a = $("<a>");
				$a.attr("href",opResult.data);
				$("body").append($a);
				$a.attr("download", 'SEPA_' + moment().format('DD-MM-YYYY') + '.xml');
				$a[0].click();
				$a.remove();			
			},
			error:function(data){
				alert(data.responseText);
				$("#loader").hide();
				$('button[name="btn-export"]').prop('disabled', false);
			},
			complete:function(data){
				// Hide image container
				$("#loader").hide();
				$('button[name="btn-export"]').prop('disabled', false);
			},
			timeout: (1000*60*20) // sets timeout to 20 min
		});

	}
	
	var modalConfirmSEPA = function(callback){
  
	  $("#btn-confirm-sepa").on("click", function(){
			if(table != null){
				$("#mi-modal-SEPA").modal('show');
			}
	  });

	  $("#modal-btn-si-SEPA").on("click", function(){
		callback(true);
		$("#mi-modal-SEPA").modal('hide');
	  });
	  
	  $("#modal-btn-no-SEPA").on("click", function(){
		callback(false);
		$("#mi-modal-SEPA").modal('hide');
	  });
	};

	modalConfirmSEPA(function(confirm){
	  if(confirm){
		//Acciones si el usuario confirma
		sortuSEPA();
	  }
	});
	

});





</script>


<div class="container"> 
	
    <div class="search-box">
        <input type="text" name="ikasle" autocomplete="off" placeholder="Ikaslea..." />
        <div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
    </div>
	
	<div class="search-box">
        <input type="text" name="ikastetxe" autocomplete="off" placeholder="Ikastetxea..." />
        <div class="result"></div><input type='hidden' name='ikastetxe-id' class='form-control'>
    </div>
	
	<div class="search-box">
        <input type="text" name="maila" autocomplete="off" placeholder="Maila..." />
        <div class="result"></div><input type='hidden' name='maila-id' class='form-control'>
    </div>
	</br>
	<label>Ikaslearen egoera:</label>
	<input type="radio" id="todos" name="estado" value="2"> Denak
	<input type="radio" id="activados" name="estado" value="1" checked> Aktibatuta
	<input type="radio" id="desactivados" name="estado" value="0"> Desaktibatuta
	</br>
	<div style="display:inline-block;">
		<button name="search" class="btn btn-default" onclick="">Bilatu</button>
		<button name="clean" class="btn btn-default" onclick="">Garbitu</button>&nbsp;
		<button id="download-xlsx" class="btn btn-default" onclick="">Download XLSX</button>
		<button id="download-pdf" class="btn btn-default" onclick="">Download PDF</button>&nbsp;
		<button class="btn btn-danger" name="btn-save" id="btn-confirm-fakturak">
		<span class="glyphicon glyphicon-send"></span> &nbsp; Sortu fakturak</button>&nbsp;
		<button class="btn btn-danger" name="btn-save" id="btn-confirm-sepa">
		<span class="glyphicon glyphicon-send"></span> &nbsp; Sortu bankuko fitxategia</button>&nbsp;
		<!-- Image loader -->
		<div id='loader' style='display: none;'>
		  <img src='reload.gif' width='32px' height='32px'>
		</div>
		<!-- Image loader -->
	</div>
	</br>
	<div id='container' align="center">
		<div id="data-table"></div><br>
	</div>
	<div id="temp"></div>
	
	
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal-fakturak">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Baieztatu</h4>
		  </div>
		  <div class="modal-body">
			Ziur al zaude erremesa berri baten <b>fakturak</b> sortu nahi duzula?
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" id="modal-btn-si-fakturak">Si</button>
			<button type="button" class="btn btn-primary" id="modal-btn-no-fakturak">No</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal-SEPA">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Baieztatu</h4>
		  </div>
		  <div class="modal-body">
			Ziur al zaude erremesa berri baten <b>SEPA fitxategia</b> sortu nahi duzula?
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" id="modal-btn-si-SEPA">Si</button>
			<button type="button" class="btn btn-primary" id="modal-btn-no-SEPA">No</button>
		  </div>
		</div>
	  </div>
	</div>
</div>
 



 
	
	
<?php	
} else {
	//session_start();
	//session_destroy();
	header("Location:../login.php");
	
}
?>
	<div id="footer">
		<?php include_once 'footer.php'; ?> <!--inclure le footer de la page -->
	</div>
</body>
</html>