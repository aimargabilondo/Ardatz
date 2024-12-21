<?php

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "dbpdo";

try
{
	$DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
	$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo $e->getMessage();
}
include_once 'class.irakasle.crud.php';
include_once 'class.ikasle.crud.php';
include_once 'class.egunerokoa.crud.php';
include_once 'class.charts.crud.php';
include_once 'class.defaults.crud.php';
include_once 'class.remesa.crud.php';
include_once 'class.events.crud.php';
include_once 'class.materiala.crud.php';



$irakasleCrud = new IrakasleCrud($DB_con);
$ikasleCrud = new IkasleCrud($DB_con);
$egunerokoaCrud = new EgunerokoaCrud($DB_con);
$chartsCrud = new ChartsCrud($DB_con);
$defaultsCrud = new DefaultsCrud($DB_con);
$remesaCrud = new RemesaCrud($DB_con);
$eventsCrud = new EventsCrud($DB_con);
$materialaCrud = new materialaCrud($DB_con);
include_once 'hash.php';

?>
