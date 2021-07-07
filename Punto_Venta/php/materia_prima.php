<?php
    include "conexion.php";
    session_start();
    
    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Materia Prima</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/sb-admin-2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/punto_venta.js"></script>
    <script src="../js/bloqueo.js"></script>
    <!-- <script src="js/metisMenu.min.js" type="text/javascript"></script> -->
    <script src="../js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">inventario();</script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
        <div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Materia Prima</a>
        </div>
        <form id="perfil" method="POST">
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="./inventario_p.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
                <!-- <li class="dropdown">
                    <a href="./modulos.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                </li> -->
            </ul>
        </form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
        <div class="row">
            <div class="col-md-8">
                <h3 class="page-header">Materia Prima</h3>
            </div>
            <div class="col-md-2">
                <br>
                <a href="#" class="btn btn-primary" style="font-size: 20px;" onclick="nuevo_articulo()"> <i class="fa fa-plus-circle"></i> Nuevo </a>
            </div>
            <div class="col-md-2">
                <br>
                <a href="#" class="btn btn-primary" style="font-size: 20px;" onclick="registraEntrada()"> <i class="fa fa-plus-circle"></i> Entrada </a>
            </div>
            <!-- <div class="col-md-1">
                <br>
                <a href="#" class="btn btn-primary" style="font-size: 20px;" onclick="eliminarArticulo()"> <i class="fa fa-plus-circle"></i> Eliminar </a>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="dataTable_wrapper" id="divInventario"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_inventario" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4  align="center" class="modal-title" id="myModalLabel">Registro Materia Prima</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" hidden>
                            <input type="text" id="id_materiaP" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Nombre:</label></h4></div>
                            <div class="col-md-8"><input type="text" id="nom_materiaP" class="form-control" placeholder="Nombre de la materia prima" ></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Uds disponibles:</label></h4></div>
                            <div class="col-md-8"><input type="number" id="stock_materiaP" class="form-control" placeholder="Cantidad de unidades disponibles" ></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Punto de Reorden:</label></h4></div>
                            <div class="col-md-8"><input type="number" id="reorden_materiaP" class="form-control" placeholder="Punto de Reorden" ></div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <input type="button" class="btn btn-primary" value="Guardar" onclick="guardarMateriaPrima()">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_productos" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4  align="center" class="modal-title" id="myModalLabel">Productos Derivados</h4>
                    </div>
                    <div class="modal-body" id="body_modal"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_entrada" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4  align="center" class="modal-title" id="myModalLabel">Entrada de Materia Prima</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" hidden>
                            <input type="text" id="id_art" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Materia Prima:</label></h4></div>
                            <div class="col-md-8">
                                <input type="text" id="nombreArticulo" class="form-control" list="articulos" placeholder="Escoge un artículo">
                                <datalist id="articulos">
                                <?php
                                    $articulos = mysqli_query($con, 'Select * from materia_prima');
                                    while ($articulo = mysqli_fetch_array($articulos)) {
                                        $id_art = $articulo['id_materiaP'];
                                        $nom_art = $articulo['nombre_matP'];
                                ?>
                                    <option data-id="<?=$id_art;?>" value="<?=$nom_art;?>"></option>
                                <?php }   ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Cantidad:</label></h4></div>
                            <div class="col-md-8"><input type="text" id="cantidad" class="form-control" placeholder="Cantidad entrante"></div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <input type="button" class="btn btn-primary" value="Guardar" onclick="guardaEntrada()">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>