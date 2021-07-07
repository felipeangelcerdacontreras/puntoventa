<?php
	include 'conexion.php';
    
    $si=1;
    $no=2;
    $codigo=$_POST['code'];
    $id_articuloMATPRIM=$_POST['id_articuloMATPRIM'];
	$codigos = mysqli_query($con, "Select codigo_cancelar from usuarios where tipo = 'Administrador'");

	if($maxPeso = mysqli_fetch_array($codigos)) {
		$codigo_cancelar = $maxPeso["codigo_cancelar"];
	}

	if ($codigo==$codigo_cancelar) {
        
        $eliminamos = mysqli_query($con, "update producto set eliminado=1 where id_producto = $id_articuloMATPRIM"); // descactivamos producto
       // $eliminamosProdictos = mysqli_query($con, "update producto set eliminado=1 where id_matP = $id_articuloMATPRIM"); // descactivamos productos
		echo json_encode($si);
	    mysqli_close($con);
	}
	else
	{
		echo json_encode($no);
	    mysqli_close($con);
	}
?>


