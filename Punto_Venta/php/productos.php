<?php
    include "conexion.php";
    session_start();
    
    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
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
    <script src="../js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">productos();</script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
        <div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Productos</a>
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
            <div class="col-md-10">
                <h3 class="page-header">Productos</h3>
            </div>
            <div class="col-md-2">
                <br>
                <a href="#" class="btn btn-primary" style="font-size: 20px;" onclick="nuevo_producto()"> <i class="fa fa-plus-circle"></i> Nuevo </a>
            </div>
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
                        <h4  align="center" class="modal-title" id="myModalLabel">Registro Producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" hidden>
                            <input type="text" id="id_producto" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Nombre:</label></h4></div>
                            <div class="col-md-8"><input type="text" id="nom_producto" class="form-control" placeholder="Nombre del producto" ></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Clave:</label></h4></div>
                            <div class="col-md-8"><input type="text" id="clave_producto" class="form-control" placeholder="Clave del producto" ></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Obtenido de:</label></h4></div>
                            <div class="col-md-8">
                                <select id="id_matP" class="form-control">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $materia_prima = mysqli_query($con, 'Select * from materia_prima');
                                    while ($dtMateria_prima = mysqli_fetch_array($materia_prima)) {
                                        $id_materiaP = $dtMateria_prima['id_materiaP'];
                                        $nombre_matP = $dtMateria_prima['nombre_matP'];
                                    ?>
                                    <option value="<?=$id_materiaP;?>"><?=$nombre_matP;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Precio unitario:</label></h4></div>
                            <div class="col-md-8"><input type="number" id="precio_producto" class="form-control" placeholder="Precio unitario" ></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;"><h4><label>Unidad:</label></h4></div>
                            <div class="col-md-8">
                                <select id="unidad_art" class="form-control">
                                    <option value="0">Seleccione una unidad</option>
                                    <option value="KG">Kilogramos</option>
                                    <option value="PZ">Piezas</option>
                                    <option value="LT">Litros</option>
                                </select>
                            </div>


                            <!-- <div class="col-md-8"><input type="text" id="unidad_art" class="form-control" placeholder="Unidad (Piezas, Kilos, Litros, etc.)"></div> -->
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <input type="button" class="btn btn-primary" value="Guardar" onclick="guardarProducto()">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>