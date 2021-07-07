<?php
	include "conexion.php";
	session_start();
	if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");
	date_default_timezone_set('America/Mexico_City');
	$fechaHoy = date("d/m/Y H:i:s");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Imprimir Historial de Ventas por Producto</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/sb-admin-2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/punto_venta.js"></script>
    <script src="../js/bloqueo.js"></script>
    <script src="../js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../js/dataTables.bootstrap.min.js" type="text/javascript"></script>
</head>
<body>

	<div id="wrapper">
	    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
	        <div class="navbar-header">
	            <a class="navbar-brand" style="color:white;">Historial de Ventas por Producto</a>
	        </div>
	        <form id="perfil" method="POST">
	            <ul class="nav navbar-top-links navbar-right">
	                <li class="dropdown">
	                    <a onclick="window.print();" style="color:white;"><i class="fa  fa-file-o fa-fw"></i> Imprimir</a>
	                </li>
	                <li class="dropdown">
	                    <a href="../ventas_producto.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
	                </li>
	            </ul>
	        </form>
	    </nav>
	</div>
	<center> INVENTARIO A LA FECHA / HORA: <?=$fechaHoy;?></center>	

	<table class="table table-bordered table-hover" align="center" id="tabla">
		<thead>
		<?php
			include 'conexion.php';

			date_default_timezone_set('America/Mexico_City');
		    $fechaHoy = date("d/m/Y H:i:s");

			$desde = $_GET['fechaDesde'];
			$hasta = $_GET['fechaHasta'];
			echo "<input id='fechaVentasDesde' type='hidden' value=".$desde.">";
			echo "<input id='fechaVentasHasta' type='hidden' value=".$hasta.">";

			$ventas = mysqli_query($con, "SELECT vd.id_articulo as IDART,p.nombre as NOMBRE,SUM(vd.cantidad) as CANTIDAD,p.precio_unitario as UNITARIO,SUM(vd.total) as TOTAL FROM venta as v INNER JOIN venta_detalle as vd ON v.id_venta=vd.id_venta INNER JOIN producto as p ON vd.id_articulo=p.id_producto WHERE (v.fecha between '$desde 00:00:00' and '$hasta 23:59:59') GROUP BY vd.id_articulo");
		?>
			<tr>
				<th>#Producto</th>
	            <th>Nombre</th>
	            <th>Cantidad</th>
	            <th>Precio Unitario</th>
	            <th>Total</th>
	    	</tr>
	    </thead>
		<tbody>
			<?php
				while($venta = mysqli_fetch_array($ventas)) {
					$IDART = $venta['IDART'];
					$NOMBRE=$venta['NOMBRE']; //variable por si es de doble pago forma_pago2
					$CANTIDAD = $venta['CANTIDAD'];
					$UNITARIO = $venta['UNITARIO'];
					$TOTAL = $venta['TOTAL'];
			?>
			<tr class="odd gradeX">
				<td><?php echo $IDART;?></td>
				<td><?php echo $NOMBRE;?></td>
				<td><?php echo number_format($CANTIDAD, 2, '.', '');?></td>
				<td><?php echo "$".number_format($UNITARIO, 2, '.', '');?></td>
				<td><?php echo "$".number_format($TOTAL, 2, '.', '')	;?></td>
	    	</tr>

			<?php
		        }
				mysqli_close($con);
			?>
		</tbody>
	</table>

</body>
</html>