<?php
    include "php/conexion.php";
    session_start();
    
    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");

    $id_user = $_SESSION['id'];

    date_default_timezone_set('America/Mexico_City');

    $fechaActual = date("Y-m-d H:i:s");
    $fecha3dias = date("Y-m-d H:i:s", strtotime('-72 hours', strtotime($fechaActual)));

    $numVentas = mysqli_query($con, "Select count(*) as numVentas from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where id_user = $id_user");
    if($numVenta = mysqli_fetch_array($numVentas))
        $ventas = $numVenta["numVentas"];

    $numfactVentas = mysqli_query($con, "Select count(*) as factVentas from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where id is null and venta_cancelada is null and id_user = $id_user");
    if($numfactVenta = mysqli_fetch_array($numfactVentas))
        $factVentas = $numfactVenta["factVentas"];

    $numCancVentas = mysqli_query($con, "Select count(*) as numCancVentas from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where venta_cancelada is null");
    if($numCancVenta = mysqli_fetch_array($numCancVentas))
        $cancVentas = $numCancVenta["numCancVentas"];

    $numFacts = mysqli_query($con, "Select count(*) as numFacts from venta left join cliente on cliente.id_cliente = venta.id_cliente inner join xml on xml.id_venta = venta.id_venta where xml.cancelada is null");
    if($numFact = mysqli_fetch_array($numFacts))
        $facts = $numFact["numFacts"];

    $numFacts = mysqli_query($con, "Select count(*) as numFacts from xmlNC where xmlNC.cancelada is null");
    if($numFact = mysqli_fetch_array($numFacts))
        $notasC = $numFact["numFacts"];  
?>
<!DOCTYPE html>
<html>
<head>
	<title>Menu Ventas</title>
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
</head>
<body>
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
		<div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Menu Ventas</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="./modulos.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
        <div class="row">
            <h5 class="text-center" >Seleccione el modulo al que quiere acceder.</h5>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-money fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$ventas;?></div>
                                <div>Ventas registradas.</div>
                            </div>
                        </div>
                    </div>
                    <a href="./ventas_vendedor.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-text-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$factVentas;?></div>
                                <div>Facturar Venta.</div>
                            </div>
                        </div>
                    </div>
                    <a href="./facturar.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-remove fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$cancVentas;?></div>
                                <div>Cancelar Venta.</div>
                            </div>
                        </div>
                    </div>
                    <a href="./cancelacion_venta.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-excel-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$facts;?></div>
                                <div>Cancelar Factura.</div>
                            </div>
                        </div>
                    </div>
                    <a href="./cancelacion.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="./img/check.png" style="width: 75px;">
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$notasC;?></div>
                                <div>Notas de Crédito.</div>
                            </div>
                        </div>
                    </div>
                    <a href="./notas_credito.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>