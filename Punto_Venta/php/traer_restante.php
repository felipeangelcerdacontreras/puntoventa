<?php
	include "./conn.php";

	$idCuentaspc = $_POST['idCuentaspc'];

	$ventas = mysql_query("Select monto_total, sum(monto_cabono) as sumM from abono_cuentas inner join cuentas_porcobrar on abono_cuentas.idCuentaspcAbo = cuentas_porcobrar.idCuentaspc where idCuentaspcAbo = $idCuentaspc");
	if($venta = mysql_fetch_array($ventas)) {
		$restante = $venta['monto_total'] - $venta['sumM'];

		echo $restante;
	}

	mysql_close($con);
?>