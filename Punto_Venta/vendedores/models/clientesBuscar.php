<?php
	include 'conexion.php';

	$tipo_consulta = $_POST["consulta"];
?>
<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
		<?php
			$vendedores = mysqli_query($con, "Select * from datos_vendedores");
		?>
		<tr>
			<?php if($tipo_consulta == 1) { ?><td></td><?php } ?>
      <th>#<th>
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
			while($vendedor = mysqli_fetch_array($vendedores)) {
				$id_vendedor     = $vendedor['id_vendedor'];
				$nombre          = $vendedor['nombre'];
				$apellidoPaterno = $vendedor['apellido_paterno'];
				$apellidoMaterno = $vendedor['apellido_materno'];
				$fechaNacimiento = $vendedor['fecha_nacimiento'];
				$telefono        = $vendedor['telefono'];
				$celular         = $vendedor['celular'];
		?>
		<tr class="odd gradeX">
			<?php if($tipo_consulta == 1) { ?>
				<td><input type="radio" class="cbSelect" value="<?php echo $id_vendedor;?>" name="nombre"></td>
			<?php } ?>
			<td><?php echo $id_vendedor;?></td>
			<td><?php echo $nombre;?></td>
			<td><?php echo $apellidoPaterno;?></td>
			<td><?php echo $apellidoMaterno;?></td>
			<td><?php echo $fechaNacimiento;?></td>
			<td><?php echo $telefono;?></td>
			<td><?php echo $celular;?></td>
		</tr>
		<?php
			}
			mysqli_close($con);
		?>
	</tbody>
</table>
