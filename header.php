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


	<?php
	if(isset($_SESSION['valid'])) {					
	?>			
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
				<!-- <div class="navbar-header">
					<a href="http://www.ardatz.net"><img src="ardatz_goiburua.jpg"  width="135" height="50"></a>   HEADER WITH ARDATZ LOGO
				</div> />-->
				<div class="navbar-header">
				  <a class="navbar-brand" href="http://www.ardatz.net">Ardatz</a>
				</div>

				<ul class="nav navbar-nav">
				  <li class="active"><a href="index.php">Home</a></li>
				<?php
				if($_SESSION['id'] == 0){
				?>
				  <li class="dropdown"><a href="irakasle_view.php">Irakasleak</a></li>
				<?php		
				}
				?>
				  <li><a href="ikasle_view.php">Ikasleak</a></li>
				  <li><a href="materialak.php">Materialak</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				<?php
				if($_SESSION['id'] == 0){
				?>
				  <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['name'] ?></a></li>
				<?php		
				}
				?>
				<?php
				if($_SESSION['id'] != 0){
				?>
				  <li><a href="irakasle_user.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['name'] ?></a></li>
				<?php		
				}
				?>				
				  <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Itxi saioa</a></li>
				</ul>
			  </div>
			</nav>
	<?php	
	} else {
	?>
		
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
				<div class="navbar-header">
				  <a class="navbar-brand" href="http://www.ardatz.net">Ardatz</a>
				</div>
				<ul class="nav navbar-nav navbar-right">
				  <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
				</ul>
			  </div>
			</nav>
	<?php
	}
	?>

</br>