<?php
	include 'conexion.php';

	$accion = $_POST["accion"];

	if($accion == 1) { // aqui se agrega un nuevo vendedor
		$nombre_usuario  = $_POST["nombre_usuario"];
		$password        = md5($_POST["password"]);
		$nombre          = $_POST["nombre"];
		$apellidoPaterno = $_POST["apellidoPaterno"];
		$apellidoMaterno = $_POST["apellidoMaterno"];
		$fechaNacimiento = $_POST["fechaNacimiento"];
		$telefono        = $_POST["telefono"];
		$celular         = $_POST["celular"];

		$insertarDatosVendedor = mysqli_query($con, "INSERT INTO datos_vendedores VALUES(null, '$nombre', '$apellidoPaterno', '$apellidoMaterno', '$fechaNacimiento', '$telefono', '$celular')");

		$rs = mysqli_query($con, "SELECT MAX(id_vendedor) AS id FROM datos_vendedores");
		if ($row = mysqli_fetch_array($rs)) {
			$id = $row['id'];
		}

		$insertarVendedor = mysqli_query($con, "INSERT INTO vendedores VALUES(null, '$id', '$nombre_usuario', '$password')");

		if(!$insertarDatosVendedor) {
			echo "No se ha podido guardar el vendedor. ".mysqli_error($con);
		} else if(!$insertarVendedor) {
			echo "No se ha podido guardar el vendedor. ".mysqli_error($con);
		}
		 else {
			echo "Vendedor agregado correctamente.";
		}
	}
	else if($accion == 2) { // aqui se actualiza un nuevo vendedor		
		$id 			 = $_POST["id"];
		$nombre          = $_POST["nombre"];
		$apellidoPaterno = $_POST["apellidoPaterno"];
		$apellidoMaterno = $_POST["apellidoMaterno"];
		$fechaNacimiento = $_POST["fechaNacimiento"];
		$telefono        = $_POST["telefono"];
		$celular         = $_POST["celular"];

		$actualizarDatosVendedor = mysqli_query($con, "UPDATE datos_vendedores SET nombre='$nombre', apellido_paterno='$apellidoPaterno', apellido_materno='$apellidoMaterno', fecha_nacimiento='$fechaNacimiento', telefono='$telefono', celular='$celular' WHERE id_vendedor = $id");

		if(!$actualizarDatosVendedor) {
			echo "No se pudieron actualizar los datos ".mysqli_error($con);
		}
		else {
			echo "Vendedor actualizado correctamente.";
		}
	}
	else if($accion == 3) { // manda los datos a un modal para modificar al vendedor seleccionado
		$id = $_POST["id"];
		//echo $id;
		$datos_vendedores = mysqli_query($con, "SELECT * FROM datos_vendedores WHERE id_vendedor = '$id'");

		if($vendedores = mysqli_fetch_array($datos_vendedores)) {
			$nombre 		 = $vendedores['nombre'];
			$apellidoPaterno = $vendedores['apellido_paterno'];
			$apellidoMaterno = $vendedores['apellido_materno'];
			$fechaNacimiento = $vendedores['fecha_nacimiento'];
			$telefono 		 = $vendedores['telefono'];
			$celular 		 = $vendedores['celular'];

			$datos = array($nombre, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento, $telefono, $celular);
			echo json_encode($datos);			
		}
	}
	mysqli_close($con);
?>