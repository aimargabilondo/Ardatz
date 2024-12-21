$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultTable = document.getElementById("values_table");
        if(inputVal.length){
            $.post("ajax_search.php?search-irakasle", {irakasle: inputVal}).done(function(data){
                // Display the returned data in browser
                resultTable.innerHTML = data;
            });
        } else{
            $.post("ajax_search.php?search-irakasle", {irakasle: ''}).done(function(data){
                // Display the returned data in browser
                resultTable.innerHTML = data;
            });
        }
    });
});