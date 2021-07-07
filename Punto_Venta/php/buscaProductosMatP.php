	<div class="row">
		<div class="col-md-4" style="text-align: center;"><h4><label>Producto</label></h4></div>
		<div class="col-md-4" style="text-align: center;"><h4><label>Clave</label></h4></div>
		<div class="col-md-4" style="text-align: center;"><h4><label>Precio</label></h4></div>
	</div>
<?php
	include 'conexion.php';
	$id_materiaP = $_POST['id_materiaP'];

	$productos = mysqli_query($con, "Select * from producto where id_matP = $id_materiaP");
	while($datos_productos = mysqli_fetch_array($productos)) {
		$clave = $datos_productos['clave'];
		$nombre = $datos_productos['nombre'];
		$precio_unitario = $datos_productos['precio_unitario'];
?>
	<div class="row">
		<div class="col-md-4" style="text-align: center;"><label><?=$nombre;?></label></div>
        <div class="col-md-4" style="text-align: center;"><label><?=$clave;?></label></div>
        <div class="col-md-4" style="text-align: center;"><label><?=$precio_unitario;?></label></div>
    </div>
<?php
	}
	mysqli_close($con);
?>