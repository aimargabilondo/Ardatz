

function getDateTime() {
        var now     = new Date(); 
        var year    = now.getFullYear();
        var month   = now.getMonth()+1; 
        var day     = now.getDate();
        var hour    = now.getHours();
        var minute  = now.getMinutes();
        var second  = now.getSeconds(); 
        if(month.toString().length == 1) {
             month = '0'+month;
        }
        if(day.toString().length == 1) {
             day = '0'+day;
        }   
        if(hour.toString().length == 1) {
             hour = '0'+hour;
        }
        if(minute.toString().length == 1) {
             minute = '0'+minute;
        }
        if(second.toString().length == 1) {
             second = '0'+second;
        }   
        var dateTime = year+'-'+month+'-'+day+' '+hour+'-'+minute+'-'+second;   
         return dateTime;
    }

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
	
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
		  event.preventDefault();
		  return false;
		}
	});
	
	
	
	// Set search input value on click of result item
    $(document.body).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
		$(this).parents(".search-box").find('input[type="hidden"]').val($(this).attr("id"));
        $(this).parent(".result").empty();
    });
	
	/*$(document).on('click', function (e) {
		if ($(e.target).closest(".ikasle, .ikasgai").length == 0) {
			$(".result").empty();
		}
	});*/
	
	$(document).on("click", "button[name='btn-export']", function(e){
		e.preventDefault();
		
		var ikasleId = $('.search-box input[name="ikasle-id"]').val();
		var ikastetxeId = $('.search-box input[name="ikastetxe-id"]').val();
		var mailaId = $('.search-box input[name="maila-id"]').val();
		var egoera = $('input:radio[name=estado]:checked').val();
		//var resultTable = document.getElementById("values_table");
		/*$.post("export_data.php?ikasle-zerrenda", {
													 ikasle_id: ikasleId,
													 ikastetxe_id: ikastetxeId,
													 maila_id: mailaId,
													 egoera: egoera
													}).done(function(data){
			// Display the returned data in browser

		})
		.fail(function(data) {

		});*/

		$.ajax({
			async:true,
			type:"POST",
			dataType:"html",//html
			contentType:"application/x-www-form-urlencoded",
			url:"export_data.php?ikasle-zerrenda",
			data:{
				 ikasle_id: ikasleId,
				 ikastetxe_id: ikastetxeId,
				 maila_id: mailaId,
				 egoera: egoera
			},
			beforeSend: function(){
				$('button[name="btn-export"]').prop('disabled', true);;
				$("#loader").attr("style", "display:inline");
				$("#loader").show();
			},
			success:function(data){
				var opResult = JSON.parse(data);
				var $a=$("<a>");
				$a.attr("href",opResult.data);
				$("body").append($a);
				$a.attr("download","Ikasle_zerrenda_" + getDateTime() + ".xlsx");
				$a[0].click();
				$a.remove();				
			},
			fail:function(data){
				alert(data);
			},
			complete:function(data){
				// Hide image container
				$("#loader").hide();
				$('button[name="btn-export"]').prop('disabled', false);;
			}
		});
		
		/*$.ajax({
			async:true,
			type:"POST",
			dataType:"html",//html
			contentType:"application/x-www-form-urlencoded",
			url:"export_data.php?ikasle-zerrenda",
			data:{
				 ikasle_id: ikasleId,
				 ikastetxe_id: ikastetxeId,
				 maila_id: mailaId,
				 egoera: egoera
			},
			beforeSend: function(){},
			success:function(data){
				 window.location=data.url;
				
			},
			fail:function(data){
				alert(data);
			}
		});*/
	});
	
	
	
	
	$(document).on("click", "button[name='clean']", function(e){
		$('.search-box input[name="ikasle"]').val('');
		$('.search-box input[name="ikasle-id"]').val('');
		$('.search-box input[name="ikastetxe"]').val('');
		$('.search-box input[name="ikastetxe-id"]').val('');
		$('.search-box input[name="maila"]').val('');
		$('.search-box input[name="maila-id"]').val('');
		$("input[name='estado'][value='2']").prop('checked', true);
		$('button[name="search"]').click();
	});
	
	
	$(document).on("click", "button[name='search']", function(e){
		
		var ikasleId = $('.search-box input[name="ikasle-id"]').val();
		var ikastetxeId = $('.search-box input[name="ikastetxe-id"]').val();
		var mailaId = $('.search-box input[name="maila-id"]').val();
		var egoera = $('input:radio[name=estado]:checked').val();
		var resultTable = document.getElementById("values_table");
		$.post("ajax_search.php?search-ikasle", {
													 ikasle_id: ikasleId,
													 ikastetxe_id: ikastetxeId,
													 maila_id: mailaId,
													 egoera: egoera
													}).done(function(data){
			// Display the returned data in browser
			resultTable.innerHTML = data;
		});
		
	});
});