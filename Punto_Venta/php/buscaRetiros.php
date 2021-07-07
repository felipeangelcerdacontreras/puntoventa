<?php
	include 'conexion.php';
	session_start();

	date_default_timezone_set('America/Mexico_City');

	$tipo_consulta = $_POST["tipo_consulta"];
	$id_user = $_SESSION['id'];
    $ventas = mysqli_query($con, "SELECT * FROM retiros");


?>
<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
		<tr>
			<th>#</th>
            <th>No. Caja</th>
            <th>Fecha / Hora</th>
            <th>Total</th>
    	</tr>
    </thead>
    <tbody>
<?php
		while($venta = mysqli_fetch_array($ventas)) {
			$id_retiro = $venta['id_retiro'];
			$id_caja=$venta['id_caja']; //variable por si es de doble pago forma_pago2
			$fecha = $venta['fecha'];
			$monto = $venta['monto'];
?>
		<tr class="odd gradeX">
			<td><?php echo $id_retiro;?></td>
			<td><?php echo $id_caja;?></td>
			<td><?php echo $fecha;?></td>
			<td><?php echo $monto;?></td>
        </tr>
<?php
		}
	mysqli_close($con);
?>
	</tbody>
</table>