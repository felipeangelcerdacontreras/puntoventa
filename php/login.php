<?php
	session_start();
	include "../db/conexion_1.php";

	$ret = array();
	$ret['error'] = "Usuario y/o Contraseña Incorrecta.";
	$ret['success'] = false;

	$user = $_POST['user'];
	$pass = md5($_POST['pass']);

	$result = mysqli_query($con, "Select usuarios.*, nombre from usuarios inner join datos_usuarios on datos_usuarios.id_user = usuarios.id_user where user = '$user' and pass = '$pass'");
	
	if($usuario = mysqli_fetch_array($result)) {
		$_SESSION['usuario'] = $usuario['user'];
		$_SESSION['logged'] = "OK";
		$_SESSION['id'] = $usuario['id'];
		$_SESSION['tipo'] = $usuario['tipo'];
		$_SESSION['nombre'] = $usuario['nombre'];
		$_SESSION['sucursal'] = $usuario['sucursal'];
		$_SESSION['id_user'] = $usuario['id_user'];


	if($_SESSION['logged'] == "OK" && $_SESSION['tipo'] == "1" ) {
			$ret['success'] = true;
			$ret['page'] = "Punto_Venta/admin.php";
		}
	else if($_SESSION['logged'] == "OK" && $_SESSION['tipo'] == "2" ) {
			$ret['success'] = true;
			$ret['page'] = "Punto_Venta/modulos.php";
		}
	} else {
		$ret['success'] = false;
		$ret['error'] = "Usuario y/o Contraseña Incorrecta.";
		die(json_encode($ret));
	}
	echo json_encode($ret);
?>
