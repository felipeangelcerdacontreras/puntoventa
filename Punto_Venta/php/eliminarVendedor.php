<?php
	include 'conexion.php';

    $id_vendedor  = $_POST['id_vendedor'];

	$sql  = "DELETE FROM datos_vendedores WHERE id_vendedor = '$id_vendedor'";
	$sql2 = "DELETE FROM vendedores WHERE id_datos = '$id_vendedor'";

	if(mysqli_query($con,$sql) && mysqli_query($con, $sql2)) {
		echo '1';
	}
	else {
		echo '2';
	}
	mysqli_close($con);
?>