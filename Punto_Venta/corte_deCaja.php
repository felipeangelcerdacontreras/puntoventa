<?php
    include "php/conexion.php";
    session_start();

    date_default_timezone_set('America/Mexico_City');

    $fecha = date("Y-m-d");
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Corte de Caja</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/favicon.png">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/sb-admin-2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/punto_venta.js"></script>
    <script src="js/bloqueo.js"></script>
	<!-- <script src="js/metisMenu.min.js" type="text/javascript"></script> -->
	<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#fechaDesde").val("<?=$fecha;?>");
			$("#fechaHasta").val("<?=$fecha;?>");
		});
	</script>
</head>
<body>
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
		<div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Corte de Caja</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="./admin_ventas.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
                <li class="dropdown">
                    <a href="./admin.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                </li>
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;"><br>
	    <div class="row" id="botones">
	    <center>
    		<div class="col-md-3">
    			<select id="vendedores" class="form-control">
    				<option value="0">Seleccione un vendedor</option>
    				<?php
    					$usuarios = mysqli_query($con, "Select nombre, usuarios.id_user from usuarios inner join datos_usuarios on datos_usuarios.id_user = usuarios.id_user");
    					while($usuario = mysqli_fetch_array($usuarios)) {
    						$nom_user = $usuario['nombre'];
    						$id_user = $usuario['id_user'];
    						echo '<option value="'.$id_user.'">'.$nom_user.'</option>';
    					}
    				?>
    			</select>
    		</div>
	        <div class="col-md-1" >
	            <h4>Desde</h4>
	        </div>
	        <div class="col-md-2" >
	            <input id="fechaDesde" type="date" class="form-control">
	        </div>
	        <div class="col-md-1">
	          <input id="filtrar" type="button" class="btn btn-primary" onclick="corte()" value="Corte">
	        </div>
	        <div class="col-md-1">
	          <input id="filtrar" type="button" class="btn btn-primary" onclick="terminarcorte()" value="finalizar">
	        </div>
	        <div class="col-md-2">
	            <input id="fechaHasta" type="date" class="form-control">
	        </div>
	        <div class="col-md-1">
	            <h4>Hasta</h4>
	        </div>
		</center>
		</div>
		<div class="row" id="select"><div class="col-md-3">
			<select id="cortePor" class="form-control">
				<option value="0">Mostrar por...</option>
				<option value="1">Corte T</option>
				<option value="2">Corte L</option>
    		</select>
    	</div></div>

    	<div class="row" id="divTablas">
	    </div>
    	
    </div>


</div>
</body>
</html>