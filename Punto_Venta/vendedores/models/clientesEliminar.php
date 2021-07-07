<?php
	include '../db/conexion.php';

    $id_cliente  = $_POST['id_cliente'];

	$sql  = "DELETE FROM clientes_vendedor WHERE id_cliente = '$id_cliente'";

	if(mysqli_query($con,$sql)) {
		echo '1';
	}
	else {
		echo '2';
	}
	mysqli_close($con);
?>
