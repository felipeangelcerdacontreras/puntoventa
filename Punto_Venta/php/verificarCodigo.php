<?php
	include 'conexion.php';

	$codigo = $_POST['codigo'];

	$verifica = mysqli_query($con, "Select codigo_cancelar from usuarios where codigo_cancelar = '$codigo' and tipo = 'Administrador'");
	if($existe = mysqli_fetch_array($verifica)) {
		echo "Ok";
	}
	else {
		echo "Not";
	}
	echo mysqli_error($con);

	mysqli_close($con);
?>