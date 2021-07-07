<?php
	include "./conn.php";

	$idCliente = $_POST['idCliente'];

	$ventas = mysql_query("Select * from cuentas_porcobrar where idClienteCF = $idCliente and estatus in ('ABONADA', 'SIN PAGAR')");
	while($venta = mysql_fetch_array($ventas)) {
		echo'<option data="'.$venta['idCuentaspc'].'" value="'.$venta['numventa'].'"></option>';
	}

	mysql_close($con);
?>