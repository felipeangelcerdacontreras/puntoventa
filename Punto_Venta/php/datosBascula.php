<?php
	include 'conexion.php';

	$peso = mysqli_query($con, "Select kilos from peso where id_peso = (Select max(id_peso) from peso)");

	if($maxPeso = mysqli_fetch_array($peso)) {
		$kilos = $maxPeso["kilos"];

	    $resultado = str_replace("kg", "", $kilos);
		$dt_peso = array($resultado);
	}
	echo json_encode($dt_peso);
	mysqli_close($con);
?>