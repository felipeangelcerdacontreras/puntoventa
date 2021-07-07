	<div class="row">
        <div class="col-md-3" style="text-align: center;"><h4><label>Artículo</label></h4></div>
        <div class="col-md-3" style="text-align: center;"><h4><label>Precio</label></h4></div>
        <div class="col-md-3" style="text-align: center;"><h4><label>Cantidad</label></h4></div>
        <div class="col-md-3" style="text-align: center;"><h4><label>Total</label></h4></div>
    </div>
<?php
	include 'conexion.php';
	$id_venta = $_POST['id_venta'];
	$sumTotal = 0;
	$monto_tarjeta = 0;
	$monto_efectivo = 0;
    
    $Tarjeta_efectivo = mysqli_query($con, "Select monto_tarjeta , monto_efectivo from venta where id_venta = $id_venta AND forma_pago2='Efectivo'");
    
    $numero_lineas=mysqli_num_rows($Tarjeta_efectivo);
    if ($numero_lineas!=0) {

    	while($T_E = mysqli_fetch_array($Tarjeta_efectivo)) 
    {
    	$monto_tarjeta = $T_E['monto_tarjeta'];
		$monto_efectivo = $T_E['monto_efectivo'];
    }
    	
    }
   
	$ventaDet = mysqli_query($con, "Select venta_detalle.*, nombre, precio_unitario from venta_detalle inner join producto on producto.id_producto = venta_detalle.id_articulo where id_venta = $id_venta");
	while($datos_ventaDet = mysqli_fetch_array($ventaDet)) {
		$nom_articulo = $datos_ventaDet['nombre'];
		$precio = $datos_ventaDet['precio_unitario'];
		$cantidad = $datos_ventaDet['cantidad'];
		$total = $datos_ventaDet['total'];
		$sumTotal = $sumTotal + $total;
?>
	<div class="row">
		<div class="col-md-3" style="text-align: center;"><label><?=$nom_articulo;?></label></div>
        <div class="col-md-3" style="text-align: center;"><label><?=$precio;?></label></div>
        <div class="col-md-3" style="text-align: center;"><label><?=$cantidad;?></label></div>
        <div class="col-md-3" style="text-align: center;"><label>$<?=$total;?></label></div>
    </div>
<?php
	}
	mysqli_close($con);
?>  

    
<?php
    if ($numero_lineas!=0 || $numero_lineas!=NULL) {
?>
    <div class="row">
        <div class="col-md-3 col-md-offset-6" style="text-align: center;"><h6>Pago Tarjeta</h6></div>
        <div class="col-md-3" style="text-align: center;"><h6>$<?=number_format($monto_tarjeta, 2);?></h6></div>

        <div class="col-md-3 col-md-offset-6" style="text-align: center;"><h6>Pago Efectivo</label></h6></div>
        <div class="col-md-3" style="text-align: center;"><h6>$<?=number_format($monto_efectivo, 2);?></h6></div>
    </div>
<?php
    }
?>    
	<div class="row">
        <div class="col-md-3 col-md-offset-6" style="text-align: center;"><h4><label>Total</label></h4></div>
        <div class="col-md-3" style="text-align: center;"><h4><label>$<?=number_format($sumTotal, 2);?></label></h4></div>
    </div>