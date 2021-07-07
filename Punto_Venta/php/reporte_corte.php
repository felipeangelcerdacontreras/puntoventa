<?php
	include 'conexion.php';
	require('../fpdf/fpdf.php');

	$meses = array("00" => "", "01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");

	$desde = $_GET["desde"];
	list($añoinicial, $mesinicial, $diainicial) = split('-', $desde);
	$hasta = $_GET["hasta"];
	list($añofinal, $mesfinal, $diafinal) = split('-', $hasta);

	$id_user = $_GET["id_user"];

    
  
	$ventasMay = mysqli_query($con, "Select sum(venta_mayoreo.total) as sumMay from venta_mayoreo where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Efectivo'");//ventas total mayoreo
	if($ventaMay = mysqli_fetch_array($ventasMay)) {
		$sumMay = $ventaMay['sumMay'];
		if($sumMay == null)
			$sumMay = 0;
		//echo "efectivo suma total mayoreo: ".$sumMay."<br>";
	}
    

	$ventasMen = mysqli_query($con, "Select sum(venta.total) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and venta_cancelada is null");//total ventas menudeo
	if($ventaMen = mysqli_fetch_array($ventasMen)) {
		$sumMen = $ventaMen['sumMen'];
		if($sumMen == null)
			$sumMen = 0;
		//echo "efectivo suma total menudeo: ".$sumMen."<br>";
	}
    
    //VENTAS TOTALES EN EFECTIVO SIN PAGO SOBLE
	$ventasEfect = mysqli_query($con, "Select sum(venta.total) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Efectivo' and forma_pago2 is null and venta_cancelada is null "); // total ventas efectivo
	if($ventaEfect = mysqli_fetch_array($ventasEfect)) {
		$sumEfect = $ventaEfect['sumMen'];
		if($sumEfect == null)
			$sumEfect = 0;
		//echo "efectivo suma total: ".$sumEfect."<br>";
	}
    
    //VENTAS TOTALES A CREDITO SIN PAGO SOBLE
	$ventasTC = mysqli_query($con, "Select sum(venta.total) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Tarjeta de crédito' and forma_pago2 is null and venta_cancelada is null"); //total ventas tarjeta de credito
	if($ventaTC = mysqli_fetch_array($ventasTC)) {
		$sumTC = $ventaTC['sumMen'];
		if($sumTC == null)
			$sumTC = 0;
		//echo "credito suma total: ".$sumTC."<br>";
	}
    
    //VENTAS TOTALES A DEBITO SIN PAGO SOBLE
	$ventasTD = mysqli_query($con, "Select sum(venta.total) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Tarjeta de debito' and forma_pago2 is null and venta_cancelada is null"); //ventas tarjetas de debito
	if($ventaTD = mysqli_fetch_array($ventasTD)) {
		$sumTD = $ventaTD['sumMen'];
		if($sumTD == null)
			$sumTD = 0;
		//echo "debito suma total: ".$sumTD."<br>"; 
	}
    
    //VENTAS TOTALES A TRANSFERENCIA SIN PAGO SOBLE
	$ventasTrans = mysqli_query($con, "Select sum(venta.total) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Transferencia electrónica de fondos' and venta_cancelada is null"); //ventas de transferencia
	if($ventaTrans = mysqli_fetch_array($ventasTrans)) {
		$sumTrans = $ventaTrans['sumMen'];
		if($sumTrans == null)
			$sumTrans = 0;
		//echo "transferencia suma total: ".$sumTrans."<br>";
	}
    
    //VENTAS TOTALES A CHEQUES SIN PAGO SOBLE
	$ventasCheque = mysqli_query($con, "Select sum(venta.total) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Cheque nominativo' and venta_cancelada is null"); //ventas de cheuqes
	if($ventaCheque = mysqli_fetch_array($ventasCheque)) {
		$sumCheque = $ventaCheque['sumMen'];
		if($sumCheque == null)
			$sumCheque = 0;
		//echo "cheque suma total: ".$sumCheque."<br>";
	}

	// AQUI HAY QUE SUMAR LOS LAS 3 COMBINADAS, T CREDITO, T DEBITO Y EFECTIVO INICIO
	$ventasTCredito = mysqli_query($con, "Select sum(monto_tarjeta) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Tarjeta de crédito' and forma_pago2 = 'Efectivo' and venta_cancelada is null"); //ventas de cheuqes
	if($TCredito = mysqli_fetch_array($ventasTCredito)) {
		$sumCreditoE = $TCredito['sumMen']; // Total de pago doble nada mas de credito
		if($sumCreditoE == null)
			$sumCreditoE = 0;
		//echo "suma de credito combinado: ".$sumCreditoE."<br>";
	}

	$ventasTDebito = mysqli_query($con, "Select sum(monto_tarjeta) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Tarjeta de debito' and forma_pago2 = 'Efectivo' and venta_cancelada is null"); //ventas de cheuqes
	if($TDebito = mysqli_fetch_array($ventasTDebito)) {
		$sumDebitoE = $TDebito['sumMen']; // Total de pago doble nada mas de debito
		if($sumDebitoE == null)
			$sumDebitoE = 0;
		//echo "suma de debito combinado: ".$sumDebitoE."<br>";
	}

	$ventasTCEfectivo = mysqli_query($con, "Select sum(monto_efectivo) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Tarjeta de crédito' and forma_pago2 = 'Efectivo'  and venta_cancelada is null"); //ventas de cheuqes
	if($TEfectivoC = mysqli_fetch_array($ventasTCEfectivo)) {
		$sumefectivoC = $TEfectivoC['sumMen']; // Total de efectivo doble nada mas de combinacion con credito
		if($sumefectivoC == null)
			$sumefectivoC = 0;
		//echo "suma de efectivo combinado con credito: ".$sumefectivoC."<br>";
    }

	$ventasTDEfectivo = mysqli_query($con, "Select sum(monto_efectivo) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and  forma_pago = 'Tarjeta de debito' and forma_pago2 = 'Efectivo'  and venta_cancelada is null"); //ventas de cheuqes
	if($TEfectivoD = mysqli_fetch_array($ventasTDEfectivo)) {
		$sumefectivoD = $TEfectivoD['sumMen']; // Total de efectivo doble nada mas de combinacion con debito
		if($sumefectivoD == null)
			$sumefectivoD = 0;
		//echo "suma de efectivo combinado con debito: ".$sumefectivoD."<br>";
	}


    //TOTALES 
	$Total_Credito = $sumTC + $sumCreditoE;
	$Total_Debito = $sumTD + $sumDebitoE;
	$Total_Efectivo = $sumEfect + $sumefectivoC + $sumefectivoD;
    // AQUI HAY QUE SUMAR LOS LAS 3 COMBINADAS, T CREDITO, T DEBITO Y EFECTIVO FIN

	$abons = mysqli_query($con, "Select sum(monto_abono) as sumAbono from abonos where fecha_abono between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user");
	if($abon = mysqli_fetch_array($abons)) {
		$sumAbono = $abon['sumAbono'];
		if($sumAbono == null)
			$sumAbono = 0;
	}
	$totalCorte = $sumMay + $sumMen + $sumAbono;

	//CONSULTAS PARA RESUMEN EFECTIVO FIN
	$minimos = mysqli_query($con, "Select minimo from caja where id_user=$id_user");
	while ($minimo = mysqli_fetch_array($minimos)) {
		$minimo_=$minimo['minimo'];
	}

	$retiros = mysqli_query($con, "SELECT r.id_retiro, r.id_caja, r.fecha, r.monto FROM retiros as r INNER JOIN caja as c ON r.id_caja=c.id_caja WHERE c.id_user=$id_user AND r.fecha between '$desde 00:00:00' and '$hasta 23:59:59'");
	$Tretiros = mysqli_query($con, "SELECT SUM(r.monto) as TOTALR FROM retiros as r INNER JOIN caja as c ON r.id_caja=c.id_caja WHERE c.id_user=$id_user AND r.fecha between '$desde 00:00:00' and '$hasta 23:59:59'");
	while ($Tretiro = mysqli_fetch_array($Tretiros)) {
		$TOTALR=$Tretiro['TOTALR'];
	}

	//reinicial la caja a 500 dependiendo del id de usuario
	$reiniciar = mysqli_query($con, "UPDATE caja set monto_contenido = 500 Where id_caja = '".$id_user."'");

	//$Total_Efectivo_=$sumEfect+$minimo_;
	//$Total_Efectivo_Entregar=$Total_Efectivo_ - $TOTALR;

	$Total_Efectivo2=$Total_Efectivo+$minimo_;
	$Total_Efectivo_Entregar=$Total_Efectivo2 - $TOTALR;
    //CONSULTAS PARA RESUMEN EFECTIVO FIN

    $NombresCajas = mysqli_query($con, "SELECT du.nombre FROM datos_usuarios as du INNER JOIN caja as c ON du.id_user=c.id_user WHERE c.id_user=$id_user");
	while ($NombresCaja = mysqli_fetch_array($NombresCajas)) {
		$NOMBREU=$NombresCaja['nombre'];
	}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
//inserto la cabecera poniendo una imagen dentro de una celda
$pdf->Cell(200,12,$pdf->Image('../img/scnlogo.png',8,8,48),0,0,'L');
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetXY(60, 10);

if($desde == $hasta) {
    $pdf->Cell(130,50, "Corte al ".$diainicial." de ".$meses[$mesinicial]." del ".$añoinicial, 0, 1, 'C', 0);
} 
else {
	$pdf->Cell(130,50, "Corte al ".$diainicial." de ".$meses[$mesinicial]." del ".$añoinicial." al ".$diafinal." de ".$meses[$mesfinal]." del ".$añofinal, 0, 1, 'C', 0);
}
$pdf->Line(55,40,200,40);

//NOMBRE DE CAJA
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetXY(140, 12);
$pdf->Cell(50,12, "CAJERO: ".$NOMBREU, 0, 1, 'C', 0);
//SUMA TOTAL DE VENTAS
$pdf->SetFont('Arial', 'B', 17);
$pdf->SetXY(32, 30);
$pdf->Cell(130,50, "Venta Total: ", 0, 1, 'C', 0);
$pdf->SetXY(70, 30);
$pdf->Cell(130,50, "$".number_format($totalCorte, 2, '.', ','), 0, 1, 'C', 0);

//TOTAL VENTAS MENUDEO
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(30, 40);
$pdf->Cell(125,50, "Ventas al Menudeo:     ", 0, 1, 'C', 0);
$pdf->SetXY(70, 40);
$pdf->Cell(125,50, "$".number_format($sumMen, 2, '.', ','), 0, 1, 'C', 0);

//EFECTIVO MENUDEO
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetXY(40, 45);
$pdf->Cell(144,50, "Efectivo:", 0, 1, 'C', 0);
$pdf->SetXY(61, 45);
$pdf->Cell(143,50, "$".number_format($Total_Efectivo, 2, '.', ','), 0, 1, 'C', 0);

//Tarjeta de Debito: MENUDEO
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetXY(32, 50);
$pdf->Cell(144,50, "Tarjeta de Debito:", 0, 1, 'C', 0);
$pdf->SetXY(57, 50);
$pdf->Cell(143,50, "$".number_format($Total_Debito, 2, '.', ','), 0, 1, 'C', 0);

//Tarjeta de Credito: MENUDEO
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetXY(31, 55);
$pdf->Cell(144,50, "Tarjeta de Credito:", 0, 1, 'C', 0);
$pdf->SetXY(57, 55);
$pdf->Cell(143,50, "$".number_format($Total_Credito, 2, '.', ','), 0, 1, 'C', 0);

//Transferencias: MENUDEO
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetXY(34, 60);
$pdf->Cell(144,50, "Transferencias:", 0, 1, 'C', 0);
$pdf->SetXY(57, 60);
$pdf->Cell(143,50, "$".number_format($sumTrans, 2, '.', ','), 0, 1, 'C', 0);

//Cheques: MENUDEO
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetXY(40, 65);
$pdf->Cell(144,50, "Cheques:", 0, 1, 'C', 0);
$pdf->SetXY(57, 65);
$pdf->Cell(143,50, "$".number_format($sumCheque, 2, '.', ','), 0, 1, 'C', 0);

//TOTAL VENTAS MAYORREO
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(30,70);
$pdf->Cell(125,50, "Ventas al Mayoreo:", 0, 1, 'C', 0);
$pdf->SetXY(70, 70);
$pdf->Cell(125,50, "$".number_format($sumMay, 2, '.', ','), 0, 1, 'C', 0);

//TOTAL ABONOS
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(30,75);
$pdf->Cell(125,50, "Abonos:", 0, 1, 'C', 0);
$pdf->SetXY(70, 75);
$pdf->Cell(125,50, "$".number_format($sumAbono, 2, '.', ','), 0, 1, 'C', 0);



/// RESUMEN EN EFECTIVO

//Resumen Efectivo:
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(30,90);
$pdf->Cell(125,50, "Resumen Efectivo:", 0, 1, 'C', 0);
$pdf->SetXY(70, 90);
$pdf->Cell(125,50, "$".number_format($Total_Efectivo, 2, '.', ','), 0, 1, 'C', 0);

//TOTAL ABONOS
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(30,95);
$pdf->Cell(125,50, "Fondo Caja:", 0, 1, 'C', 0);
$pdf->SetXY(70, 95);
$pdf->Cell(125,50, "$".number_format($minimo_, 2, '.', ','), 0, 1, 'C', 0);

//TOTAL REITOROS
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(30,100);
$pdf->Cell(125,50, "Retiros:", 0, 1, 'C', 0);
$pdf->SetXY(70, 100);
$pdf->Cell(125,50, "$".number_format($TOTALR, 2, '.', ','), 0, 1, 'C', 0);

$valorX = 50; 
$valorY = 105; 
while ($retiro = mysqli_fetch_array($retiros)) {
	$id_retiro = $retiro['id_retiro'];
	$id_caja = $retiro['id_caja'];
	$fecha = $retiro['fecha'];
	$monto = $retiro['monto'];

	$valorY = $valorY + 5;

	$pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(5, $valorY);
    $pdf->Cell(110,50, "No.Retiro: ".$id_retiro, 0, 1, 'C', 0);
    $pdf->SetXY(55, $valorY);
    $pdf->Cell(110,50, "Fecha / Hora: ".$fecha, 0, 1, 'C', 0);
    $pdf->SetXY(110, $valorY);
    $pdf->Cell(110,50, "Monto: $".number_format($monto, 2, '.', ','), 0, 1, 'C', 0);
}

//Resumen Efectivo:
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(20, $valorY + 12);
$pdf->Cell(125,50, "Total Efectivo:", 0, 1, 'C', 0);
$pdf->SetXY(70, $valorY + 12);
$pdf->Cell(125,50, "$".number_format($Total_Efectivo2, 2, '.', ','), 0, 1, 'C', 0);

//TOTAL ABONOS
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(20,$valorY + 20);
$pdf->Cell(125,50, "Total Retiros:", 0, 1, 'C', 0);
$pdf->SetXY(70, $valorY + 20);
$pdf->Cell(125,50, "$".number_format($TOTALR, 2, '.', ','), 0, 1, 'C', 0);

//TOTAL REITOROS
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(20,$valorY + 28);
$pdf->Cell(125,50, "Tortal Efectivo Entregar:", 0, 1, 'C', 0);
$pdf->SetXY(70, $valorY + 28);
$pdf->Cell(125,50, "$".number_format($Total_Efectivo_Entregar, 2, '.', ','), 0, 1, 'C', 0);

$fichero='orden-de-venta.pdf';
 
$pdfdoc = $pdf->Output();
?>