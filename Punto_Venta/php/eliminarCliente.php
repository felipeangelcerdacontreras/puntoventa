<?php
	include "./conexion.php";

	$id_clientes = $_POST['id_clientes'];

	$eliminado = 0;
	mysqli_query($con, "SET foreign_key_checks = 0");
	foreach($id_clientes as $id_cliente) {
		$delCliente = mysqli_query($con, "Delete from cliente where id_cliente = $id_cliente");
		if($delCliente)
			$eliminado++;
	}
	mysqli_query($con, "SET foreign_key_checks = 1");
	echo $eliminado." clientes se han eliminado correctamente.";

	mysqli_close($con);
?>