<?php
	include 'conexion.php';

	$usuarios = $_POST['usuarios'];
	$limite = $_POST['limite'];
	$minimo = $_POST['minimo'];

	$updateCaja = mysqli_query($con, "INSERT INTO caja (`id_caja`,`id_user`,`monto_contenido`,`limite`,`minimo`) VALUES (NULL,$usuarios,$minimo,$limite,$minimo)");
	if($updateCaja) {
		echo "Se han guardado correctamente los datos";
	}
	else {
		echo "Error al guardar los datos ".mysqli_error($con);
	}

	mysqli_close($con);
?>