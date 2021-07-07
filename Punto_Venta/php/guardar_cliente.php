<?php
	include 'conexion.php';

	$id_cliente = $_POST["id_cliente"];
	$rfc_cliente = $_POST["rfc_cliente"];
	$nom_cliente = $_POST["nom_cliente"];
	$calle_cliente = $_POST["calle_cliente"];
	$noExt_cliente = $_POST["noExt_cliente"];
	$col_cliente = $_POST["col_cliente"];
	$municipio_cliente = $_POST["municipio_cliente"];
	$edo_cliente = $_POST["edo_cliente"];
	$pais_cliente = $_POST["pais_cliente"];
	$cp_cliente = $_POST["cp_cliente"];
	$res = array();

	if($id_cliente == "") {
		$insertaCliente = mysqli_query($con, "Insert into cliente values(null, '$rfc_cliente', '$nom_cliente', '$calle_cliente', '$noExt_cliente', '$col_cliente', '$municipio_cliente', '$edo_cliente', '$pais_cliente', '$cp_cliente')");
		if(!$insertaCliente) {
			$res["status"] = false;
			$res["res"] = " No se ha podido guardar el cliente. ".mysqli_error($con);
		}
		else {
			$idCliente = mysqli_insert_id($con);
			$res["id_cliente"] = $idCliente;
			$res["status"] = true;
			$res["res"] = " Cliente insertado correctamente.";
		}
		echo json_encode($res);
	}
	else {
		$updateCliente = mysqli_query($con, "Update cliente set rfc_cliente = '$rfc_cliente', nombre_cliente = '$nom_cliente', calle_cliente = '$calle_cliente', noExt_cliente = '$noExt_cliente', col_cliente = '$col_cliente', municipio_cliente = '$municipio_cliente', edo_cliente = '$edo_cliente', pais_cliente = '$pais_cliente', cp_cliente = '$cp_cliente' where id_cliente = $id_cliente");
		if(!$updateCliente) {
			echo " No se han podido actualizar los datos del cliente. ".mysqli_error($con);
		}
		else {
			echo "Se han actualizado correctamente los datos del cliente";
		}
	}
	mysqli_close($con);
?>