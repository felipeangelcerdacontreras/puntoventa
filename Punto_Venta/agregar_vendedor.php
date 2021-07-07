<?php
    session_start();

    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vendedores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.png">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sb-admin-2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        function guardarVendedor() { //Funcion para guardar un nuevo vendedor, lee todos los datos de los registros y verifica que se introduzcan todos los datos importantes.
            var nombre          = $('#nombre').val();
            var apellidoPaterno = $('#apellidoPaterno').val();
            var apellidoMaterno = $('#apellidoMaterno').val();
            var fechaNacimiento = $('#fechaNacimiento').val();
            var telefono        = $('#telefono').val();
            var celular         = $('#celular').val();

            if(nombre == "") {
                alert("Llene correctamente todos los campos.");
                $('#nombre').focus();
            }
            else if(apellidoPaterno == "") {
                alert("Llene correctamente todos los campos.");
                $('#apellidoPaterno').focus();
            }
            else if(apellidoMaterno == "") {
                alert("Llene correctamente todos los campos.");
                $('#apellidoMaterno').focus();
            }
            else if(fechaNacimiento == "") {
                alert("Llene correctamente todos los campos.");
                $('#fechaNacimiento').focus();
            }
            else {
                $.ajax({
                    data: "nombre=" + nombre + "&apellidoPaterno=" + apellidoPaterno + "&apellidoMaterno=" + apellidoMaterno + "&fechaNacimiento=" + fechaNacimiento + "&telefono=" + telefono + "&celular=" + celular + "&accion=" + 1,
                    type: "POST",
                    url: "php/guardarVendedor.php",
                    success: function(data) {
                        alert(data);
                        if(data == "Vendedor agregado correctamente.") {
                            window.location = "./vendedores_registrados.php";
                        }
                    }
                });
            }
        }
    </script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:white;">Agregar Vendedor</a>
            </div>
            <form id="perfil" method="POST">
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a href="./vendedores.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                    </li>
                    <li class="dropdown">
                        <a href="./admin.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                    </li>
                </ul>
            </form>
        </nav>

        <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
            <div class="col-md-6 col-md-offset-3">
                <br>
                <div class="row" hidden>
                    <input type="text" id="id_user" class="form-control">
                </div>
                <h4 align="center">Datos del Vendedor</h4>
                <div class="row">
                    <div class="col-md-4" style="text-align: right;"><h4><label>Nombre:</label></h4></div>
                    <div class="col-md-8"><input type="text" id="nombre" class="form-control" placeholder="Nombre"></div>
                </div>
                <div class="row">
                    <div class="col-md-4" style="text-align: right;"><h4><label>Apellido paterno:</label></h4></div>
                    <div class="col-md-8"><input type="text" id="apellidoPaterno" class="form-control" placeholder="Apellido paterno"></div>
                </div>
                <div class="row">
                    <div class="col-md-4" style="text-align: right;"><h4><label>Apellido materno:</label></h4></div>
                    <div class="col-md-8"><input type="text" id="apellidoMaterno" class="form-control" placeholder="Apellido materno"></div>
                </div>
                <div class="row">
                    <div class="col-md-4" style="text-align: right;"><h4><label>Fecha de nacimiento:</label></h4></div>
                    <div class="col-md-8"><input type="date" id="fechaNacimiento" class="form-control"></div>
                </div>
                <div class="row">
                    <div class="col-md-4" style="text-align: right;"><h4><label>Teléfono:</label></h4></div>
                    <div class="col-md-8"><input type="text" id="telefono" class="form-control" placeholder="Teléfono"></div>
                </div>
                <div class="row">
                    <div class="col-md-4" style="text-align: right;"><h4><label>Celular:</label></h4></div>
                    <div class="col-md-8"><input type="text" id="celular" class="form-control" placeholder="Celular"></div>
                </div>
                <div class="row" align="center">
                    <input type="button" class="btn btn-primary" value="Guardar" onclick="guardarVendedor()">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
