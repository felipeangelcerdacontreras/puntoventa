<?php
    include "php/conexion.php";
    session_start();
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");

    $numVentas = mysqli_query($con, "Select count(*) as numVentas from venta left join cliente on cliente.id_cliente = venta.id_cliente left join xml on xml.id_venta = venta.id_venta");
    if($numVenta = mysqli_fetch_array($numVentas))
        $ventas = $numVenta["numVentas"];

    $numClientes = mysqli_query($con, "Select count(*) as numClientes from cliente");
    if($numCliente = mysqli_fetch_array($numClientes))
        $clientes = $numCliente["numClientes"];

    $numUsers = mysqli_query($con, "Select count(*) as numUsers from usuarios");
    if($numUser = mysqli_fetch_array($numUsers))
        $users = $numUser["numUsers"];
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
    <script type="text/javascript">
        // al iniciar sesion se verifica por ajax si hay materia prima que necesite reorden.
        $(document).ready(function() {            
            $.ajax({
                data: "",
                type: "POST",
                url: "php/notificacionPuntoReorden.php",
                success: function(data) {
                    // si se encuentra materia prima con poca cantidad, se notifica por un modal
                    if(data != 0) {
                        $('#modal_reorden').modal({
                            show: true,
                            backdrop: 'static'
                        });
                    }
                }
            });            
        });
    </script>
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
                    <a href='./modulos.php' style="color:white;"><i class="fa fa-shopping-basket fa-fw"></i> Ir a Punto de Venta</a>
                </li>
                <li class="dropdown">
                    <a href='#' onclick="cerrarSesion()" style="color:white;"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
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
                                <div>Ventas</div>
                            </div>
                        </div>
                    </div>
                    <a href="./admin_ventas.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir al menu Ventas</span>
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
                                <div class="huge"><?=$users;?></div>
                                <div>Usuarios</div>
                            </div>
                        </div>
                    </div>
                    <a href="./admin_usuarios.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir al menu Usuarios</span>
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
                                <i class="fa fa-user-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$clientes;?></div>
                                <div>Clientes</div>
                            </div>
                        </div>
                    </div>
                    <a href="./admin_clientes.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ir al menu Clientes</span>
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
                                <div>Cajas</div>
                            </div>
                        </div>
                    </div>
                    <a href="./cajas.php">
                        <div class="panel-footer">
                            <span class="pull-left">Modificar</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal_reorden" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  align="center" class="modal-title" id="myModalLabel">Poca cantidad en los siguientes productos:</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Unidades Disponibles</th>
                            <th>Punto de Reorden</th>
                            <th>Categoría</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                                // se obtienen todas las materias primas que necesiten un reorden
                                $reorden = mysqli_query($con, 'Select nombre_matP, cantidad, pto_reorden, categoria from materia_prima where cantidad <= pto_reorden');                               
                                while ($articulo = mysqli_fetch_array($reorden)) {                                
                                    $nombre     = $articulo['nombre_matP'];
                                    $cantidad   = $articulo['cantidad'];
                                    $ptoReorden = $articulo['pto_reorden'];
                                    $categoria  = $articulo['categoria'];
                                    echo '<tr>';
                                    echo '<td>'.$nombre.'</td>';
                                    echo '<td>'.$cantidad.'</td>';
                                    echo '<td>'.$ptoReorden.'</td>';
                                    echo '<td>'.$categoria.'</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table> 
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <input type="button" class="btn btn-primary" data-dismiss="modal" value="Aceptar">
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>