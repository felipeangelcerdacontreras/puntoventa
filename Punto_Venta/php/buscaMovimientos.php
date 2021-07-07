<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
		<?php
			include 'conexion.php';
			session_start();

			//date_default_timezone_set('America/Mexico_City');

			$id_user = $_SESSION['id'];
			$desde = $_POST["desde"];
			$hasta = $_POST["hasta"];
			echo "<script>alert(".$_POST["desde"].");</script>";
			echo "<script>alert(".var_dump($_POST).");</script>";
			$retiros = mysqli_query($con, "SELECT * FROM retiros WHERE fecha BETWEEN $desde 00:00:00 AND $hasta 23:59:59");
			$user = mysqli_query($con, "SELECT user FROM usuarios WHERE id_user = $id_user");
			$usuario = mysqli_fetch_array($user);
		?>
			<tr>
				<th>Numero retiro</th>
				<th>Usuario</th>
				<th>Movimiento</th>
				<th>Fecha</th>
				<th>Hora</th>
			</tr>
	</thead>
	<tbody>
		<?php 
			while($retiro = mysqli_fetch_array($retiros)) {
				$id_retiro = $retiro["id_retiro"];
				$monto = $retiro["monto"];
				$fecha = date('d/m/Y', strtotime($retiro["fecha"]));
				$hora = date('H:i:s', strtotime($retiro["fecha"]));
		?>
				<tr class="odd gradeX">
					<td><?php echo $id_retiro ?></td>
					<td><?php echo $usuario[0] ?></td>
					<td><?php echo $monto ?></td>
					<td><?php echo $fecha ?></td>
					<td><?php echo $hora ?></td>
				</tr>
		<?php
			}
		?>
	</tbody>
</table>