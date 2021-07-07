<?php
	include 'conexion.php';

	$meses = array("00" => "", "01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");

	$desde = $_POST["desde"];
	list($añoinicial, $mesinicial, $diainicial) = split('-', $desde);
	$hasta = $_POST["hasta"];
	list($añofinal, $mesfinal, $diafinal) = split('-', $hasta);

	$id_user = $_POST["id_user"];
  
	$ventasMay = mysqli_query($con, "Select sum(venta_mayoreo.total) as sumMay from venta_mayoreo where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Efectivo'");//ventas total mayoreo
	if($ventaMay = mysqli_fetch_array($ventasMay)) {
		$sumMay = $ventaMay['sumMay'];
		if($sumMay == null)
			$sumMay = 0;
		//echo "efectivo suma total mayoreo: ".$sumMay."<br>";
	}
    

	$ventasMen = mysqli_query($con, "Select sum(total) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and venta_cancelada is null");//total ventas menudeo
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
	//echo $Total_Debito;
?>
<style type="text/css" media="print">
    @media print {
    #botones {display:none;}
    #select{display:none;}
    #tbAbonos2 {display:table;}
    }
  </style>

<script>
function imprSelec()
  {
  	var desde = $('#fechaDesde').val();
    var hasta = $('#fechaHasta').val();
    var id_user = $('#id_usuario').val();

    //alert("DESDE: "+desde+" HASTA: "+hasta+" ID USER: "+id_user);
     window.open("php/reporte_corte.php?desde="+desde+"&hasta="+hasta+"&id_user="+id_user,'','width=600,height=400,left=50,top=50,toolbar=yes');
     window.location="./corte_deCaja.php";
  }
</script>   
<div class="col-md-12" >
	<div class="col-md-12" align="center">
<?php
	if($desde == $hasta) {
		echo "<h4><label>Fecha: ".$diainicial." de ".$meses[$mesinicial]." del ".$añoinicial."</label></h4><br>";
		echo '<input type="button" class="btn btn-primary" value="Imprimir" onclick="javascript:imprSelec()" title="Imprimir Reporte">';
	} else {
		echo "<h4><label>Fecha: Del ".$diainicial." de ".$meses[$mesinicial]." del ".$añoinicial." al ".$diafinal." de ".$meses[$mesfinal]." del ".$añofinal."</label></h4><br>";
		echo '<input type="button" class="btn btn-primary" value="Imprimir" onclick="javascript:imprSelec()" title="Imprimir Reporte">';
	}
?>
	</div>
	<div class="col-md-3 col-md-offset-3">
		<h4><label>Venta Total: </label></h4>
	</div>
	<div class="col-md-3">
		<h4><label>$<?php echo number_format($totalCorte, 2, '.', ',');?></label></h4>
	</div>
</div>
<div class="col-md-12">
<?php
	$ventasMenudeo = mysqli_query($con, "Select venta.*, nombre_cliente, sum(cantidad) as cantidad from venta left join cliente on cliente.id_cliente = venta.id_cliente left join venta_detalle on venta_detalle.id_venta = venta.id_venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and (forma_pago = 'Efectivo' or forma_pago2='Efectivo') and venta_cancelada is null group by id_venta");
?>
	<div class="col-md-3 col-md-offset-3"><h4>Ventas al Menudeo:</h4></div>
	<div class="col-md-2"><h4><?=number_format($sumMen, 2, '.', ',');?></h4></div>

	<div class="col-md-2 col-md-offset-4"><h4>Efectivo:</h4></div>
	<div class="col-md-2"><h4><?=number_format($Total_Efectivo, 2, '.', ',');?></h4></div>
	<div class="col-md-2"><h4><a id="detMenudeo" href="#" onclick="verVMenudeo()">Ver Detalles</a></h4></div>
	<table id="tbVMenudeo" class="table table-bordered table-hover" hidden>
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Venta</th>
				<th>Cliente</th>
				<th>Fecha</th>
				<th>Cantidad</th>
				<!-- <th>Forma de Pago</th> -->
				<th>Total</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	while ($ventaMenudeo = mysqli_fetch_array($ventasMenudeo)) {
		if ($ventaMenudeo['forma_pago2']=='Efectivo') {
			$total=$ventaMenudeo['monto_efectivo'];
		}
		else{
		$total = $ventaMenudeo['total'];
		}
		$id_venta = $ventaMenudeo['id_venta'];
		$nom_cliente = $ventaMenudeo['nombre_cliente'];
		if($nom_cliente == null)
			$nom_cliente = "Venta General";
		$fecha = date_create($ventaMenudeo['fecha']);
		$cantidad = $ventaMenudeo['cantidad'];
		$forma_pago = $ventaMenudeo['forma_pago'];
		//$total = $ventaMenudeo['total'];
?>
		<tr>
			<td><?=$id_venta;?></td>
			<td><?=$nom_cliente;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?=$cantidad;?></td>
			<!-- <td><?=$forma_pago;?></td> -->
			<td>$<?=number_format($total, 2, '.', ',');?></td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>

	<div class="col-md-2 col-md-offset-4"><h4>Tarjeta de Debito:</h4></div>
	<div class="col-md-2"><h4><?=number_format($Total_Debito, 2, '.', ',');?></h4></div>
	<div class="col-md-2"><h4><a id="detTD" href="#" onclick="verVTD()">Ver Detalles</a></h4></div>
	<table id="tbVTD" class="table table-bordered table-hover" hidden>
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Venta</th>
				<th>Cliente</th>
				<th>Fecha</th>
				<th>Cantidad</th>
				<!-- <th>Forma de Pago</th> -->
				<th>Total</th>
				<th>Nro. de Cuenta/Movimiento</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	$ventasTD = mysqli_query($con, "Select venta.*, nombre_cliente, sum(cantidad) as cantidad, nro_cuenta from venta left join cliente on cliente.id_cliente = venta.id_cliente left join venta_detalle on venta_detalle.id_venta = venta.id_venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Tarjeta de debito' and venta_cancelada is null group by id_venta");

	while ($ventaTD = mysqli_fetch_array($ventasTD)) {
		if ($ventaTD['forma_pago2']=='Efectivo') {
			$total=$ventaTD['monto_tarjeta'];
		}
		else{
			$total = $ventaTD['total'];
		}
		$id_venta = $ventaTD['id_venta'];
		$nom_cliente = $ventaTD['nombre_cliente'];
		if($nom_cliente == null)
			$nom_cliente = "Venta General";
		$fecha = date_create($ventaTD['fecha']);
		$cantidad = $ventaTD['cantidad'];
		$forma_pago = $ventaTD['forma_pago'];
		//$total = $ventaTD['total'];
		$nro_cuenta = $ventaTD['nro_cuenta'];
?>
		<tr>
			<td><?=$id_venta;?></td>
			<td><?=$nom_cliente;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?=$cantidad;?></td>
			<!-- <td><?=$forma_pago;?></td> -->
			<td>$<?=number_format($total, 2, '.', ',');?></td>
			<td><?=$nro_cuenta;?></td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>

	<div class="col-md-2 col-md-offset-4"><h4>Tarjeta de Credito:</h4></div>
	<div class="col-md-2"><h4><?=number_format($Total_Credito, 2, '.', ',');?></h4></div>
	<div class="col-md-2"><h4><a id="detTC" href="#" onclick="verVTC()">Ver Detalles</a></h4></div>
	<table id="tbVTC" class="table table-bordered table-hover" hidden>
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Venta</th>
				<th>Cliente</th>
				<th>Fecha</th>
				<th>Cantidad</th>
				<!-- <th>Forma de Pago</th> -->
				<th>Total</th>
				<th>Nro. de Cuenta/Movimiento</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	$ventasTC = mysqli_query($con, "Select venta.*, nombre_cliente, sum(cantidad) as cantidad, nro_cuenta from venta left join cliente on cliente.id_cliente = venta.id_cliente left join venta_detalle on venta_detalle.id_venta = venta.id_venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Tarjeta de crédito' and venta_cancelada is null group by id_venta");

	while ($ventaTC = mysqli_fetch_array($ventasTC)) {
		if ($ventaTC['forma_pago2']=='Efectivo') {
			$total=$ventaTC['monto_tarjeta'];
		}
		else{
			$total = $ventaTC['total'];
		}
		$id_venta = $ventaTC['id_venta'];
		$nom_cliente = $ventaTC['nombre_cliente'];
		if($nom_cliente == null)
			$nom_cliente = "Venta General";
		$fecha = date_create($ventaTC['fecha']);
		$cantidad = $ventaTC['cantidad'];
		$forma_pago = $ventaTC['forma_pago'];
		//$total = $ventaTC['total'];
		$nro_cuenta = $ventaTC['nro_cuenta'];
?>
		<tr>
			<td><?=$id_venta;?></td>
			<td><?=$nom_cliente;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?=$cantidad;?></td>
			<!-- <td><?=$forma_pago;?></td> -->
			<td>$<?=number_format($total, 2, '.', ',');?></td>
			<td><?=$nro_cuenta;?></td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>

	<div class="col-md-2 col-md-offset-4"><h4>Transferencias:</h4></div>
	<div class="col-md-2"><h4><?=number_format($sumTrans, 2, '.', ',');?></h4></div>
	<div class="col-md-2"><h4><a id="detTrans" href="#" onclick="verVTrans()">Ver Detalles</a></h4></div>
	<table id="tbVTrans" class="table table-bordered table-hover" hidden>
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Venta</th>
				<th>Cliente</th>
				<th>Fecha</th>
				<th>Cantidad</th>
				<!-- <th>Forma de Pago</th> -->
				<th>Total</th>
				<th>Nro. de Cuenta/Movimiento</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	$ventasTrans = mysqli_query($con, "Select venta.*, nombre_cliente, sum(cantidad) as cantidad, nro_cuenta from venta left join cliente on cliente.id_cliente = venta.id_cliente left join venta_detalle on venta_detalle.id_venta = venta.id_venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Transferencia electrónica de fondos' and venta_cancelada is null group by id_venta");

	while ($ventaTrans = mysqli_fetch_array($ventasTrans)) {
		$id_venta = $ventaTrans['id_venta'];
		$nom_cliente = $ventaTrans['nombre_cliente'];
		if($nom_cliente == null)
			$nom_cliente = "Venta General";
		$fecha = date_create($ventaTrans['fecha']);
		$cantidad = $ventaTrans['cantidad'];
		$forma_pago = $ventaTrans['forma_pago'];
		$total = $ventaTrans['total'];
		$nro_cuenta = $ventaTrans['nro_cuenta'];
?>
		<tr>
			<td><?=$id_venta;?></td>
			<td><?=$nom_cliente;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?=$cantidad;?></td>
			<!-- <td><?=$forma_pago;?></td> -->
			<td>$<?=number_format($total, 2, '.', ',');?></td>
			<td><?=$nro_cuenta;?></td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>

	<div class="col-md-2 col-md-offset-4"><h4>Cheques:</h4></div>
	<div class="col-md-2"><h4><?=number_format($sumCheque, 2, '.', ',');?></h4></div>
	<div class="col-md-2"><h4><a id="detCheque" href="#" onclick="verVCheque()">Ver Detalles</a></h4></div>
	<table id="tbVCheque" class="table table-bordered table-hover" hidden>
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Venta</th>
				<th>Cliente</th>
				<th>Fecha</th>
				<th>Cantidad</th>
				<!-- <th>Forma de Pago</th> -->
				<th>Total</th>
				<th>Nro. de Cuenta/Movimiento</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	$ventasCheque = mysqli_query($con, "Select venta.*, nombre_cliente, sum(cantidad) as cantidad, nro_cuenta from venta left join cliente on cliente.id_cliente = venta.id_cliente left join venta_detalle on venta_detalle.id_venta = venta.id_venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Cheque nominativo' and venta_cancelada is null group by id_venta");

	while ($ventaCheque = mysqli_fetch_array($ventasCheque)) {
		$id_venta = $ventaCheque['id_venta'];
		$nom_cliente = $ventaCheque['nombre_cliente'];
		if($nom_cliente == null)
			$nom_cliente = "Venta General";
		$fecha = date_create($ventaCheque['fecha']);
		$cantidad = $ventaCheque['cantidad'];
		$forma_pago = $ventaCheque['forma_pago'];
		$total = $ventaCheque['total'];
		$nro_cuenta = $ventaCheque['nro_cuenta'];
?>
		<tr>
			<td><?=$id_venta;?></td>
			<td><?=$nom_cliente;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?=$cantidad;?></td>
			<!-- <td><?=$forma_pago;?></td> -->
			<td>$<?=number_format($total, 2, '.', ',');?></td>
			<td><?=$nro_cuenta;?></td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>

</div>
<div class="col-md-12">
<?php
	$ventasMayoreo = mysqli_query($con, "Select * from venta_mayoreo where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Efectivo'");
?>
	<div class="col-md-3 col-md-offset-3"><h4>Ventas al Mayoreo:</h4></div>
	<div class="col-md-2"><h4><?=number_format($sumMay, 2, '.', ',');?></h4></div>
	<div class="col-md-2"><h4><a id="detMayoreo" href="#" onclick="verVMayoreo()">Ver Detalles</a></h4></div>
	<table id="tbVMayoreo" class="table table-bordered table-hover" hidden>
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Venta</th>
				<th>Cliente</th>
				<th>Fecha</th>
				<th>Kilos</th>
				<!-- <th>Forma de Pago</th> -->
				<th>Total</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	while ($ventaMayoreo = mysqli_fetch_array($ventasMayoreo)) {
		$id_venta = $ventaMayoreo['idVenta'];
		$nomcliente = $ventaMayoreo['cliente'];
		$fecha = date_create($ventaMayoreo['fecha']);
		$kilos = $ventaMayoreo['kilos'];
		$forma_pago = $ventaMayoreo['forma_pago'];
		$total = $ventaMayoreo['total'];
?>
		<tr>
			<td><?=$id_venta;?></td>
			<td><?=$nomcliente;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?=$kilos;?></td>
			<!-- <td><?=$forma_pago;?></td> -->
			<td>$<?=number_format($total, 2, '.', ',');?></td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>
<div class="col-md-12">
<?php
	$abonos = mysqli_query($con, "Select * from abonos where fecha_abono between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user");
?>
	<div class="col-md-3 col-md-offset-3"><h4>Abonos:</h4></div>
	<div class="col-md-2"><h4><?=number_format($sumAbono, 2, '.', ',');?></h4></div>
	<div class="col-md-2"><h4><a id="detAbonos" href="#" onclick="verAbonos()">Ver Detalles</a></h4></div>
	<table id="tbAbonos" class="table table-bordered table-hover" hidden>
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Venta</th>
				<th>Fecha</th>
				<th>Cantidad Abonada</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	while ($abono = mysqli_fetch_array($abonos)) {
		$id_venta = $abono['idAbono_cuenta'];
		$fecha = date_create($abono['fecha_abono']);
		$monto = $abono['monto_abono'];
?>
		<tr>
			<td><?=$id_venta;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td>$<?=number_format($monto, 2, '.', ',');?></td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>

<!-- resumen de efectivo -->
<div class="col-md-12" style="margin-top: 30px;">
<?php
	$minimos = mysqli_query($con, "Select minimo from caja where id_user=$id_user");
	while ($minimo = mysqli_fetch_array($minimos)) {
		$minimo_=$minimo['minimo'];
	}

	$retiros = mysqli_query($con, "SELECT r.id_retiro, r.id_caja, r.fecha, r.monto FROM retiros as r INNER JOIN caja as c ON r.id_caja=c.id_caja WHERE c.id_user=$id_user AND r.fecha between '$desde 00:00:00' and '$hasta 23:59:59'");
	$Tretiros = mysqli_query($con, "SELECT SUM(r.monto) as TOTALR FROM retiros as r INNER JOIN caja as c ON r.id_caja=c.id_caja WHERE c.id_user=$id_user AND r.fecha between '$desde 00:00:00' and '$hasta 23:59:59'");
	while ($Tretiro = mysqli_fetch_array($Tretiros)) {
		$TOTALR=$Tretiro['TOTALR'];
	}

	$Total_Efectivo2=$Total_Efectivo+$minimo_;
	$Total_Efectivo_Entregar=$Total_Efectivo2 - $TOTALR;
?>

	<div class="col-md-3 col-md-offset-3"><h4>Resumen Efectivo:</h4></div>
	<div class="col-md-2"><h4><?="$".number_format($Total_Efectivo, 2, '.', ',');?></h4></div>

	<div class="col-md-3 col-md-offset-3"><h4>Fondo Caja:</h4></div>
	<div class="col-md-2"><h4><?="$".number_format($minimo_, 2, '.', ',');?></h4></div>
    
    <div class="col-md-3 col-md-offset-3"><h4>Retiros:</h4></div>
    <div class="col-md-2"><h4><?="$".number_format($TOTALR, 2, '.', ',');?></h4></div>

    <div class="col-md-5 col-md-offset-4">
     <table id="tbAbonos" class="table" >
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Retiro</th>
				<th>Fecha / Hora</th>
				<th>Cantidad Retirada</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	while ($retiro = mysqli_fetch_array($retiros)) {
		$id_retiro = $retiro['id_retiro'];
		$id_caja = $retiro['id_caja'];
		$fecha = $retiro['fecha'];
		$monto = $retiro['monto'];
?>
          <tr>
			<td><?=$id_retiro;?></td>
			<td><?=$fecha;?></td>
			<td>$<?=number_format($monto, 2, '.', ',');?></td>
		  </tr>
<?php
	}
?>
        </tbody>
	  </table>
    </div>

    <div class="col-md-3 col-md-offset-3"><h4>Total Efectivo:</h4></div>
    <div class="col-md-2"><h4><?="$".number_format($Total_Efectivo2, 2, '.', ',');?></h4></div>

    <div class="col-md-3 col-md-offset-3"><h4>Total Retiros:</h4></div>
    <div class="col-md-2"><h4><?="- $".number_format($TOTALR, 2, '.', ',');?></h4></div>

    <div class="col-md-3 col-md-offset-3"><h4><label>Tortal Efectivo Entregar:</label></h4></div>
    <div class="col-md-2"><h4><label><?="$".number_format($Total_Efectivo_Entregar, 2, '.', ',');?></label></h4></div>
</div>
<?php
$ban = $Total_Efectivo;
$queryCaja = mysqli_query($con, "SELECT id_caja FROM caja");

// de la consulta anterior se busca cual id_caja es igual al id del usuario conectado, despues se realiza el update
while($id_cajaUso = mysqli_fetch_array($queryCaja)) {
	if ($id_user == $id_cajaUso["id_caja"]) {
		$reiniciar = mysqli_query($con, "UPDATE caja set monto_contenido = 500 Where id_caja = ".$id_user);
		echo '<script language="javascript">alert("Se Realizo un retiro por la cantidad de: '.$ban.'");</script>'; 
    	echo '<script language="javascript">alert("La Caja Numero: '.$id_user.' Regreso al Valor Inicial de $500.00");</script>';
	}
}

$fecha = date("Y-m-d H:i:s");

$retirofinal1 = mysqli_query($con, "INSERT INTO retiros(id_retiro, id_caja, fecha, monto) VALUES (null, '".$id_user."', '".$fecha."', '".$ban."')");

mysqli_close($con)
?>