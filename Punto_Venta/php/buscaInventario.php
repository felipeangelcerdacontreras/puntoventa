<?php
	include 'conexion.php';

	$inventario = mysqli_query($con, "Select * from materia_prima where eliminado is null");
?>
<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
		<tr>
			<th>#</th>
            <th>Nombre</th>
            <th>Uds Disponibles</th>
            <th>Punto de Reorden</th>
            <th>Categoría</th>
            <th>Fecha agregado</th>
			<th>Productos</th>
            <th>Editar</th>
            <th>Eliminar</th>
    	</tr>
    </thead>
    <tbody>
<?php
	while($dtInventario = mysqli_fetch_array($inventario)) {
		$id_articulo = $dtInventario['id_materiaP'];
		$nombre = $dtInventario['nombre_matP'];
		$uds = $dtInventario['cantidad'];
		$pto_reorden = $dtInventario['pto_reorden'];
		$categotia=$dtInventario['categoria'];
		$Fecha=$dtInventario['fecha_materiaP'];
		$btnPts = '<a href="#" class="btn btn-primary" onclick="verProductos('.$id_articulo.')">Ver Productos</a>';
		$btnEdit = '<a href="#" class="btn btn-primary" onclick="editarArticulo('.$id_articulo.')">Editar</a>';
		$btnElim = '<a href="#" class="btn btn-danger" onclick="elimArticulo('.$id_articulo.')">Eliminar</a>';
?>
	<tr class="odd gradeX">
		<td><?php echo $id_articulo;?></td>
		<td><?php echo $nombre;?></td>
		<td><?php echo $uds;?></td>
		<td><?php echo $pto_reorden;?></td>
		<td><?php echo $categotia;?></td>
		<td><?php echo $Fecha?>;</td>
		<td align="center"><?php echo $btnPts;?></td>
		<td align="center"><?php echo $btnEdit;?></td>
		<td align="center"><?php echo $btnElim;?></td>
	</tr>
<?php
	}
	mysqli_close($con);
?>
	</tbody>
</table>