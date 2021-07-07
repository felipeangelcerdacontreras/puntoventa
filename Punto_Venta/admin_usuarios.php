<?php
    include "php/conexion.php";
    session_start();
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
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
    <script type="text/javascript">
        $(document).ready(function() {
            usuarios(2);

            var showPass = document.getElementById("showPass");
            if ($("#id_user").val() == null)
            {
                alert("id basio");
                $("#rwPass").show();
                $("#showPass").hide();
            } else {
                showPass.addEventListener("change", function(e){
                if(this.checked == false)
                    $("#rwPass").hide();
                else
                    $("#rwPass").show();
            });
            }
            
        });
    </script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
        <div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Usuarios</a>
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
        <div class="form-group">
            <div class="col-md-10">
                <h3 class="page-header">Usuarios Registrados</h3>
            </div>
            <div class="col-md-2">
                <br>
                <a href="#" class="btn btn-primary" style="font-size: 18px;" onclick="modificarUsuario()">Agregar Usuario</a>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="dataTable_wrapper" id="divUsuarios"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_user" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4  align="center" class="modal-title" id="myModalLabel">Usuarios</h4>
                    </div>
                    <div class="modal-body">
                    <form id="formuser" name="formuser" enctype="multipart/form-data" target="_self">
                        <div class="row" >
                            <input type="hidden" id="id_user" class="form-control">
                        </div>
                        <div class="form-group">
                            <strong class="">Usuario:</strong>
                            <div class="form-group">
                                <input type="text" id="user_user" class="form-control" placeholder="Usuario">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label><input id="showPass" type="checkbox" > Modificar contraseña</label>
                            </div>
                        </div>
                        <div class="form-group" id="rwPass" hidden>
                            <strong class="">Contraseña:</strong>
                            <div class="form-group">
                                <input type="text" id="pass_user" class="form-control" placeholder="Introduzca una nueva contraseña">
                            </div>
                        </div>    
                        <div class="form-group">
                            <strong class="">Tipo de Usuario:</strong>
                            <div class="form-group">
                                <select id="tipo_user" class="form-control">
                                    <option value="0">Seleccione un tipo</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Cajero</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <strong class="">Sucursal</strong>
                            <div class="form-group">
                                <select id="sucursal" class="form-control">
                                <?php
                                    $sucursal = mysqli_query($con, 'Select * from sucursales where status = 1');
                                    echo "<option value='0'>--SELECCIONE--</option>";
                                    while ($sc = mysqli_fetch_array($sucursal)) {
                                        echo '<option value="'.$sc['id_sucursal'].'"> '.$sc['sucursal'].' </option>'; 
                                    } 
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <h4 align="center">Datos del Usuario</h4>
                        </div>    
                        <div class="form-group">
                            <strong >Nombre:</strong>
                            <div class="form-group">
                                <input type="text" id="nom_user" class="form-control" placeholder="Nombre">
                            </div>    
                        </div>
                        <div class="form-group">
                            <strong >Dirección:</strong>
                            <div class="form-group">
                                <input type="text" id="direc_user" class="form-control" placeholder="Dirección">
                            </div>
                        </div>
                        <div class="form-group">
                            <strong >Teléfono:</strong>
                            <div class="form-group">
                                <input type="text" id="tel_user" class="form-control" placeholder="Teléfono">
                            </div>
                        </div>
                        <div class="form-group">
                            <strong >Correo:</strong>
                            <div class="form-group">
                                <input type="text" id="email_user" class="form-control" placeholder="Correo">
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-primary" value="Guardar" onclick="guardarUsuario()">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>