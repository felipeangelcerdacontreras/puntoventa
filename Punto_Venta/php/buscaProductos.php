<?php
	include 'conexion.php';

	$producto = mysqli_query($con, "Select producto.*, nombre_matP from producto inner join materia_prima on materia_prima.id_materiaP = producto.id_matP WHERE  producto.eliminado is null");
?>
<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
		<tr>
			<th>#</th>
			<th>Producto</th>
			<th>Clave</th>
			<th>Obtenido de</th>
			<th>Precio Unitario</th>
			<th>Unidad de Medida</th>
            <th>Editar</th>
            <th>Eliminar</th>
    	</tr>
    </thead>
    <tbody>
<?php
	while($dtproducto = mysqli_fetch_array($producto)) {
		$id_producto = $dtproducto['id_producto'];
		$nombre = $dtproducto['nombre'];
		$nombre_matP = $dtproducto['nombre_matP'];
		$clave = $dtproducto['clave'];
		$precio_unitario = $dtproducto['precio_unitario'];
		$u_medida = $dtproducto['unidad_medida'];
		$btnEdit = '<a href="#" class="btn btn-primary" onclick="editarProducto('.$id_producto.')">Editar</a>';
		$btnElim = '<a href="#" class="btn btn-danger" onclick="elimProducto('.$id_producto.')">Eliminar</a>';
?>
	<tr class="odd gradeX">
		<td><?php echo $id_producto;?></td>
		<td><?php echo $nombre;?></td>
		<td><?php echo $clave;?></td>
		<td><?php echo $nombre_matP;?></td>
		<td><?php echo $precio_unitario;?></td>
		<td><?php echo $u_medida;?></td>
		<td align="center"><?php echo $btnEdit;?></td>
		<td align="center"><?php echo $btnElim;?></td>
		<!-- <td><input type="checkbox" class="cbSelect" value="<?php echo $id_articulo;?>"></td> -->
	</tr>
<?php
	}
	mysqli_close($con);
?>
	</tbody>
</table>