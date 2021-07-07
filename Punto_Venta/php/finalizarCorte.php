<?php
	include 'conexion.php';

	$meses = array("00" => "", "01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");

	$desde = $_POST["desde"];
	list($añoinicial, $mesinicial, $diainicial) = split('-', $desde);
	$hasta = $_POST["hasta"];
	list($añofinal, $mesfinal, $diafinal) = split('-', $hasta);

	$id_user = $_POST["id_user"];
	$fecha = date("Y-m-d H:i:s");

	$ventasMay = mysqli_query($con, "Select sum(venta_mayoreo.total) as sumMay from venta_mayoreo where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Efectivo'");
	if($ventaMay = mysqli_fetch_array($ventasMay)) {
		$sumMay = $ventaMay['sumMay'];
		if($sumMay == null)
			$sumMay = 0;
	}

	$ventasMen = mysqli_query($con, "Select sum(venta.total) as sumMen from venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Efectivo' and venta_cancelada is null");
	if($ventaMen = mysqli_fetch_array($ventasMen)) {
		$sumMen = $ventaMen['sumMen'];
		if($sumMen == null)
			$sumMen = 0;
	}

	$abons = mysqli_query($con, "Select sum(monto_abono) as sumAbono from abonos where fecha_abono between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user");
	if($abon = mysqli_fetch_array($abons)) {
		$sumAbono = $abon['sumAbono'];
		if($sumAbono == null)
			$sumAbono = 0;
	}
	$totalCorte = $sumMay + $sumMen + $sumAbono;

	$insertRetiro = mysqli_query($con, "Insert into retiros values(null, $id_caja, '$fecha', $cant_retirar)");
    $reset = mysql_query($con, "updae caja set monto_contenido = 500.00 WHERE id_caja = '".$id_user."'");
?>
<div class="col-md-12" >
	<div class="col-md-12" align="center">
<?php
	if($desde == $hasta) {
		echo "<h4><label>Fecha: ".$diainicial." de ".$meses[$mesinicial]." del ".$añoinicial."</label></h4><br>";
	} else {
		echo "<h4><label>Fecha: Del ".$diainicial." de ".$meses[$mesinicial]." del ".$añoinicial." al ".$diafinal." de ".$meses[$mesfinal]." del ".$añofinal."</label></h4><br>";
	}
?>
	</div>
	<div class="col-md-3 col-md-offset-3">
		<h4><label>Efectivo en Caja: </label></h4>
	</div>
	<div class="col-md-3">
		<h4><label>$<?php echo number_format($totalCorte, 2, '.', ',');?></label></h4>
	</div>
</div>
<div class="col-md-12">
<?php
	$ventasMenudeo = mysqli_query($con, "Select venta.*, nombre_cliente, sum(cantidad) as cantidad from venta left join cliente on cliente.id_cliente = venta.id_cliente inner join venta_detalle on venta_detalle.id_venta = venta.id_venta where fecha between '$desde 00:00:00' and '$hasta 23:59:59' and id_user = $id_user and forma_pago = 'Efectivo' and venta_cancelada is null group by id_venta");
?>
	<div class="col-md-3 col-md-offset-3"><h4>Ventas al Menudeo:</h4></div>
	<div class="col-md-2"><h4><?=number_format($sumMen, 2, '.', ',');?></h4></div>
	<div class="col-md-2"><h4><a id="detMenudeo" href="#" onclick="verVMenudeo()">Ver Detalles</a></h4></div>
	<table id="tbVMenudeo" class="table table-bordered table-hover" hidden>
		<thead style="background-color:#c6c6c6;">
			<tr>
				<th>Nro. Venta</th>
				<th>Cliente</th>
				<th>Fecha</th>
				<th>Uds Disponibles</th>
				<!-- <th>Forma de Pago</th> -->
				<th>Total</th>
			</tr>
		</thead>
		<tbody style="background-color: #ffffff;">
<?php
	while ($ventaMenudeo = mysqli_fetch_array($ventasMenudeo)) {
		$id_venta = $ventaMenudeo['id_venta'];
		$nom_cliente = $ventaMenudeo['nombre_cliente'];
		if($nom_cliente == null)
			$nom_cliente = "Venta General";
		$fecha = date_create($ventaMenudeo['fecha']);
		$cantidad = $ventaMenudeo['cantidad'];
		$forma_pago = $ventaMenudeo['forma_pago'];
		$total = $ventaMenudeo['total'];
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
</div>
<?php 
    //$retiro = mysql_query($con, "");
	mysqli_close($con);
?>