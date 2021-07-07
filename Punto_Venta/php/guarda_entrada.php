<?php
	include 'conexion.php';

	$id_art = $_POST["id_articulo"];
	$cantidad = $_POST["cantidad"];

	date_default_timezone_set('America/Mexico_City');
	$fecha = date("Y-m-d H:i:s");
    
    $insertEntrada = mysqli_query($con, "Insert into entradas_MATPRIM values(null, $id_art, '$fecha', $cantidad)");
	echo mysqli_error($con);
	if(!$insertEntrada) {
		echo " No se ha podido registrar la entrada. ".mysqli_error($con);
	}
	else {
		$updateArticulo = mysqli_query($con, "Update materia_prima set cantidad = cantidad + $cantidad where id_materiaP = '$id_art'");
		echo "Se ha registrado correctamente la entrada";
	}

	mysqli_close($con);
?>