<?php
	session_start();
	include "./conexion.php";

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

		if($_SESSION['logged'] == "OK" && $_SESSION['tipo'] == "Cajero") {
			$ret['success'] = true;
			$ret['page'] = "./modulos.php";
		}
		else if($_SESSION['logged'] == "OK" && $_SESSION['tipo'] == "Administrador") {
			$ret['success'] = true;
			$ret['page'] = "./admin.php";
		}
	}
	else {
		$ret['success'] = false;
		$ret['error'] = "Usuario y/o Contraseña Incorrecta.";
		die(json_encode($ret));
	}
	echo json_encode($ret);
?>
