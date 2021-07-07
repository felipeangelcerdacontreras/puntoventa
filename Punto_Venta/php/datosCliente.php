<?php
	include 'conexion.php';
	$id_cliente = $_POST['id_cliente'];

	$cliente = mysqli_query($con, "Select * from cliente where id_cliente = $id_cliente");
	if($datos_cliente = mysqli_fetch_array($cliente)) {
		$id_cliente = $datos_cliente["id_cliente"];
		$rfc_cliente = $datos_cliente["rfc_cliente"];
		$nom_cliente = $datos_cliente["nombre_cliente"];
		$calle_cliente = $datos_cliente["calle_cliente"];
		$noExt_cliente = $datos_cliente["noExt_cliente"];
		$col_cliente = $datos_cliente["col_cliente"];
		$municipio_cliente = $datos_cliente["municipio_cliente"];
		$edo_cliente = $datos_cliente["edo_cliente"];
		$pais_cliente = $datos_cliente["pais_cliente"];
		$cp_cliente = $datos_cliente["cp_cliente"];

		$dt_cliente = array($rfc_cliente, $nom_cliente, $calle_cliente, $noExt_cliente, $col_cliente, $municipio_cliente, $edo_cliente, $pais_cliente, $cp_cliente);
	}
	echo json_encode($dt_cliente);
	mysqli_close($con);
?>