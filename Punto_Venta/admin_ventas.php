<?php
    include "php/conexion.php";
    session_start();
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");

    $numVentas = mysqli_query($con, "Select count(*) as numVentas from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta");
    if($numVenta = mysqli_fetch_array($numVentas))
        $ventas = $numVenta["numVentas"];

    // $numCancVentas = mysqli_query($con, "Select count(*) as numCancVentas from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta where venta_cancelada is null");
    // if($numCancVenta = mysqli_fetch_array($numCancVentas))
    //     $cancVentas = $numCancVenta["numCancVentas"];

    // $numFacts = mysqli_query($con, "Select count(*) as numFacts from venta left join cliente on cliente.id_cliente = venta.id_cliente inner join xml on xml.id_venta = venta.id_venta where xml.cancelada is null");
    // if($numFact = mysqli_fetch_array($numFacts))
    //     $facts = $numFact["numFacts"];
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
                    <a href="./admin.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
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
                    <a href="./historial_ventas.php">
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
                                <img src="./img/cash-register.png" style="width: 75px;">
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><br></div>
                                <div>Corte de Caja.</div>
                            </div>
                        </div>
                    </div>
                    <a href="./corte_deCaja.php">
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
                                <img src="./img/cash-register.png" style="width: 75px;">
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><br></div>
                                <div>Retiros de Caja</div>
                            </div>
                        </div>
                    </div>
                    <a href="./retiros_caja.php">
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
                                <img src="./img/steak.png" style="width: 75px;">
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><br></div>
                                <div>Ventas por Producto</div>
                            </div>
                        </div>
                    </div>
                    <a href="./ventas_producto.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

<!--             <div class="col-lg-3 col-md-6">
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
            </div> -->
            
        </div>
    </div>
</div>
</body>
</html>