<?php
	//Conexión a la base de datos del servidor.
	$host = "localhost";
	$user = "root";
	$pass = "";
	$bd = "aleman";
	$con2 = mysqli_connect($host, $user, $pass, $bd);
	if(!$con2){
		$ret['error'] = mysqli_error($con2);
		die(json_encode($ret));
	}
	// mysqli_select_db($con, $bd);
?>
