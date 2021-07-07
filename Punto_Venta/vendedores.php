<?php
    session_start();
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu Vendedores</title>
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
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:white;">Menu Vendedores</a>
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
                                    <i class="fa fa-address-card fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><br></div>
                                    <div>Vendedores registrados.</div>
                                </div>
                            </div>
                        </div>
                        <a href="./vendedores_registrados.php">
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
                                    <i class="fa fa-user-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><br></div>
                                    <div>Agregar un nuevo vendedor.</div>
                                </div>
                            </div>
                        </div>
                        <a href="./vendedor_agregar.php">
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
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><br></div>
                                    <div>Modificar un vendedor existente.</div>
                                </div>
                            </div>
                        </div>
                        <a href="./vendedor_modificar.php">
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
                                    <i class="fa fa-user-times fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div ><br></div>
                                    <div>Eliminar un vendedor existente.</div>
                                </div>
                            </div>
                        </div>
                        <a href="vendedor_eliminar.php">
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