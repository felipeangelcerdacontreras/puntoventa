<?php
	include 'conexion.php';

	$tipo_consulta = $_POST["tipo_consulta"];

	if($tipo_consulta != 3) {
?>
<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
<?php

	$usuarios = mysqli_query($con, "Select * from usuarios inner join datos_usuarios on datos_usuarios.id_user = usuarios.id_user  ");
?>
		<tr>
	<?php if($tipo_consulta == 2) { ?><th>Acciones</th><?php } ?>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo</th>

    	</tr>
    </thead>
    <tbody>
<?php
	while($usuario = mysqli_fetch_array($usuarios)) {
		$id_user = $usuario['id_user'];
		$nombre = $usuario['nombre'];
		$direccion = $usuario['direccion'];
		$telefono = $usuario['telefono'];
		$correo = $usuario['correo'];
		$user = $usuario['user'];
?>
		<tr class="odd gradeX">
			<?php if($tipo_consulta == 2) { ?>
				<td><a href="javascript:modificarUsuario(<?= $id_user;?>)">Editar<a>/
				<a href="javascript:eliminarUsuario(<?= $id_user;?>)">Eliminar<a></td>
			<?php } ?>
			<td><?php echo $nombre;?></td>
			<td><?php echo $user;?></td>
			<td><?php echo $direccion;?></td>
			<td><?php echo $telefono;?></td>
			<td><?php echo $correo;?></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
<?php
	}
	else if($tipo_consulta == 3) {
		$id_user = $_POST["id_user"];

		$datosUser = mysqli_query($con, "Select * from usuarios inner join datos_usuarios on datos_usuarios.id_user = usuarios.id_user where datos_usuarios.id_user = '$id_user'");
		echo mysqli_error($con);
		if($datoUser = mysqli_fetch_array($datosUser)) {
			$nombre = $datoUser['nombre'];
			$direccion = $datoUser['direccion'];
			$telefono = $datoUser['telefono'];
			$correo = $datoUser['correo'];
			$user = $datoUser['user'];
			$pass = $datoUser['pass'];
			$tipo = $datoUser['tipo'];
			$sucursal = $datoUser['sucursal'];

			$datuser = array($id_user, $nombre, $direccion, $telefono, $correo, $user, $pass, $tipo,$sucursal);
			echo json_encode($datuser);
		}
	}
	mysqli_close($con);
?>