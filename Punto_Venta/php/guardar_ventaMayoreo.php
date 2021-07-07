<?php
	include "./conexion.php";

	$numventa = $_POST['numventa'];
	$fecha = $_POST['fecha'];
	$kilos = $_POST['kilos'];
	$total = $_POST['total'];
	$id_user = $_POST['id_user'];
	$nomcliente = $_POST['nomcliente'];
	$tipodepago = $_POST['tipodepago'];

	$selectCaja = mysqli_query($con, "Select monto_contenido, limite from caja where id_user = $id_user");
	if($datosCaja = mysqli_fetch_array($selectCaja)) {
		$monto_contenido = $datosCaja['monto_contenido'];
		$limite = $datosCaja['limite'];
	}

	if($tipodepago == "Efectivo" && $monto_contenido >= $limite) {
		echo "No se puede realizar esta venta, se ha llegado al limite de efectivo.";
	}
	else {
		$ventaMayoreo = mysqli_query($con, "Insert into venta_mayoreo values(null, $numventa, '$fecha', '00:00', '$kilos', '$nomcliente', '$tipodepago', '$total', $id_user)");
		if(!$ventaMayoreo) {
			echo " No se ha podido registrar la venta. ".mysqli_error($con);
		}
		else {
			echo "Se ha registrado correctamente la venta";
		}
	}

	mysqli_close($con);
?>