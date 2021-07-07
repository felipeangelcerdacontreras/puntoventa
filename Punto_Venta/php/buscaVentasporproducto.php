<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
<?php
	include 'conexion.php';
	session_start();

	date_default_timezone_set('America/Mexico_City');
    $fechaHoy = date("d/m/Y H:i:s");

	//$tipo_consulta = $_POST["tipo_consulta"];
	$id_user = $_SESSION['id'];
	$ventas = mysqli_query($con, "SELECT vd.id_articulo as IDART,p.nombre as NOMBRE,SUM(vd.cantidad) as CANTIDAD,p.precio_unitario as UNITARIO,SUM(vd.total) as TOTAL FROM venta as v INNER JOIN venta_detalle as vd ON v.id_venta=vd.id_venta INNER JOIN producto as p ON vd.id_articulo=p.id_producto WHERE (v.fecha between '$fechaHoy 00:00:00' and '$fechaHoy 23:59:59') GROUP BY vd.id_articulo");
?>
		<tr>
			<th>#Producto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
    	</tr>
    </thead>
    <tbody>
<?php
		while($venta = mysqli_fetch_array($ventas)) {
			$IDART = $venta['IDART'];
			$NOMBRE=$venta['NOMBRE']; //variable por si es de doble pago forma_pago2
			$CANTIDAD = $venta['CANTIDAD'];
			$UNITARIO = $venta['UNITARIO'];
			$TOTAL = $venta['TOTAL'];
?>
		<tr class="odd gradeX">
			<td><?php echo $IDART;?></td>
			<td><?php echo $NOMBRE;?></td>
			<td><?php echo number_format($CANTIDAD, 2, '.', '');?></td>
			<td><?php echo "$".number_format($UNITARIO, 2, '.', '');?></td>
			<td><?php echo "$".number_format($TOTAL, 2, '.', '')	;?></td>
    	</tr>

<?php
        }
	mysqli_close($con);
?>
	</tbody>
</table>