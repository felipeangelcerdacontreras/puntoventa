<?php
	session_start();
	include "../db/conexion.php";

	$ret = array();
	$ret['error'] = "Usuario y/o Contraseña Incorrecta.";
	$ret['success'] = false;

	$user = $_POST['user'];
	$pass = md5($_POST['pass']);

	$result = mysqli_query($con, "Select * from vendedores where user = '$user' and password = '$pass'");


		if($usuario = mysqli_fetch_array($result)) {
			$_SESSION['logged'] = "OK";

			if($_SESSION['logged'] === "OK") {
				$ret['success'] = true;
				$ret['page'] = "views/principal.php";
			}
		}
		else {
			$ret['success'] = false;
			$ret['error'] = "Usuario y/o Contraseña Incorrecta.";
			die(json_encode($ret));
		}
		echo json_encode($ret);
?>
