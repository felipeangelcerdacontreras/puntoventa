<?php
	session_start();

	unset($_SESSION['usuario']); 
	unset($_SESSION['logged']);
	unset($_SESSION['id']);
	unset($_SESSION['tipo']);
	unset($_SESSION['nombre']);
  
	session_destroy();

	echo "../../punto";
?>