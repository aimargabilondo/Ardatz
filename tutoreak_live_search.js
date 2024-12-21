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
		$('.search-box input[name="irakasle"]').val('');
		$('.search-box input[name="irakasle-id"]').val('');
		$('button[name="search"]').click();
	});
	
	
	$(document).on("click", "button[name='search']", function(e){
		
		var ikasleId = $('.search-box input[name="ikasle-id"]').val();
		var irakasleId = $('.search-box input[name="irakasle-id"]').val();
		var resultTable = document.getElementById("values_table");
		$.post("ajax_search.php?search-tutoreak", {
													 ikasle_id: ikasleId,
													 irakasle_id: irakasleId
													}).done(function(data){
			// Display the returned data in browser
			resultTable.innerHTML = data;
			$('input[type="checkbox"]').unbind('change');
			$('input[type="checkbox"]').change(checkboxChangeEventFunction);
		});
		
	});
	
	function checkboxChangeEventFunction() {
		var checkbox_name = this.name; //name='ikasle_irakasle-0-1'
		var array = checkbox_name.split("-"); 
		var allChecks = $('input[name*="ikasle_irakasle-' + array[1] + '-"]');
		allChecks.each(function( index ) {
		  if($(this).attr("name") != 'ikasle_irakasle-' + array[1] + '-' + array[2]){
			  $(this).prop('checked', false);
		  }
		});
		
		if(this.checked) {
			$.post("ajax_tutoreak.php?check_tutore", {ikaslea_id: array[1], irakaslea_id: array[2]}).done(function(data){
                // Display the returned data in browser
                if(data.includes('0')){
					this.checked = false;
				}else if(data.includes('1')){
					this.checked = true;
				}
            });
		}else{
			$.post("ajax_tutoreak.php?uncheck_tutore", {ikaslea_id: array[1], irakaslea_id: array[2]}).done(function(data){
                // Display the returned data in browser
                if(data.includes('0')){
					this.checked = false;
				}else if(data.includes('1')){
					this.checked = true;
				}
            });
		}
	}
	
	$('input[type="checkbox"]').change(checkboxChangeEventFunction);
});