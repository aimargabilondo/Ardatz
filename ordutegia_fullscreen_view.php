<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hirune 3N Ardatz</title>


<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<!--<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

<!--<link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>-->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">    </script>



<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

<!--<script>document.write('<script src="/myJavascript.js?dev=' + Math.floor(Math.random() * 100) + '"\><\/script>');</script>-->
<script>document.write('<link rel="stylesheet" media="screen" type="text/css" href="css/style.css?dev=' + Math.floor(Math.random() * 100) + '"\>');</script>
<!--<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />-->
<link rel="stylesheet" href="css/fullcalendar.min.css" />

<link href="tabulator/css/tabulator.min.css" rel="stylesheet">
<script type="text/javascript" src="tabulator/js/tabulator.min.js"></script>
<style>
.data-table {
  width: 240px;
}
<!--.data-table-all {
  width: 302px;
  height: 600px;
}-->


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


html, body {
  background: #CFFFFD;
  padding-left: 40;
  padding-top: 20;
  margin: 0;
}
table {
  background: white;
}

*:fullscreen
*:-ms-fullscreen,
*:-webkit-full-screen,
*:-moz-full-screen {
   overflow: auto !important;
}

.tabulator-header {
    height: 0;
}

.tabulator { font-size: 16px; }
</style>

</head>
<body>





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


$(document).ready(function(){
	var dt = new Date();
	activeWeekDay = dt.getDay();
	if(activeWeekDay == 0 || activeWeekDay == 6){
		activeWeekDay = 1	
	}

	tableNames.forEach(function(name){
			//Table to move rows from
		var table = new Tabulator(name, {
			height:160,
			layout:"fitColumns",
			selectable:true, //make rows selectable
			//movableRowsConnectedTables:tables.concat("#table-all"),
			movableRowsConnectedTables:tableNames,
			placeholder:"",
			data:new Array(),
			columns:[
				{title:"Name", field:"izena", width:238, align:"center"},
			]
		});
		tables.push(table);
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
		
	$("body").dblclick(function(){
	  toggleFullScreen(document.body);
	  //toggleFullScreen(document.getElementById('all_tables'));
	});
	
	setInterval("reload();",60000); 
});


function reload(){
	
	var dt = new Date();
	activeWeekDay = dt.getDay();
	if(activeWeekDay == 0 || activeWeekDay == 6){
		activeWeekDay = 1	
	}
	
	
    document.getElementById("tab"+activeWeekDay).click();
}


function toggleFullScreen(elem) {
  if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
    if (elem.requestFullScreen) {
      elem.requestFullScreen();
    } else if (elem.mozRequestFullScreen) {
      elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullScreen) {
      elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
    } else if (elem.msRequestFullscreen) {
      elem.msRequestFullscreen();
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
  }
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