<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
<?php
	include 'conexion.php';
	session_start();

	date_default_timezone_set('America/Mexico_City');

	$tipo_consulta = $_POST["tipo_consulta"];

	if($tipo_consulta == 1) {
		$NotasC = mysqli_query($con, "Select id, id_venta, fecha, forma_pago, total, nombre_receptor from xmlNC where cancelada is null");
?>
		<tr>
			<th>Folio</th>
            <th>Cliente</th>
            <th>Nro. Venta</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Total</th>
            <th>XML</th>
            <th>PDF</th>
            <!-- <th>Detalles</th> -->
    	</tr>
    </thead>
    <tbody>
<?php
		while($NotaC = mysqli_fetch_array($NotasC)) {
			$id_xml = $NotaC['id'];
			$id_venta = $NotaC['id_venta'];
			$nom_cliente = $NotaC['nombre_receptor'];
			$fecha = date_create($NotaC['fecha']);
			$hora = date_create($NotaC['fecha']);
			$total = $NotaC['total'];

			$btnXML = '<a href="#" class="btn btn-primary" onclick="GenerarXMLNC('.$id_xml.')">Descargar XML</a>';
			$btnPDF = '<a href="#" class="btn btn-primary" onclick="GenerarPDFNC('.$id_xml.')">Descargar PDF</a>';
?>
		<tr class="odd gradeX">
			<td><?php echo $id_xml;?></td>
			<td><?php echo $nom_cliente;?></td>
			<td><?php echo $id_venta;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?php echo date_format($hora, 'H:i:s');?></td>
			<td><?php echo $total;?></td>
			<td align="center"><?php echo $btnXML;?></td>
			<td align="center"><?php echo $btnPDF;?></td>
<?php
		}
	}
	else if($tipo_consulta == 2) {
		$desde = $_POST["desde"];
		$hasta = $_POST["hasta"];

		$NotasC = mysqli_query($con, "Select id, id_venta, fecha, forma_pago, total, nombre_receptor from xmlNC where (fecha between '$desde 00:00:00' and '$hasta 23:59:59') and cancelada is null");
?>
		<tr>
			<th>Folio</th>
            <th>Cliente</th>
            <th>Nro. Venta</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Total</th>
            <th>XML</th>
            <th>PDF</th>
            <!-- <th>Detalles</th> -->
    	</tr>
    </thead>
    <tbody>
<?php
		while($NotaC = mysqli_fetch_array($NotasC)) {
			$id_xml = $NotaC['id'];
			$id_venta = $NotaC['id_venta'];
			$nom_cliente = $NotaC['nombre_receptor'];
			$fecha = date_create($NotaC['fecha']);
			$hora = date_create($NotaC['fecha']);
			$total = $NotaC['total'];

			$btnXML = '<a href="#" class="btn btn-primary" onclick="GenerarXMLNC('.$id_xml.')">Descargar XML</a>';
			$btnPDF = '<a href="#" class="btn btn-primary" onclick="GenerarPDFNC('.$id_xml.')">Descargar PDF</a>';
?>
		<tr class="odd gradeX">
			<td><?php echo $id_xml;?></td>
			<td><?php echo $nom_cliente;?></td>
			<td><?php echo $id_venta;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?php echo date_format($hora, 'H:i:s');?></td>
			<td><?php echo $total;?></td>
			<td align="center"><?php echo $btnXML;?></td>
			<td align="center"><?php echo $btnPDF;?></td>
<?php
		}
	}
	mysqli_close($con);
?>
	</tbody>
</table>