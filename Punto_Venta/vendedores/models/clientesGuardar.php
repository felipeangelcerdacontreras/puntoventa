<?php
	include '../db/conexion.php';

	$accion = $_POST["accion"];

	if($accion == 1) { // aqui se agrega un nuevo vendedor
		$nombre        = $_POST["nombre"];
		$calle         = $_POST["calle"];
		$colonia       = $_POST["colonia"];
		$codigo_postal = $_POST["codigo_postal"];
		$telefono      = $_POST["telefono"];
		$celular       = $_POST["celular"];
		$rfc           = $_POST["rfc"];
		$no_exterior   = $_POST["no_exterior"];
		$no_interior   = $_POST["no_interior"];
		$municipio     = $_POST["municipio"];
		$estado        = $_POST["estado"];

		$insertarDatosCliente = mysqli_query($con, "INSERT INTO clientes_vendedor VALUES(null, '$nombre', '$calle', '$colonia', '$codigo_postal', '$telefono', '$celular','$rfc ','$no_exterior','$no_interior','$municipio','$estado')");


		if(!$insertarDatosCliente) {
			echo "No se ha podido guardar el cliente. ".mysqli_error($con);
		}else {
			echo "Cliente agregado correctamente";
		}

	}
	else if($accion == 2) { // aqui se actualiza un nuevo vendedor

		$id_cliente    = $_POST["id_cliente"];
		$nombre        = $_POST["nombre"];
		$calle         = $_POST["calle"];
		$colonia       = $_POST["colonia"];
		$codigo_postal = $_POST["codigo_postal"];
		$telefono      = $_POST["telefono"];
		$celular       = $_POST["celular"];
		$rfc           = $_POST["rfc"];
		$no_exterior   = $_POST["no_exterior"];
		$no_interior   = $_POST["no_interior"];
		$municipio     = $_POST["municipio"];
		$estado        = $_POST["estado"];

		$actualizarDatosCliente = mysqli_query($con, "UPDATE clientes_vendedor SET nombre='$nombre', calle='$calle', colonia='$colonia', codigo_postal='$codigo_postal', telefono='$telefono', celular='$celular',rfc='$rfc',no_exterior='$no_exterior',no_interior='$no_interior',municipio='$municipio',estado='$estado' WHERE id_cliente = '$id_cliente' ");

		if(!$actualizarDatosCliente) {
			echo "No se pudieron actualizar los datos ".mysqli_error($con);
		}
		else {
			echo "Cliente actualizado correctamente.";
		}
	}
	else if($accion == 3) { // manda los datos a un modal para modificar al vendedor seleccionado
		$id_cliente = $_POST["id_cliente"];
		//echo $id;
		$datos_clientes = mysqli_query($con, "SELECT * FROM clientes_vendedor WHERE id_cliente = '$id_cliente'");

		if($clientes = mysqli_fetch_array($datos_clientes)) {
			$nombre        = $clientes['nombre'];
			$calle         = $clientes['calle'];
	    $colonia       = $clientes['colonia'];
	    $codigo_postal = $clientes['codigo_postal'];
			$telefono      = $clientes['telefono'];
			$celular       = $clientes['celular'];
	    $rfc           = $clientes['rfc'];
			$no_exterior   = $clientes['no_exterior'];
			$no_interior   = $clientes['no_interior'];
	    $municipio     = $clientes['municipio'];
			$estado        = $clientes['estado'];

			$datos = array($nombre, $calle,$colonia,$codigo_postal,$telefono, $celular,$rfc ,$no_exterior,$no_interior,$municipio,$estado);
			echo json_encode($datos);
		}
	}
	mysqli_close($con);
?>
