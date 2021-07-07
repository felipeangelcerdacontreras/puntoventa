<?php
    include 'php/conexion.php';
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inicio</title>
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
            <a class="navbar-brand" style="color:white;">Modulos</a>
        </div>
        <form id="perfil" method="POST">
            <ul class="nav navbar-top-links navbar-right">
            <?php
              if($_SESSION['logged'] == "OK" || $_SESSION['tipo'] == "Administrador")
              {
            ?>
                <li class="dropdown">
                    <a href="./admin.php"  style="color:white;"><i class="fa fa-reply fa-fw"></i>Regresar</a>
                </li>
            <?php    
              }
            ?>
                <li class="dropdown">
                    <a href='#' onclick="cerrarSesion()" style="color:white;"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
                </li>
            </ul>
        </form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
        <div class="row">
            <h5 class="text-center" >Seleccione el modulo al que quiere acceder.</h5>

            <div class="col-lg-3 col-lg-offeset-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-cubes fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><br></div>
                                <div>Ventas al Mayoreo</div>
                            </div>
                        </div>
                    </div>
                    <a href="./punto_ventaC.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir a Ventas</span>
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
                                <i class="fa fa-cube fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><br></div>
                                <div>Ventas al Menudeo</div>
                            </div>
                        </div>
                    </div>
                    <a href="./punto_venta.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir al Punto de Venta</span>
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
                                <i class="fa fa-cube fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><br></div>
                                <div>Ventas al Menudeo sin bascula</div>
                            </div>
                        </div>
                    </div>
                    <a href="./punto_venta2.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir al Punto de Venta sin bascula</span>
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
                                <img src="./img/fridge.png" style="width: 75px;">
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><br></div>
                                <div>Inventario</div>
                            </div>
                        </div>
                    </div>
                    <a href="./inventario.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir al Inventario</span>
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
                                <i class="fa fa-money fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><br></div>
                                <div>Historial de Ventas</div>
                            </div>
                        </div>
                    </div>
                    <a href="./ventas.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir al Historial</span>
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
                                <div>Retiro de Caja</div>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="retirar()">
                        <div class="panel-footer">
                            <span class="pull-left">Retirar</span>
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
                    <a href="./corte_deCaja_2.php">
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

<div class="modal fade" id="modal_retiro" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  align="center" class="modal-title" id="myModalLabel">Retiro de Caja</h4>
            </div>
            <div class="modal-body" id="body_modalEdit">
                <div class="row">
                    <div class="col-md-6">
                        <h4 style="text-align: right;"><label>Total de dinero en la caja:</label></h4>
                    </div>
                    <div class="col-md-3">
                        <?php
                            $id_usuario = $_SESSION['id'];
                            $query      = mysqli_query($con, "SELECT monto_contenido FROM caja WHERE id_caja = $id_usuario");
                            $resultado  = mysqli_fetch_array($query);
                        ?>                        
                        <input class="form-control" readonly="true" value="$ <?php echo $resultado[0] ?>">
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-4 col-md-offset-1">
                        <h4 style="text-align: right;"><label>Cantidad a retirar:</label></h4>
                    </div>
                    <div class="col-md-5">
                        <input type="number" id="cant_retirar" class="form-control">
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12">
                        <h4 style="text-align: center;"><label>Codigo de Autorización:</label></h4>
                    </div>
                    <div class="col-md-4 col-md-offset-4">
                        <input type="password" id="codigo_aut" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-primary" onclick="realiza_retiro();">Retirar</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>