<script type="text/javascript">
$(document).ready(function(){  
       function check_session()
       {
          $.ajax({
            url:"check_session.php",
            method:"POST",
            success:function(data)
            {
              if(data == '1')
              {
                alert('Your session has been expired!');  
                window.location.href="login.php";
              }
            }
          })
       }
        setInterval(function(){
          check_session();
        }, 10000);  //10000 means 10 seconds
 }); 
</script>