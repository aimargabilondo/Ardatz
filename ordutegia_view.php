<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>


<link href="tabulator/css/tabulator.min.css" rel="stylesheet">
<script type="text/javascript" src="tabulator/js/tabulator.min.js"></script>
<style>
.data-table {
  width: 262px;
}
<!--.data-table-all {
  width: 302px;
  height: 600px;
}-->
div.scrollable {
	overflow-x:scroll;
}

<!--div.div1 {
    float: left;
    margin-right: 10px;
	-moz-user-select: none; 
	-webkit-user-select: none; 
	-ms-user-select: none; 
	user-select: none;
	-o-user-select: none;
}-->

div.taula {
    overflow: hidden;
	-moz-user-select: none; 
	-webkit-user-select: none; 
	-ms-user-select: none; 
	user-select: none;
	-o-user-select: none;
}


/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  -webkit-animation: fadeEffect 1s;
  animation: fadeEffect 1s;
}

/* Fade in tabs */
@-webkit-keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}
</style>



<script type="text/javascript">
	var activeTable = null;
	var activeWeekDay = null;
	var tableNames = [
		"#table-1-1",
		"#table-1-2",
		"#table-1-3",
		"#table-1-4",
		"#table-1-5",
		"#table-2-1",
		"#table-2-2",
		"#table-2-3",
		"#table-2-4",
		"#table-2-5",
		"#table-3-1",
		"#table-3-2",
		"#table-3-3",
		"#table-3-4",
		"#table-3-5",
		"#table-4-1",
		"#table-4-2",
		"#table-4-3",
		"#table-4-4",
		"#table-4-5",
		"#table-5-1",
		"#table-5-2",
		"#table-5-3",
		"#table-5-4",
		"#table-5-5"
	];
	var tables = new Array();
	
	var ikasleId = null;
	var asteko_eguna_old = null;
	var asteko_eguna_new = null;
	var eguneko_sesioa_old = null;
	var eguneko_sesioa_new = null;
	var gela = null;


$(document).ready(function(){
	var dt = new Date();
	activeWeekDay = dt.getDay();
	if(activeWeekDay == 0 || activeWeekDay == 6){
		activeWeekDay = 1	
	}

	tableNames.forEach(function(name){
			//Table to move rows from
		var table = new Tabulator(name, {
			height:228,
			layout:"fitColumns",
			selectable:true, //make rows selectable
			movableRows:true,
			//movableRowsConnectedTables:tables.concat("#table-all"),
			movableRowsConnectedTables:tableNames,
			movableRowsReceiver: "add",
			movableRowsSender: "delete",
			placeholder:"",
			data:new Array(),
			movableRowsSent:function(fromRow, toRow, toTable){
				//fromRow - the row component from the sending table
				//toRow - the row component from the receiving table (if available)
				//toTable - the Tabulator object for the receiving table
				//alert("movableRowsSent");
				ikasleId = fromRow.getData().id;
				var data = toTable.id.split("-");
				asteko_eguna = activeWeekDay;
				eguneko_sesioa_new = data[1];
				gela_new = data[2];
				setTimeout(function(){
					addIkasle(ikasleId, asteko_eguna, eguneko_sesioa_new, gela_new);
				}, 300);			
				
			},
			movableRowsReceived:function(fromRow, toRow, fromTable){
				//fromRow - the row component from the sending table
				//toRow - the row component from the receiving table (if available)
				//fromTable - the Tabulator object for the sending table
				//alert("movableRowsReceived");
				ikasleId = fromRow.getData().id;
				var data = fromTable.id.split("-");
				asteko_eguna = activeWeekDay;
				eguneko_sesioa_old = data[1];
				gela_old = data[2];
				setTimeout(function(){
					deleteIkasle(ikasleId, asteko_eguna, eguneko_sesioa_old, gela_old);
				}, 300);
			},
			columns:[
				{title:"Name", field:"izena", width:100},
				{title:"Ikasmaila", field:"ikasmaila", width:80},
				{title:"Ikastetxea", field:"ikastetxea"},
			],
			footerElement:"<button class='btn btn-primary' name='reactivity-add'><i class='fa fa-plus'></i>Add</button>	&nbsp; " +
			  "<button class='btn btn-danger' name='reactivity-delete'><i class='fa fa-times'></i>Drop</button>",
		});
		tables.push(table);
	});
	
	$(document).on("click", "button[name='reactivity-add']", function(e){
		tables.forEach(function(table){
			if(table.element.id == e.currentTarget.parentElement.offsetParent.id){
				activeTable = table;
				return;
			}
		});
		$("#mi-modal-add").modal('show');
		$('#modal-btn-si-add').prop('disabled', true);
		setTimeout(function() {
                  $('#inputIkasleIzena').focus();
            }, 500); 
		
	});
	
	var modalConfirmAdd = function(callback){

	  $("#modal-btn-si-add").on("click", function(){
		callback(true);
		$("#mi-modal-add").modal('hide');
	  });
	  
	  $("#modal-btn-no-add").on("click", function(){
		callback(false);
		$("#mi-modal-add").modal('hide');
	  });
	};

	modalConfirmAdd(function(confirm){
	  if(confirm){
		  
		var data = activeTable.element.id.split("-");
		var asteko_eguna = activeWeekDay;
		var eguneko_sesioa = data[1];
		var gela = data[2];
			
		$.post("ajax_ordutegia.php?add-ikasle", {
													ikasle_id: $('input[name="ikasle-id"]').val(),
													asteko_eguna: asteko_eguna,
													eguneko_sesioa: eguneko_sesioa,
													gela:gela
												}
		).done(function(data){
			var allData = JSON.parse(data);
			activeTable.addRow(Object.assign({}, allData[0]));
			$('input[name="ikasle"]').val('');
			$('input[name="ikasle-id"]').val('');
		});
	  }else{
			$('input[name="ikasle"]').val('');
			$('input[name="ikasle-id"]').val('');
	  }
	});
	
	$(document).on("click", "button[name='reactivity-delete']", function(e){
		tables.forEach(function(table){
			if(table.element.id == e.currentTarget.parentElement.offsetParent.id){
				activeTable = table;
				return;
			}
		});
		$("#mi-modal-delete").modal('show');
	});
	
	var modalConfirmDelete = function(callback){

	  $("#modal-btn-si-delete").on("click", function(){
		callback(true);
		$("#mi-modal-delete").modal('hide');
	  });
	  
	  $("#modal-btn-no-delete").on("click", function(){
		callback(false);
		$("#mi-modal-delete").modal('hide');
	  });
	};

	modalConfirmDelete(function(confirm){
	  if(confirm){
		//Acciones si el usuario confirma
		if(activeTable != null){
			var rows = activeTable.getSelectedRows();
			rows.forEach(function callback(row, index, array) {
				var object = row.getData();
				$.post("ajax_ordutegia.php?delete-ikasle", {
																ikasle_id: row.getData().id,
																asteko_eguna: object['asteko_eguna'],
																eguneko_sesioa: object['eguneko_sesioa'],
																gela: object['gela']
															}
				).done(function(data){
					row.delete();
				});
				
			});
		}
	  }
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
	
	// Set search input value on click of result item
    $(document).on("click", ".result p", function(){
		var ikasleName = $(this).text();
		var ikasleId = $(this).attr("id");
		
		var duplicate = false;
		var rows = activeTable.getRows();
			rows.forEach(function callback(row, index, array) {
				var object = row.getData();
				if(object['id'] == ikasleId){
					$('input[name="ikasle"]').val('');
					$('input[name="ikasle-id"]').val('');
					duplicate = true;
					alert(ikasleName + " ikas ordu honetan altan dago iadanik!");
					return;
				}
								
		});
		if(!duplicate){
			$('input[name="ikasle"]').val(ikasleName);
			$('input[name="ikasle-id"]').val(ikasleId);
			$(this).parent(".result").empty();
			$('#modal-btn-si-add').prop('disabled', false);
		}
		
		
    });
	
	
	$(document).on('click', function (e) {
		if ($(e.target).closest(".ikasle").length == 0) {
			$(".result").empty();
			if($('input[name="ikasle-id"]').val() == '' || $('input[name="ikasle-id"]').val() == 'undefined'){
				$('input[name="ikasle"]').val('');
				$('input[name="ikasle-id"]').val('');
			}
			
		}
	});
	
	$.post("ajax_search.php?ordutegia-weekday", {json: 'true', asteko_eguna: activeWeekDay})
		.done(function(data){
			var allData = JSON.parse(data);
			allData.forEach(function callback(object, index, array) {
				tables.forEach(function(table){
					if(table.element.id == "table-"+object['eguneko_sesioa']+"-"+object['gela']){
						table.addRow(Object.assign({}, object));
						return;
					}
				});
			});
			document.getElementById("tab"+activeWeekDay).click();
		});
});


function addIkasle(ikasleId, asteko_eguna, eguneko_sesioa, gela){
	$.post("ajax_ordutegia.php?add-ikasle", {
												ikasle_id: ikasleId,
												asteko_eguna: asteko_eguna,
												eguneko_sesioa: eguneko_sesioa,
												gela: gela
											}
	).done(function(data){
		//row.delete();
	});
	
}

function deleteIkasle(ikasleId, asteko_eguna, eguneko_sesioa, gela){	
	$.post("ajax_ordutegia.php?delete-ikasle", {
													ikasle_id: ikasleId,
													asteko_eguna: asteko_eguna,
													eguneko_sesioa: eguneko_sesioa,
													gela: gela
												}
	).done(function(data){
		
		//var allData = JSON.parse(data);
		//activeTable.addRow(Object.assign({}, allData[0]));
		//$('input[name="ikasle"]').val('');
		//$('input[name="ikasle-id"]').val('');
	});
}

function poponload()
{
    testwindow = window.open('ordutegia_fullscreen_view.php','_blank','height='+screen.height+', width='+screen.width);
    testwindow.moveTo(0, 0);
}

function openTab(evt, tabName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
  
  tables.forEach(function(table){
					table.clearData();
				});
  activeWeekDay = tabName[tabName.length -1];
  	$.post("ajax_search.php?ordutegia-weekday", {json: 'true', asteko_eguna: activeWeekDay})
		.done(function(data){
			var allData = JSON.parse(data);
			allData.forEach(function callback(object, index, array) {
				tables.forEach(function(table){
					if(table.element.id == "table-"+object['eguneko_sesioa']+"-"+object['gela']){
						table.addRow(Object.assign({}, object));
						return;
					}
				});
			});
		});
}




</script>
<button class='btn btn-primary' name='' onclick='javascript: poponload();'><i class='fa fa-window-maximize'></i>Bistaratu taulak</button>

<!-- Tab links -->
<div class="tab">
  <button class="tablinks" id='tab1' onclick="openTab(event, 'tab1')">Astelehena</button>
  <button class="tablinks" id='tab2' onclick="openTab(event, 'tab2')">Asteartea</button>
  <button class="tablinks" id='tab3' onclick="openTab(event, 'tab3')">Azteazkena</button>
  <button class="tablinks" id='tab4' onclick="openTab(event, 'tab4')">Osteguna</button>
  <button class="tablinks" id='tab5' onclick="openTab(event, 'tab5')">Ostirala</button>
</div>


	<div class="taula">
		<table class="table table-bordered">
		  <tr>
		    <th align="center">Ordua</th>
			<th align="center">1. Gela</th>
			<th align="center">2. Gela</th>
			<th align="center">3. Gela</th>
			<th align="center">4. Gela</th>
			<th align="center">5. Gela</th>
		  </tr>
		  <tr>
			<td><div>14:30</br>16:00</div></td>
			<td><div id="table-1-1" class="data-table"></div></td>
			<td><div id="table-1-2" class="data-table"></div></td>
			<td><div id="table-1-3" class="data-table"></div></td>
			<td><div id="table-1-4" class="data-table"></div></td>
			<td><div id="table-1-5" class="data-table"></div></td>
		  </tr>
		  <tr>
			<td><div>16:00</br>17:00</div></td>
			<td><div id="table-2-1" class="data-table"></div></td>
			<td><div id="table-2-2" class="data-table"></div></td>
			<td><div id="table-2-3" class="data-table"></div></td>
			<td><div id="table-2-4" class="data-table"></div></td>
			<td><div id="table-2-5" class="data-table"></div></td>
		  </tr>
		  <tr>
			<td><div>17:00</br>18:00</div></td>
			<td><div id="table-3-1" class="data-table"></div></td>
			<td><div id="table-3-2" class="data-table"></div></td>
			<td><div id="table-3-3" class="data-table"></div></td>
			<td><div id="table-3-4" class="data-table"></div></td>
			<td><div id="table-3-5" class="data-table"></div></td>
		  </tr>
		  <tr>
			<td><div>18:00</br>19:00</div></td>
			<td><div id="table-4-1" class="data-table"></div></td>
			<td><div id="table-4-2" class="data-table"></div></td>
			<td><div id="table-4-3" class="data-table"></div></td>
			<td><div id="table-4-4" class="data-table"></div></td>
			<td><div id="table-4-5" class="data-table"></div></td>
		  </tr>
		  <tr>
			<td><div>19:00</br>20:30</div></td>
			<td><div id="table-5-1" class="data-table"></div></td>
			<td><div id="table-5-2" class="data-table"></div></td>
			<td><div id="table-5-3" class="data-table"></div></td>
			<td><div id="table-5-4" class="data-table"></div></td>
			<td><div id="table-5-5" class="data-table"></div></td>
		  </tr>
		</table>
	</div>


	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal-add">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Aukeratu ikaslea:</h4>
		  </div>
		  <div class="modal-body">
			    <div class="search-box">
					<input type="text" name="ikasle" autocomplete="off" placeholder="Ikaslea..." id='inputIkasleIzena'/>
					<div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
				</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" id="modal-btn-si-add">Si</button>
			<button type="button" class="btn btn-primary" id="modal-btn-no-add">No</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal-delete">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Baieztatu</h4>
		  </div>
		  <div class="modal-body">
			Ziur al zaude aukeratutako ikasleak borratu nahi al dituzula?
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" id="modal-btn-si-delete">Si</button>
			<button type="button" class="btn btn-primary" id="modal-btn-no-delete">No</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal-duplicate">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Informazioa</h4>
		  </div>
		  <div class="modal-body">
			Ikaslea iadanik altan dago!
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning">Ok</button>
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