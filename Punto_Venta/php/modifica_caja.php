<?php
	include 'conexion.php';

	$id_caja = $_POST['id_caja'];
	$limite_caja = $_POST['limite_caja'];
	$minimo_caja = $_POST['minimo_caja'];

	$updateCaja = mysqli_query($con, "Update caja set limite = $limite_caja, minimo = $minimo_caja where id_caja = $id_caja");
	if($updateCaja) {
		echo "Se han modificado correctamente los datos";
	}
	else {
		echo "Error al modificar los datos ".mysqli_error();
	}

	mysqli_close($con);
?>