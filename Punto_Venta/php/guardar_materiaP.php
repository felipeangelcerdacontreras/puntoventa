<?php
	include 'conexion.php';

	$nom_materiaP = $_POST["nom_materiaP"];
	$stock_materiaP = $_POST["stock_materiaP"];
	$reorden_materiaP = $_POST["reorden_materiaP"];
	$categoria_materiaP = $_POST["categoria_materiaP"];
	$id_materiaP = $_POST["id_materiaP"];
	$fecha_materiaP = date("Y-m-d H:i:s");


	if($id_materiaP == "") {
		$insertaArticulo = mysqli_query($con, "Insert into materia_prima values(null, '$nom_materiaP', '$stock_materiaP', '$reorden_materiaP','$categoria_materiaP', '$fecha_materiaP',NULL)");
		print_r("Insert into materia_prima values(null, '$nom_materiaP', '$stock_materiaP', '$reorden_materiaP','$categoria_materiaP', '$fecha_materiaP',NULL)");
		if(!$insertaArticulo) {
			echo " No se ha podido guardar la materia prima. ".mysqli_error($con);
		}
		else {
			echo "Se ha guardado correctamente la materia prima.";
		}
	}
	else {
		$updateArticulo = mysqli_query($con, "Update materia_prima set nombre_matP = '$nom_materiaP', pto_reorden = '$reorden_materiaP', cantidad = '$stock_materiaP', categoria= '$categoria_materiaP' where id_materiaP = '$id_materiaP'");
		if(!$updateArticulo) {
			echo " No se ha podido actualizar la materia prima. ".mysqli_error($con);
		}
		else {
			echo "Se ha actualizado correctamente la materia prima.";
		}
	}
	mysqli_close($con);
?>