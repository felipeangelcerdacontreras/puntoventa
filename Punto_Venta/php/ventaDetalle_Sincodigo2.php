<?php
	//incluimos el script  que contiene las variables y la conexion con el servidor
	include "./conn.php"; 

	$numventa = $_POST['numventa'];
	$lote = $_POST['lote'];
	$almacen = $_POST['almacen'];
	//$caja_granel = $_POST['cajaogranel'];
	$kilos = $_POST['peso'];
	$productos_venta = $_POST['productos_venta'];
	$juliano = $_POST['juliano'];
	$clave = $_POST['clave'];
	$codigodebarras = $_POST['codigodebarras'];
	$cliente = $_POST['cliente'];
	$fechaz = $_POST['fechaz'];
	$precio = $_POST['precio'];
	$importe = $_POST['importe'];
	$totall = $_POST['totall'];
	$totalK = $_POST['totalK'];
	$descuento = $_POST['descuento'];
	$descPesos = ($descuento * 0.01) * $totall;
	$totalDes = $totall - $descPesos;

	$sql = ("INSERT INTO inventario_detalle VALUES(NULL,'$codigodebarras',$lote,'$fechaz',$productos_venta,'$almacen',0,'$kilos','$clave','0','Entrada')");
	$result= mysql_query($sql) or die(mysql_error());
	$id_inventarioout = mysql_insert_id($con);

	$kilosnegativo = "-".$kilos; 
	$insertgranel=("INSERT INTO inventario_detalle VALUES(NULL,'$codigodebarras','$lote','$fechaz',$productos_venta,'$almacen','0','$kilosnegativo','$clave','0','Salida')");
	$resultIN= mysql_query($insertgranel) or die(mysql_error());

	mysql_query("INSERT INTO venta_detalle VALUES('NULL','$numventa','$id_inventarioout','$productos_venta','$kilos','',$precio,'$codigodebarras') ");

	$insertventas=("INSERT INTO ventas_intermedio VALUES(NULL,$numventa,$productos_venta,'$kilos',$precio,$importe,'$codigodebarras')");
	$resultVE= mysql_query($insertventas) or die(mysql_error());

	$sql2=("UPDATE ventas SET   total_venta = '$totall', kilostotal_venta = '$totalK', descuento = '$descuento', descuento_en_pesos = '$descPesos', total_con_descuento = '$totalDes' WHERE idVenta= '$numventa'");
	$result2= mysql_query($sql2) or die(mysql_error());

	echo "Venta Guardada";
?>