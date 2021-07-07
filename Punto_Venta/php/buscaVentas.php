<table class="table table-bordered table-hover" align="center" id="tabla">
	<thead>
<?php
	include 'conexion.php';
	session_start();

	date_default_timezone_set('America/Mexico_City');

	$tipo_consulta = $_POST["tipo_consulta"];	
	
	$id_user = $_SESSION['id'];

	if($tipo_consulta != 3) {
		if($tipo_consulta == 2) {
			$desde = $_POST["desde"];
			$hasta = $_POST["hasta"];

			$ventas = mysqli_query($con, "Select nombre_cliente, venta.*, id, xml.cancelada from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where (venta.fecha between '$desde 00:00:00' and '$hasta 23:59:59') and id_user = $id_user");			
		}
		else if($tipo_consulta == 1) {
			$desde = $_POST["desde"];
			$hasta = $_POST["hasta"];

			$ventas = mysqli_query($con, "Select nombre_cliente, venta.*, id, xml.cancelada from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where id_user = $id_user and (venta.fecha between '$desde 00:00:00' and '$hasta 23:59:59')");
			$user = mysqli_query($con, "SELECT user FROM usuarios WHERE id_user = $id_user");
			$usuario = mysqli_fetch_array($user);
		}
		else if($tipo_consulta == 4) {
			// $fechaActual = date("Y-m-d H:i:s");
			// $fecha3dias = date("Y-m-d H:i:s", strtotime('-72 hours', strtotime($fechaActual)));

			// $ventas = mysqli_query($con, "Select nombre_cliente, venta.*, id, xml.cancelada from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where id is null and venta_cancelada is null and (venta.fecha between '$fecha3dias' and '$fechaActual') and id_user = $id_user");
			$ventas = mysqli_query($con, "Select nombre_cliente, venta.*, id, xml.cancelada from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where id is null and venta_cancelada is null and id_user = $id_user");
		}
		else if($tipo_consulta == 5) {
			$f_desde = $_POST["desde"];
			$f_hasta = $_POST["hasta"];

			$ventas = mysqli_query($con, "Select nombre_cliente, venta.*, id, xml.cancelada from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where (venta.fecha between '$f_desde 00:00:00' and '$f_hasta 23:59:59') and venta_cancelada is null ");
		}
		else if($tipo_consulta == 6) {
			$ventas = mysqli_query($con, "Select nombre_cliente, venta.*, id, xml.cancelada from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta");
		}
		else if($tipo_consulta == 7) {
			$desde = $_POST["desde"];
			$hasta = $_POST["hasta"];

			$ventas = mysqli_query($con, "Select nombre_cliente, venta.*, id, xml.cancelada from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where venta.fecha between '$desde 00:00:00' and '$hasta 23:59:59'");
		}
?>
		<tr>
			<th>#</th>
			<?php if($tipo_consulta == 1) { echo "<th>Usuario</th>"; } ?>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Total</th>
            <th>Forma de Pago</th>
            <th>XML</th>
            <th>PDF</th>
            <th>Detalles</th>
<?php 	if($tipo_consulta == 4) { echo "<th>Facturar</th>"; }
		else if($tipo_consulta == 5) { echo "<th>Cancelar</th>"; } ?>
    	</tr>
    </thead>
    <tbody>
<?php
		while($venta = mysqli_fetch_array($ventas)) {
			$id_venta = $venta['id_venta'];
			if(!$id_cliente = $venta['id_cliente']) $id_cliente = 0;
			$forma_pago2=$venta['forma_pago2']; //variable por si es de doble pago forma_pago2
			$id_xml = $venta['id'];
			$cancelada = $venta['cancelada'];
			$venta_cancelada = $venta['venta_cancelada'];
			$fecha = date_create($venta['fecha']);
			$hora = date_create($venta['hora']);
			$forma_pago = $venta['forma_pago'];
			$total = $venta['total'];
			$btnDetal = '<a href="#" class="btn btn-primary" onclick="verDetalles('.$id_venta.')">Ver Detalles</a>';
			$btnFactura = '<a href="#" class="btn btn-primary" onclick="facturar('.$id_venta.','.$id_cliente.')">Facturar</a>';
			$btnCancelar = '<a href="#" class="btn btn-primary" onclick="cancelarVenta('.$id_venta.')">Cancelar </a>';
			if($id_cliente != null && $id_xml != null) {
				$nom_cliente = $venta['nombre_cliente'];
				if($cancelada != null) {
					$btnXML = "Factura Cancelada";
					$btnPDF = "Factura Cancelada";
				}
				else {
				$btnXML = '<a href="#" class="btn btn-primary" onclick="GenerarXML('.$id_xml.')">Descargar XML</a>';
				$btnPDF = '<a href="#" class="btn btn-primary" onclick="GenerarPDF('.$id_xml.')">Descargar PDF</a>';
				}
			}
			else if($id_cliente != null ) {
				$nom_cliente = $venta['nombre_cliente'];
				$btnXML = "Factura Pendiente";
				$btnPDF = "Factura Pendiente";
			}
			else if($venta_cancelada == 1) {
				$btnXML = "Venta Cancelada";
				$btnPDF = "Venta Cancelada";
			}
			else {
				$nom_cliente = "Venta General";
				$btnXML = "-";
				$btnPDF = "-";
			}
?>
		<tr class="odd gradeX">
			<td><?php echo $id_venta;?></td>
			<?php if($tipo_consulta == 1) { echo "<td>".$usuario[0]."</td>"; } ?>
			<td><?php echo $nom_cliente;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?php echo date_format($hora, 'H:i:s');?></td>
			<td><?php echo $total;?></td>
<?php
            if ($forma_pago2==NULL || $forma_pago2=='') {
?>
			<td><?php echo $forma_pago;?></td>
<?php
            }
            else
            {
?>
            <td><?php echo $forma_pago." - ".$forma_pago2;?></td>
<?php
            }
?>
			<td align="center"><?php echo $btnXML;?></td>
			<td align="center"><?php echo $btnPDF;?></td>
			<td align="center"><?php echo $btnDetal;?></td>
<?php 	if($tipo_consulta == 4) { echo "<td>$btnFactura</td>"; }
		else if($tipo_consulta == 5) { echo "<td>$btnCancelar</td>"; } ?>
		</tr>
<?php
		}
	}
	else {
		if($tipo_consulta == 3) {
			$ventas = mysqli_query($con, "Select nombre_cliente, venta.*, id, folio from venta left join cliente on cliente.id_cliente = venta.id_cliente inner join xml on xml.id_venta = venta.id_venta where xml.cancelada is null");
		}
?>
		<tr>
			<th>Folio</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Total</th>
            <th>Forma de Pago</th>
            <!-- <th>XML</th> -->
            <!-- <th>PDF</th> -->
            <th>Detalles</th>
            <th>Cancelar</th>
    	</tr>
    </thead>
    <tbody>
<?php
		while($venta = mysqli_fetch_array($ventas)) {
			$id_venta = $venta['id_venta'];
			$id_cliente = $venta['id_cliente'];
			$id_xml = $venta['id'];
			$folio = $venta['folio'];
			$fecha = date_create($venta['fecha']);
			$hora = date_create($venta['hora']);
			$forma_pago = $venta['forma_pago'];
			$total = $venta['total'];
			$btnDetal = '<a href="#" class="btn btn-primary" onclick="verDetalles('.$id_venta.')">Ver Detalles</a>';
			$nom_cliente = $venta['nombre_cliente'];
			$btnXML = '<a href="#" class="btn btn-primary" onclick="GenerarXML('.$id_xml.')">Descargar XML</a>';
			$btnPDF = '<a href="#" class="btn btn-primary" onclick="GenerarPDF('.$id_xml.')">Descargar PDF</a>';
			$btnCanc = '<a href="#" class="btn btn-primary" onclick="cancelar('.$id_xml.')">Cancelar</a>';
?>
		<tr class="odd gradeX">
			<td><?php echo $folio;?></td>
			<td><?php echo $nom_cliente;?></td>
			<td><?php echo date_format($fecha, 'd-m-Y');?></td>
			<td><?php echo date_format($hora, 'H:i:s');?></td>
			<td><?php echo $total;?></td>
			<td><?php echo $forma_pago;?></td>
			<!-- <td align="center"><?php echo $btnXML;?></td> -->
			<!-- <td align="center"><?php echo $btnPDF;?></td> -->
			<td align="center"><?php echo $btnDetal;?></td>
			<td align="center"><?php echo $btnCanc;?></td>
		</tr>
<?php
		}
	}
	mysqli_close($con);
?>
	</tbody>
</table>
