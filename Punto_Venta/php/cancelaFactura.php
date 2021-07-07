<?php
	include 'conexion.php';
	include('libFactura.php');
	include('emisor.php');

	$id_xml = $_POST['id_xml'];

	$xml = mysqli_query($con, "Select uuid, cancelada from xml where id = $id_xml");

	if($datos_xml = mysqli_fetch_array($xml)) {
		$uuid = $datos_xml['uuid'];
		$cancelada = $datos_xml['cancelada'];

		if($cancelada == 1) {
			echo "La factura ya ha sido cancelada o se encuentra en proceso de cancelación.";
		}
		else {
			$parametros = array('emisorRFC'=>$rfc_emisor, 'UserID'=>$user_id, 'UserPass'=>$user_password);
			$cliente = new FacturacionModerna($url_timbrado, $parametros, 0);
			$opciones = null;

			if($cliente->cancelar($uuid, $opciones)) {
				$updateXML = mysqli_query($con, "Update xml set cancelada = 1 where id = $id_xml");
				if($updateXML)
					echo "Cancelación exitosa\n";
				else
					echo "Error al actualizar el archivo";
			}
			else {
				echo "[".$cliente->ultimoCodigoError."] - ".$cliente->ultimoError."\n";
			}
		}
	}
	mysqli_close($con);
?>