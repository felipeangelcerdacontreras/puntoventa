<?php
	//Conexión a la base de datos del servidor.
	$host = "localhost"; 
	$user = "root"; 
	$pass = ""; 
	$bd = "punto_venta"; 
	$con = mysqli_connect($host, $user, $pass, $bd);
	if(!$con){
		$ret['error'] = mysqli_error($con);
		die(json_encode($ret));
	}
	// mysqli_select_db($con, $bd);
?>