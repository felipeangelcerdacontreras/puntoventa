<?php
	session_start();
	include_once('conexion.php');

	date_default_timezone_set('America/Mexico_City');
	$user_sesion = $_SESSION['id'];
	$fecha = date("Y-m-d H:i:s");

	$cant_retirar = $_POST['cant_retirar'];
	$codigo_aut = $_POST['codigo_aut'];

	$verificaCodigo = mysqli_query($con, "Select codigo_cancelar from usuarios where codigo_cancelar = '$codigo_aut' and tipo = 'Administrador'");
	if($existe = mysqli_fetch_array($verificaCodigo)) {
		$verifica = mysqli_query($con, "Select monto_contenido, id_caja, minimo from caja where id_user = $user_sesion");
		while ($row = mysqli_fetch_array($verifica)) {
			$monto = $row['monto_contenido'];
			$minimo = $row['minimo'];
			$id_caja = $row['id_caja'];
		}

		if($monto < $cant_retirar) {
			echo "No hay fondos suficientes en la caja.";
		}
		else if(($monto - $minimo) < $cant_retirar) {
			echo "No puede retirar dicha cantidad, deben existir $".$minimo." en caja.";
		}
		else {
			$updateCaja = mysqli_query($con, "Update caja set monto_contenido = monto_contenido - $cant_retirar where id_caja = $id_caja");
			if($updateCaja) {
				$insertRetiro = mysqli_query($con, "Insert into retiros values(null, $id_caja, '$fecha', $cant_retirar)");
				if($insertRetiro) {
					echo "Se ha realizado el retiro correctamente";
				}
				else {
					echo "No se pudo realizar el retiro de caja. ".mysqli_error($con);
				}
			}
			else {
				echo "No se pudo realizar el retiro. ".mysqli_error($con);
			}
		}
	}
	else {
		echo "El codigo de autorizacion no es correcto";
	}

	mysqli_close($con);
?>