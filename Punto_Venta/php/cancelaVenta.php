<?php
	include 'conexion.php';
	include('libFactura.php');
	include('emisor.php');

	$id_venta = $_POST['id_venta'];

	$articulos = mysqli_query($con, "Select id_articulo, cantidad from venta_detalle where id_venta = $id_venta");
	while ($articulo = mysqli_fetch_array($articulos)) {
		$id_articulo = $articulo['id_articulo'];
		$cantidad = $articulo['cantidad'];

		mysqli_query($con, "Update materia_prima set cantidad = cantidad + $cantidad where id_materiaP = (Select id_matP from producto where id_producto = $id_articulo)");
	}

	$datosVenta = mysqli_query($con, "Select total,id_user from venta where id_venta = $id_venta");
	while ($datosVentas = mysqli_fetch_array($datosVenta)) {
		$total = $datosVentas['total'];
		$id_user = $datosVentas['id_user'];
	}

	$xml = mysqli_query($con, "Select uuid from xml where id_venta = $id_venta");

	if($datos_xml = mysqli_fetch_array($xml)) {
		$uuid = $datos_xml['uuid'];

		$parametros = array('emisorRFC'=>$rfc_emisor, 'UserID'=>$user_id, 'UserPass'=>$user_password);
		$cliente = new FacturacionModerna($url_timbrado, $parametros, 0);
		$opciones = null;

		if($cliente->cancelar($uuid, $opciones)) {
			$updateXML = mysqli_query($con, "Update xml, venta set cancelada = 1, venta_cancelada = 1 where xml.id_venta = $id_venta and venta.id_venta = $id_venta");
			if($updateXML)
				echo "Cancelación exitosa\n";
			else
				echo "Error al actualizar el archivo";
		}
		else {
			echo "[".$cliente->ultimoCodigoError."] - ".$cliente->ultimoError."\n";
		}
	}
	else {
		$updateXML = mysqli_query($con, "Update venta set venta_cancelada = 1 where venta.id_venta = $id_venta");
		if($updateXML)
		{
			$updateCaja = mysqli_query($con, "Update caja set monto_contenido = monto_contenido-$total where id_user = $id_user");//update para caja que regrese la cantidad
		    if ($updateCaja) {
		        echo "Cancelación exitosa\n";
		    }
		    else{
                echo "Cancelación Erronea.\n";
		    }
		}
		else
		{
			echo "Error al actualizar el archivo";
		}
	}
	mysqli_close($con);
?>