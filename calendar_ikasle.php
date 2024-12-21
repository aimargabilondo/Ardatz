<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
?>


<script src="js/jquery-1.11.0.min.js"></script>
<script src="moment.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script src='js/es.js'></script>
<script>



$(document).ready(function () {
	
	let classWeekDays = [];
	
	
	const getMonthClassDays = (desiredMonth, classWeekDays) => {
	  const daysInMonth = desiredMonth.daysInMonth();
	  const theoricalDays = [];
	  const today = moment(new Date());
	  for (let i = 1; i <= daysInMonth; i++) {
		let date = moment(`${desiredMonth.format('YYYY')}-${desiredMonth.format('MM')}-${i}`, 'YYYY-MM-DD')
		if(today.diff(date, 'days') > 0){
			if(classWeekDays.includes(''+ date.day())){
				theoricalDays.push(`${date.format('YYYY-MM-DD')}`);
			}
		}
	  }
	  
	  return theoricalDays
	}



	
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
    $(document.body).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
		$(this).parents(".search-box").find('input[type="hidden"]').val($(this).attr("id"));
        $(this).parent(".result").empty();
    });
	




function fetchEventsFunction(start, end, timezone, callback) {
	$.ajax({
		url: "calendar/fetch-event.php?get-events",
		type: "POST",
		data: {
			start: start.format('YYYY-MM-DD'),
			end: end.format('YYYY-MM-DD'),
			ikasleId: $('.search-box input[name="ikasle-id"]').val()
		},
		success : function(doc) {
			var realDays = $.parseJSON(doc);
			var events = [];
			events = realDays.slice(0);
			let year = start.format('YYYY');
			let month = start.format('MM');
			//let classWeekDays = [1,2,3,4,5];
			let lastMonth = moment(`${year}-${month}-01`, 'YYYY-MM-DD');
			let thisMonth = moment(`${year}-${month}-01`, 'YYYY-MM-DD').add(1, 'months');
			let nextMonth = moment(`${year}-${month}-01`, 'YYYY-MM-DD').add(2, 'months');
			let theoricalDays = getMonthClassDays(lastMonth, classWeekDays).concat(getMonthClassDays(thisMonth, classWeekDays).concat(getMonthClassDays(nextMonth, classWeekDays)));
			//console.log(theoricalDays);
			var _realDays = [];
			$.each(realDays, function(index, value){
				_realDays.push(value.startFormated);
			});
			
			$.each(theoricalDays, function(index, value){
				if ($.inArray(value, _realDays) == -1) {
				  //console.log(value + " not in Ardatz");
				  
				  var newAsistentziaFalta = {
						title    : 'Asistentzia falta',
						start    : value,
						end      : value,
						egunerokoaId: '100',
						startFormated: value,
						endFormated: value,
						ikasgaiId: '100',
						ikasgaiColor: 'red'
				  };
				  
				  events.push(newAsistentziaFalta);
				}else{
				  //console.log(value + " in Ardatz");
				}
			});
			
			callback(events);
			//console.log(doc);
		}

	});
}
			

	
    var calendar = $('#calendar').fullCalendar({
        editable: false,
        //events: events,
        displayEventTime: false,
        eventRender: function (event, element, view) {
			if(event.ikasgaiId == '99'){
				element.css('color', 'black');
				element.css('background-color', 'orange');
			}else if(event.ikasgaiId == '100'){
				element.css('color', 'black');
				element.css('background-color', 'red');
			}
        },
		eventSources: [{
            events: fetchEventsFunction
        }],
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            calendar.fullCalendar('unselect');
        },
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
		dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
		locale: "es",
		firstDay: 1,
        eventClick: function (event) {
			$.ajax({
				type: "POST",
				url: "calendar/fetch-event.php?show-modal",
				data: {
					idEgunerokoa: event.egunerokoaId
				},
				success: function (response) {
					$('.modal-body').html(response);
				}
			}).then(function (result) {
				$('#showModalSpan').click();
				return result;
			});
        }

    });
	
	
	$(document).on("click", "button[name='clean']", function(e){
		$('.search-box input[name="ikasle"]').val('');
		$('.search-box input[name="ikasle-id"]').val('0');
		$.post("ajax_asteko_egunak.php?asteko_egunak", {ikasleId: $('.search-box input[name="ikasle-id"]').val()}).done(function(data){
			classWeekDays = data.trim().split('');
			//events.data.ikasleId = $('.search-box input[name="ikasle-id"]').val();
			$('#calendar').fullCalendar('removeEventSource', fetchEventsFunction);
			$('#calendar').fullCalendar('addEventSource', fetchEventsFunction);
			//$('#calendar').fullCalendar('refetchEvents');
		});
	});
	
	
	$(document).on("click", "button[name='search']", function(e){
		$.post("ajax_asteko_egunak.php?asteko_egunak", {ikasleId: $('.search-box input[name="ikasle-id"]').val()}).done(function(data){
			classWeekDays = data.trim().split('');
          	//events.data.ikasleId = $('.search-box input[name="ikasle-id"]').val();
			$('#calendar').fullCalendar('removeEventSource', fetchEventsFunction);
			$('#calendar').fullCalendar('addEventSource', fetchEventsFunction);
			//$('#calendar').fullCalendar('refetchEvents');
        });

	});
});

</script>

<style>

  body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #top {
    background: #eee;
    border-bottom: 1px solid #ddd;
    padding: 0 10px;
    line-height: 40px;
    font-size: 12px;
  }

  #calendar {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 10px;
  }

</style>
<div class="container"> 
    <div class="search-box">
        <input type="text" name="ikasle" autocomplete="off" placeholder="Ikaslea..." />
        <div class="result"></div><input type='hidden' name='ikasle-id' value="0" class='form-control'>
    </div>
	<div style="display:inline-block;">
		<button name="search" class="btn btn-default" onclick="">Bilatu</button>
		<button name="clean" class="btn btn-default" onclick="">Garbitu</button>
	</div>
</div>
<span style="visibility: hidden" id="showModalSpan" class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#showDetailsModalCenter" ></span>
<div class="modal fade" id="showDetailsModalCenter" tabindex="-1" role="dialog" aria-labelledby="showDetailsModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="showDetailsModalLongTitle">Xehetasunak: </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
				  
				  
				  
				  
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
<div class="response"></div>
<div id='calendar'></div>
	
	
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