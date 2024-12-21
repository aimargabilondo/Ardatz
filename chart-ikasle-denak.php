<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>

<script type="text/javascript" src="Chart.min.js"></script>
<script type="text/javascript" src="utils.js"></script>
<script type="text/javascript" src="moment.min.js"></script>
<link id="bsdp-css" href="bootstrap-datepicker3.min.css" rel="stylesheet">
<script src="bootstrap-datepicker.min.js"></script>
<script src="bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
<script src="bootstrap-datepicker.eu.min.js" charset="UTF-8"></script>
<link href="tabulator/css/tabulator.min.css" rel="stylesheet">
<script type="text/javascript" src="tabulator/js/tabulator.min.js"></script>

<style>
#oharra-table {
  height: 200px;
  width: 1000px;
}
</style>



<script type="text/javascript">

$(document).ready(function(){
	
	$(document).on("click", "button[name='clean']", function(e){
		$("#startDate").datepicker('update','');
		$("#endDate").datepicker('update','');
		$(".result").empty();
		$('.ikasle input[type="text"]').val('');
		$('input[name="ikasle-id"]').val('');
		
		$('#container').empty();
		$('#container').append("<div id='oharra-table'></div><br>");
		$('#container').append("<div style='width:1000px'><canvas id='chartIkasgaiak'></canvas></div><br>");
		$('#container').append("<div style='width:1000px'><canvas id='chartJarrera'></canvas></div><br>");
		$('#container').append("<div style='width:1000px'><canvas id='chartEfizientzia'></canvas></div><br>");
	});
	

	
	$(document).on("click", "button[name='search']", function(e){
		$('#container').empty();
		$('#container').append("<div id='oharra-table'></div>");
		$('#container').append("<div style='width:1000px'><canvas id='chartIkasgaiak'></canvas></div><br>");
		$('#container').append("<div style='width:1000px'><canvas id='chartJarrera'></canvas></div><br>");
		$('#container').append("<div style='width:1000px'><canvas id='chartEfizientzia'></canvas></div><br>");
		
		
		if($('input[name="ikasle-id"]').val() != '' && $('input[name="ikasle-id"]').val() != 'undefined'){
			var ikasleId = $('input[name="ikasle-id"]').val();
			var startDate = '';
			var endDate = '';
			if($("#startDate").datepicker('getDate') != null){
				startDate = moment($("#startDate").datepicker('getDate')).format('YYYY/MM/DD');
			}
			
			if($("#endDate").datepicker('getDate') != null){
				endDate = moment($("#endDate").datepicker('getDate')).add(1, 'days').format('YYYY/MM/DD');
			}
			
			//$("#oharra-table").tabulator("setData", "ajax_search.php?chart-oharra", {ikasleId: ikasleId, startDate:startDate, endDate:endDate});
			


			//trigger AJAX load on "Load Data via AJAX" button click
				//Build Tabulator
			var table = new Tabulator("#oharra-table", {
				height:"311px",
				layout:"fitColumns",
				placeholder:"No Data Set",
				columns:[
					{title:"Noiz", field:"datetime", sorter:"date", align:"center", width:180, headerSort:false},
					{title:"Ikasgaia", field:"ikasgai", sorter:"string", width:180, headerSort:false},
					{title:"Irakaslea", field:"irakaslea", sorter:"string", width:200, headerSort:false},
					{title:"Oharra", field:"oharra", sorter:"string", formatter:"textarea", width:3000, headerSort:false},
				],
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
			table.setData("ajax_search.php?chart-oharra", {ikasleId: ikasleId, startDate:startDate, endDate:endDate}, "POST");
			
			drawIkasgaiChart(ikasleId, startDate, endDate);
			drawJarreraChart(ikasleId, startDate, endDate);
			drawEfizientziaChart(ikasleId, startDate, endDate);
		
		}else{
			alert("Aukeratu ikasle bat!");
		}
	});
	
	function drawIkasgaiChart(ikasleId, startDate, endDate){
		$.post("ajax_search.php?chart-ikasle-ikasgai", {ikasleId: ikasleId, startDate:startDate, endDate:endDate}).done(function(data){

			var arrayObjects = JSON.parse(data);
			var config = {
				type: 'pie',
				data: {
					datasets: [{
						label: arrayObjects.ikaslea,
						data: arrayObjects.total,
						backgroundColor: arrayObjects.color,
						borderColor: "white",
						borderWidth: 1
					}],
					labels: arrayObjects.ikasgai
				},
				options: {
					showDatasetLabels : true,
					responsive: true,
					title: {
						display: true,
						text: 'Landutako ikasgaiak - ' + $('.ikasle input[type="text"]').val()
					},
					legend: {
					  display: true,
					  position: "bottom",
					  labels: {
						fontColor: "#333",
						fontSize: 16
					  }
					},
					pieceLabel: {
						render: 'percentage',
						fontColor: 'white',
						fontSize: 14,
					},
					tooltips: {
						callbacks: {
							label: function(tooltipItem, data) {
								//get the concerned dataset
								var dataset = data.datasets[tooltipItem.datasetIndex];
								//calculate the total of this data set
								var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
									return previousValue + currentValue;
								});
								//get the current items value
								var currentValue = dataset.data[tooltipItem.index];
								//calculate the precentage based on the total and current item, also this does a rough rounding to give a whole number
								var percentage = Math.floor(((currentValue/total) * 100)+0.5);

								return currentValue + " - " + percentage + "%";
							}
						}
					}
				}
			};

			var ctx = document.getElementById('chartIkasgaiak').getContext('2d');
			window.myPie = new Chart(ctx, config);
			
			window.myPie.update();
			
		});
	}
	
	function drawJarreraChart(ikasleId, startDate, endDate){
		$.post("ajax_search.php?chart-ikasle-jarrera", {ikasleId: ikasleId, startDate:startDate, endDate:endDate}).done(function(data){
			
			// Display the returned data in browser
			var arrayObjects = JSON.parse(data);
			
			var ikasgaiak = Object.keys(arrayObjects);
			
			var dateFormat = 'YYYY-MM-DD HH:mm:ss';
			
			
			var datasets = new Array();
			ikasgaiak.forEach((ikasgai, index, array) => {
				var kolorea = '';
				var points = new Array();
				arrayObjects[ikasgai].forEach((point, index, array) => {
					var date = moment(point['datetime'], dateFormat);
					var jarreraId = point['jarrera'];
					kolorea = point['kolorea'];
					points.push({t: date.valueOf(),y: jarreraId});
				});
				
				var newDataset = {
					label: ikasgai,
					backgroundColor: kolorea,
					borderColor: kolorea,
					data: points,
					pointRadius: 5,
					showLine: false,
					fill: false
				};
				datasets.push(newDataset);
			});

			
			
			var cfg = {
				type: 'line',
				data: {
					labels: ikasgaiak,
					datasets: datasets
				},
				options: {
					elements: {
						line: {
							tension: 0
						}
					},
					responsive: true,
					title: {
						display: true,
						text: 'Jarrera bilakaera - ' + $('.ikasle input[type="text"]').val()
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							type: 'time',
							time: {
								unit: 'day',
								tooltipFormat: 'lll',
							},
							distribution: 'series',
							ticks: {
								source: 'data',
								autoSkip: true
							}
						}],
						yAxes: [{
							scaleLabel: {
								display: true,
								labelString: 'Jarrera'
							},
							ticks: {
							  min: 1,
							  max: 5,
							  stepWidth: 1 
							}
						}]
					},
					tooltips: {
						intersect: false,
						mode: 'index',
						callbacks: {
							label: function(tooltipItem, myData) {
								var label = myData.datasets[tooltipItem.datasetIndex].label || '';
								if (label) {
									label += ': ';
								}
								label += parseFloat(tooltipItem.value).toFixed(2);
								return label;
							}
						}
					}
				}
			};
			
			
			var ctx = new Array();
			ctx = document.getElementById('chartJarrera').getContext('2d');
			//ctx.canvas.width = 1000;
			//ctx.canvas.height = 300;
			window.myLine = new Chart(ctx, cfg);
			window.myLine.update();


		});
	}
	
	function drawEfizientziaChart(ikasleId, startDate, endDate){
		$.post("ajax_search.php?chart-ikasle-efizientzia", {ikasleId: ikasleId, startDate:startDate, endDate:endDate}).done(function(data){
			
			// Display the returned data in browser
			var arrayObjects = JSON.parse(data);
			
			var ikasgaiak = Object.keys(arrayObjects);
			
			var dateFormat = 'YYYY-MM-DD HH:mm:ss';
			
			
			var datasets = new Array();
			ikasgaiak.forEach((ikasgai, index, array) => {
				var kolorea = '';
				var points = new Array();
				arrayObjects[ikasgai].forEach((point, index, array) => {
					var date = moment(point['datetime'], dateFormat);
					var efizientziaId = point['efizientzia'];
					kolorea = point['kolorea'];
					points.push({t: date.valueOf(),y: efizientziaId});
				});
				
				var newDataset = {
					label: ikasgai,
					backgroundColor: kolorea,
					borderColor: kolorea,
					data: points,
					pointRadius: 5,
					showLine: false,
					fill: false
				};
				datasets.push(newDataset);
			});

			
			
			var cfg = {
				type: 'line',
				data: {
					labels: ikasgaiak,
					datasets: datasets
				},
				options: {
					elements: {
						line: {
							tension: 0
						}
					},
					responsive: true,
					title: {
						display: true,
						text: 'Efizientzia bilakaera - ' + $('.ikasle input[type="text"]').val()
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							type: 'time',
							time: {
								unit: 'day',
								tooltipFormat: 'lll',
							},
							distribution: 'series',
							ticks: {
								source: 'data',
								autoSkip: true
							}
						}],
						yAxes: [{
							scaleLabel: {
								display: true,
								labelString: 'Efizientzia'
							},
							ticks: {
							  min: 1,
							  max: 5,
							  stepWidth: 1 
							}
						}]
					},
					tooltips: {
						intersect: false,
						mode: 'index',
						callbacks: {
							label: function(tooltipItem, myData) {
								var label = myData.datasets[tooltipItem.datasetIndex].label || '';
								if (label) {
									label += ': ';
								}
								label += parseFloat(tooltipItem.value).toFixed(2);
								return label;
							}
						}
					}
				}
			};
			
			
			var ctx = new Array();
			ctx = document.getElementById('chartEfizientzia').getContext('2d');
			//ctx.canvas.width = 1000;
			//ctx.canvas.height = 300;
			window.myLine = new Chart(ctx, cfg);
			window.myLine.update();


		});
	}
	
   $("#startDate").datepicker({
	   language: 'eu',
	   format: 'yyyy-mm-dd',
	   autoclose: true,
	   todayBtn: 'linked',
	   date: moment(),
	   todayHighlight: true,
	   ignoreReadonly: true
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
		todayHighlight: true,
		ignoreReadonly: true
	}).on('changeDate', function(e) {
        // do something
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
});


</script>


<table align="center">
	<td style="margin: 10px; padding: 5px;">					
		<div class="search-box ikasle">
			<input type='text' autocomplete="off" placeholder="Ikaslea..." name='ikasle' class='search-input form-control' required>
			<div class="result"></div><input type='hidden' name='ikasle-id' class='form-control'>
		</div>
	</td>
	<td style="margin: 10px; padding: 5px;">					
		<div class='input-group date' id='startDate' style="width: 180px;">
			<input type='text' class="form-control" placeholder="Hasiera data..." readonly />
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
	</td>
	<td style="margin: 10px; padding: 5px;">
		<div class='input-group date' id='endDate' style="width: 180px;">
			<input type='text' class="form-control" placeholder="Bukaera data..." readonly />
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
	</td>
	<td style="margin: 10px; padding: 5px;">
		<div style="display:inline-block;">
			<button name="search" class="btn btn-default" onclick="">Bilatu</button>
			<button name="clean" class="btn btn-default" onclick="">Garbitu</button>
		</div>
	</td>
 </table>
 


<div id='container' align="center">
	<div id="oharra-table"></div><br>
	<div style='width:1000px'><canvas id='chartIkasgaiak'></canvas></div><br>
	<div style='width:1000px'><canvas id='chartJarrera'></canvas></div><br>
	<div style='width:1000px'><canvas id='chartEfizientzia'></canvas></div><br>
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