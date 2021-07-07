<?php
	include_once('conexion.php');
	// Se realiza una consulta para saber los productos que tengan pocas unidades para su venta y se cuenta la cantidad de registros obtenidos
    $reorden = mysqli_query($con, 'Select nombre_matP, cantidad, pto_reorden, categoria from materia_prima where cantidad <= pto_reorden');
    $reordenRow = mysqli_num_rows($reorden);
    echo $reordenRow;
    mysqli_close($con);
?>