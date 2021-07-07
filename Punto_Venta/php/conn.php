<?php
	//coneccion a la bd
	$host="localhost"; 
	$user="localhost"; 
	$pass=""; 
	$bd="prodika_punto_venta"; 
	$con = mysql_connect($host, $user, $pass);
	if(!$con){
		$ret['error'] = mysql_error($con);
		die(json_encode($ret));
	}
	mysql_select_db($bd, $con);
?>