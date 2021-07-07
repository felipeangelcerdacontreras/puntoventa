<?php
    include "php/conexion.php";
    session_start();
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Clientes</title>
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
    <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">clientes(1);</script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
        <div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Clientes</a>
        </div>
        <form id="perfil" method="POST">
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="./admin.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
            </ul>
        </form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
    	<div class="row">
    		<div class="col-lg-12">
    			<h3 class="page-header">Clientes Registrados</h3>
    		</div>
    	</div>

    	<div class="row">
    		<div class="col-lg-12">
    			<div class="panel panel-default">
    				<div class="panel-body" >
    					<div class="dataTable_wrapper" id="divClientes"></div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
    </div>
</div>
</body>
</html>