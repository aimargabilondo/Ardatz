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

	
	
	$(document).on("click", "button[name='clean']", function(e){
		$('.search-box input[name="ikasle"]').val('');
		$('.search-box input[name="ikasle-id"]').val('');
		$('.search-box input[name="ikastetxe"]').val('');
		$('.search-box input[name="ikastetxe-id"]').val('');
		$('.search-box input[name="maila"]').val('');
		$('.search-box input[name="maila-id"]').val('');
		$('button[name="search"]').click();
	});
	
	
	$(document).on("click", "button[name='search']", function(e){
		
		var ikasleId = $('.search-box input[name="ikasle-id"]').val();
		var ikastetxeId = $('.search-box input[name="ikastetxe-id"]').val();
		var mailaId = $('.search-box input[name="maila-id"]').val();
		var resultTable = document.getElementById("values_table");
		$.post("ajax_search.php?search-ikasle-klase-egunak", {
													 ikasle_id: ikasleId,
													 ikastetxe_id: ikastetxeId,
													 maila_id: mailaId
													}).done(function(data){
			// Display the returned data in browser
			resultTable.innerHTML = data;
			$('input[type="checkbox"]').unbind('change');
			$('input[type="checkbox"]').change(checkboxChangeEventFunction);
		});
		
	});
	
	function checkboxChangeEventFunction() {
		var checkbox_name = this.name; //name='ikasle_klase_eguna-1-asteartea'
		var array = checkbox_name.split("-"); 
		var ikasleId = array[1];
		
		var astelehena = ($('input[name="ikasle_klase_eguna-' + ikasleId + '-astelehena"]').is(':checked'))?'1':'0';
		var asteartea = ($('input[name="ikasle_klase_eguna-' + ikasleId + '-asteartea"]').is(':checked'))?'1':'0';
		var asteazkena = ($('input[name="ikasle_klase_eguna-' + ikasleId + '-asteazkena"]').is(':checked'))?'1':'0';
		var osteguna = ($('input[name="ikasle_klase_eguna-' + ikasleId + '-osteguna"]').is(':checked'))?'1':'0';
		var ostirala = ($('input[name="ikasle_klase_eguna-' + ikasleId + '-ostirala"]').is(':checked'))?'1':'0';
		var larunbata = ($('input[name="ikasle_klase_eguna-' + ikasleId + '-larunbata"]').is(':checked'))?'1':'0';
		var igandea = ($('input[name="ikasle_klase_eguna-' + ikasleId + '-igandea"]').is(':checked'))?'1':'0';
		var egunak = '' + astelehena + '' + asteartea + '' + asteazkena + '' + osteguna + '' + ostirala + '' + larunbata + '' + igandea;
		
		$.post("ajax_asteko_egunak.php?alter_days", {ikaslea_id: ikasleId, egunak: egunak}).done(function(data){
			// Display the returned data in browser
			if(data.includes('0')){
				this.checked = false;
			}else{
				this.checked = true;
			}
		});
	}
	$('input[type="checkbox"]').change(checkboxChangeEventFunction);
});