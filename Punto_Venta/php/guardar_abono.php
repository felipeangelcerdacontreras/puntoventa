<?php
	include 'conexion.php';

	$numventa = $_POST['numventa'];
	$abono = $_POST['abono'];
	$id_user = $_POST['id_user'];

	date_default_timezone_set('America/Mexico_City');
	$fecha = date('Y-m-d');

	$abono = mysqli_query($con, "Insert into abonos values(null, '$numventa', '$fecha', '$id_user', '$abono')");
	if(!$abono) {
		echo " No se ha podido registrar el abono. ".mysqli_error($con);
	}
	else {
		echo "Se ha registrado correctamente el abono";
	}

	mysqli_close($con);
?>