<?php
    include "db/conexion_1.php";
    session_start();

    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != "1") die("Accesso No Autorizado");

    $numVentas = mysqli_query($con, "Select count(*) as numVentas from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta");
    if($numVenta = mysqli_fetch_array($numVentas))
        $ventas = $numVenta["numVentas"];

    $numClientes = mysqli_query($con, "Select count(*) as numClientes from cliente");
    if($numCliente = mysqli_fetch_array($numClientes))
        $clientes = $numCliente["numClientes"];

    $numUsers = mysqli_query($con, "Select count(*) as numUsers from usuarios");
    if($numUser = mysqli_fetch_array($numUsers))
        $users = $numUser["numUsers"];

    $numVendedores = mysqli_query($con, "Select count(*) as numVendedores from datos_vendedores");
    if($numVendedor = mysqli_fetch_array($numVendedores))
        $vendedores = $numVendedor["numVendedores"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administrador</title>
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
            <a class="navbar-brand" style="color:white;">Administrador</a>
        </div>
        <form id="perfil" method="POST">
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href='#' onclick="cerrarSesion()" style="color:white;"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
                </li>
            </ul>
        </form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
        <div class="row">
            <h5 class="text-center" >Seleccione la sucursula a la que quiere acceder.</h5>

        <div style="text-align: center;">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-money fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">

                                <div>Sucursal 1</div>
                            </div>
                        </div>
                    </div>
                    <a href="Aleman/admin.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir a sucursal 1</span>
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
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">

                                <div>Sucursal 2</div>
                            </div>
                        </div>
                    </div>
                    <a href="Punto_Venta/admin.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir a sucursal 2</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>  
    </div>
</div>
</body>
</html>
