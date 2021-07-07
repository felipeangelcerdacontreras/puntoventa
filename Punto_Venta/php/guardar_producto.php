<?php
	include 'conexion.php';

	$nom_producto = $_POST["nom_producto"];
	$clave_producto = $_POST["clave_producto"];
	$precio_producto = $_POST["precio_producto"];
	$id_producto = $_POST["id_producto"];
	$id_matP = $_POST["id_matP"];
	$u_medida = $_POST["u_medida"];
	

	if($id_producto == "") {
		$insertaProducto= mysqli_query($con, "Insert into producto values(null, '$id_matP', '$clave_producto', '$nom_producto', '$precio_producto', '$u_medida',NULL)");
		if(!$insertaProducto) {
			echo " No se ha podido guardar el producto. ".mysqli_error($con);
		}
		else {
			echo "Se ha guardado correctamente el producto.";
		}
	}
	else {
		$updateProducto = mysqli_query($con, "Update producto set nombre = '$nom_producto', clave = '$clave_producto', precio_unitario = '$precio_producto', id_matP = '$id_matP', unidad_medida = '$u_medida' where id_producto = '$id_producto'");
		if(!$updateProducto) {
			echo " No se ha podido actualizar el producto. ".mysqli_error($con);
		}
		else {
			echo "Se ha actualizado correctamente el producto.";
		}
	}
	mysqli_close($con);
?>