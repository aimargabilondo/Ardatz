<?php session_start(); 
	
?>
<?php include_once 'dbconfig.php'; ?> <!--inclure de l'instance de la class crud-->
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



</head>
<body oncontextmenu="return false">
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
				<div class="navbar-header">
				  <a class="navbar-brand" href="http://www.ardatz.net">Ardatz</a>
				</div>
			  </div>
			</nav>
<br></br><br></br><br></br><br></br>
<?php
$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

function encryptthis($data, $key) {

$encryption_key = base64_decode($key);

$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(‘aes-256-cbc’));

$encrypted = openssl_encrypt($data, ‘aes-256-cbc’, $encryption_key, 0, $iv);

return base64_encode($encrypted . ‘::’ . $iv);

}
?> 


<?php 
$error = '';
	
if(isset($_POST['submit'])) {
	$user = addslashes($_POST['user']);
	$pass = addslashes($_POST['pass']);



	if($user == "" || $pass == "" ) {
		$error = "Either username or password field is empty.";
	} else {
		$passHash = Password::hash($pass);
		//echo $passHash;
		$stmt = $DB_con->query("SELECT * FROM tbl_irakasle WHERE username='$user' AND password='$passHash' LIMIT 1");
		$row = $stmt->fetch();
		if(!empty($row)) {
			if($row['active'] == "1" || $row['username'] == "admin"){
				$_SESSION['valid'] = 1;
				$_SESSION['name'] = $row['first_name'];
				$_SESSION['id'] = $row['id'];
				
			}else{
				$error = $error." Inactive user.";
			}
			
		} else {
			$error = $error." Invalid username or password.";
		}

		if(isset($_SESSION['valid'])) {
			header('Location: index.php');			
		}
	}
}else{
	
}
?>
	
<div class="login-card">
    <h1>Log-in</h1><br>
  <form name="form1" method="post" action="login.php">
    <input type="text" name="user" placeholder="Username" value="">
    <input type="password" name="pass" placeholder="Password" value="">
    <input type="submit" name="submit" class="login login-submit" value="login">
  </form>

  <div class="login-help">
    <?php echo $error; ?>
  </div>
</div>


</body>
</html>
