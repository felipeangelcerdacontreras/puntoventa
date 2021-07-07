<?php
	session_start();
	include_once('../db/conexion.php');
	unset($_SESSION['logged']);

	//session_destroy();
	mysqli_close($con);

	echo "../index_vendedores.php";
?>
