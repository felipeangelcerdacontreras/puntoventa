<?php
	include "./conexion.php";

	$id_users = $_POST['id_users'];

	mysqli_query($con, "SET foreign_key_checks = 0");
	$delUser = mysqli_query($con, "Delete from usuarios where id_user = $id_users");
	if($delUser) {
		$delDatosUser = mysqli_query($con, "Delete from datos_usuarios where id_user = $id_users");
	}
	mysqli_query($con, "SET foreign_key_checks = 1");
	echo " usuario eliminado correctamente.";

	mysqli_close($con);
?>