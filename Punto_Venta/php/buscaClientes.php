<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
<?php
	include 'conexion.php';

	$clientes = mysqli_query($con, "Select * from cliente");
?>
		<tr>
			<th>Acciones</th>
            <th>RFC</th>
            <th>Nombre</th>
            <th>Calle</th>
            <th>Nro. Exterior</th>
            <th>Colonia</th>
            <th>Municipio</th>
            <th>Estado</th>
            <th>Pais</th>
            <th>C.P.</th>
    	</tr>
    </thead>
    <tbody>
<?php
	while($cliente = mysqli_fetch_array($clientes)) {
		$id_cliente = $cliente['id_cliente'];
		$rfc_cliente = $cliente['rfc_cliente'];
		$nombre_cliente = $cliente['nombre_cliente'];
		$calle_cliente = $cliente['calle_cliente'];
		$noExt_cliente = $cliente['noExt_cliente'];
		$col_cliente = $cliente['col_cliente'];
		$municipio_cliente = $cliente['municipio_cliente'];
		$edo_cliente = $cliente['edo_cliente'];
		$pais_cliente = $cliente['pais_cliente'];
		$cp_cliente = $cliente['cp_cliente'];
?>
		<tr class="odd gradeX">
			<td><a href="javascript:modificarCliente(<?= $id_user;?>)">Editar<a>/
				<a href="javascript:eliminarCliente(<?= $id_user;?>)">Eliminar<a></td>
			<td><?php echo $rfc_cliente;?></td>
			<td><?php echo $nombre_cliente;?></td>
			<td><?php echo $calle_cliente;?></td>
			<td><?php echo $noExt_cliente;?></td>
			<td><?php echo $col_cliente;?></td>
			<td><?php echo $municipio_cliente;?></td>
			<td><?php echo $edo_cliente;?></td>
			<td><?php echo $pais_cliente;?></td>
			<td><?php echo $cp_cliente;?></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
