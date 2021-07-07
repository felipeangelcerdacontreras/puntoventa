<?php
	include 'conexion.php';
	$id_producto = $_POST['id_producto'];

	$producto = mysqli_query($con, "Select * from producto where id_producto = $id_producto");
	if($datos_articulo = mysqli_fetch_array($producto)) {
		$nombre = $datos_articulo['nombre'];
		$id_matP = $datos_articulo['id_matP'];
		$clave = $datos_articulo['clave'];
		$precio_unitario = $datos_articulo['precio_unitario'];
		$u_medida = $datos_articulo['unidad_medida'];

		$dt_producto = array($nombre, $id_matP, $clave, $precio_unitario, $u_medida);
	}
	echo json_encode($dt_producto);
	mysqli_close($con);
?>