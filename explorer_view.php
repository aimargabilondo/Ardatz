<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {			
	include_once 'dbconfig.php';
	include_once 'header.php';
	define('FM_EMBED', true);
	define('FM_SELF_URL', $_SERVER['PHP_SELF']);
?>


<div style="margin:20px;" class="container"> 
	<iframe src="/explorer/explorer.php" width="100%" height="100%" scrolling="yes">
<?php
	//require './explorer/explorer.php';
?>
</div>
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