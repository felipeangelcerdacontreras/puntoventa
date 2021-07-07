<?php
	include 'conexion.php';
	$id_venta = $_POST['id_venta'];
	$tabla = "";

	$ventaDet = mysqli_query($con, "Select id_articulo, nombre, precio_venta_si, cantidad, total, unidad_medida from venta_detalle inner join producto on producto.id_producto = venta_detalle.id_articulo where id_venta = $id_venta");
	while($datos_ventaDet = mysqli_fetch_array($ventaDet)) {
		$idProd = $datos_ventaDet['id_articulo'];
		$nom_articulo = $datos_ventaDet['nombre'];
		$precio = $datos_ventaDet['precio_venta_si'];
		$cantidad = $datos_ventaDet['cantidad'];
		$total = $datos_ventaDet['total'];
		$u_medida = $datos_ventaDet['unidad_medida'];

		$tabla = $tabla."<tr id='trDev".$idProd."'><td><a href='#' onclick='quitarArticuloDev(".$idProd.")'><i class='fa fa-minus-square fa-fw'></i></a></td><td>".$cantidad."</td><td>".$nom_articulo."</td><td>".$precio."</td><td>".$total."</td><td style='display:none;'>".$idProd."</td><td style='display:none;'>".$u_medida."</td></tr>";
	}
	echo $tabla;
?>