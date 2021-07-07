<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
<?php
	include 'conexion.php';

	$cajas = mysqli_query($con, "Select id_caja, user, monto_contenido, limite, minimo from caja inner join usuarios on usuarios.id_user = caja.id_user");
?>
		<tr>
            <th>Id</th>
            <th>Usuario Asignado</th>
            <th>Monto Actual</th>
            <th>Limite</th>
            <th>Minimo</th>
            <th>Editar</th>
    	</tr>
    </thead>
    <tbody>
<?php
	while($caja = mysqli_fetch_array($cajas)) {
		$id_caja = $caja['id_caja'];
		$user = $caja['user'];
		$monto_contenido = $caja['monto_contenido'];
		$limite = $caja['limite'];
		$minimo = $caja['minimo'];
		$btnEditar = '<input type="button" class="btn btn-primary" value=" Editar " onclick="editarCaja('.$id_caja.','.$limite.','.$minimo.')">';
?>
		<tr class="odd gradeX">
			<td><?php echo $id_caja;?></td>
			<td><?php echo $user;?></td>
			<td><?php echo "$".$monto_contenido;?></td>
			<td><?php echo "$".$limite;?></td>
			<td><?php echo "$".$minimo;?></td>
			<td align="center"><?php echo $btnEditar;?></td>
		</tr>
<?php
	}
	mysqli_close($con);
?>
	</tbody>
</table>