<?php
	include 'conexion.php';
	$id_materiaP = $_POST['id_materiaP'];
	$consulta = $_POST['consulta'];

	if($consulta == 1)
		$sql = "Select * from materia_prima where id_materiaP = $id_materiaP";
	else if($consulta == 2)
		$sql = "Select * from materia_prima where id_materiaP = (Select id_matP from producto where id_producto = $id_materiaP)";

	$articulo = mysqli_query($con, $sql);

	if($datos_articulo = mysqli_fetch_array($articulo)) {
		$nom_articulo = $datos_articulo['nombre_matP'];
		$stock_art = $datos_articulo['cantidad'];
		$reorden_art = $datos_articulo['pto_reorden'];

		$dt_articulo = array($nom_articulo, $stock_art, $reorden_art);
	}
	echo json_encode($dt_articulo);
	mysqli_close($con);
?>