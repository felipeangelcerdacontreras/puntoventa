<?php
	include 'conexion.php';

	$id_articulos = $_POST['id_articulo'];

	$eliminado = 0;
	foreach($id_articulos as $id_articulo) {
		$delInventario = mysqli_query($con, "Delete from inventario where id_articulo = $id_articulo");
		
		$delArticulo = mysqli_query($con, "Delete from articulo where id_articulo = $id_articulo");
		if($delArticulo)
			$eliminado++;
		// mysql_query("SET foreign_key_checks = 0");

		// mysql_query("SET foreign_key_checks = 1");
		// echo mysqli_error($con);
	}
	echo $eliminado." articulos se han eliminado correctamente.";

	mysqli_close($con);
?>