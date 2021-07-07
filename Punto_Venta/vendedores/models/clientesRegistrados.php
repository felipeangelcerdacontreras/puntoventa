<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
<?php
	include '../db/conexion.php';

	$tipo_consulta = $_POST["tipo_consulta"];

	$clientes = mysqli_query($con, "Select * from clientes_vendedor");
?>
		<tr>
			<?php if($tipo_consulta == 1) { ?><th>#</th><?php } ?>
			<?php if($tipo_consulta == 2) { ?><th><input type="checkbox" id="cbSelectAll" onclick="seleccionatodo()"></th><?php } ?>
			  <th>Nombre</th>
            <th>Calle</th>
            <th>Colonia</th>
						<th>C.P.</th>
						<th>Telefono</th>
						<th>Celular</th>
						<th>Rfc</th>
						<th>Nro. Exterior</th>
						<th>Nro. Interior</th>
            <th>Municipio</th>
            <th>Estado</th>

    	</tr>
    </thead>
    <tbody>
<?php
	while($cliente = mysqli_fetch_array($clientes)) {
		$id_cliente = $cliente['id_cliente'];

		$nombre = $cliente['nombre'];
		$calle = $cliente['calle'];
    $colonia = $cliente['colonia'];
    $codigo_postal = $cliente['codigo_postal'];
		$telefono = $cliente['telefono'];
		$Celular = $cliente['celular'];
    $rfc = $cliente['rfc'];
		$no_exterior = $cliente['no_exterior'];
		$no_interior = $cliente['no_interior'];
    $municipio = $cliente['municipio'];
		$estado = $cliente['estado'];
?>
		<tr class="odd gradeX">
		<?php if($tipo_consulta == 1) { ?><td><?php echo $id_cliente;?></td><?php } ?>
		<?php if($tipo_consulta == 2) { ?><td><input type="radio" name="check" class="cbSelect" value="<?php echo $id_cliente;?>"></td><?php } ?>
	    <td><?php echo $nombre;?></td>
			<td><?php echo $calle;?></td>
			<td><?php echo $colonia;?></td>
			<td><?php echo $codigo_postal;?></td>
			<td><?php echo $telefono;?></td>
			<td><?php echo $Celular;?></td>
			<td><?php echo $rfc;?></td>
			<td><?php echo $no_exterior;?></td>
			<td><?php echo $no_interior;?></td>
			<td><?php echo $municipio;?></td>
			<td><?php echo $estado;?></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
