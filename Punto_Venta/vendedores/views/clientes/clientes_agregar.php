<?php
    session_start();

    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de clientes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../html/img/favicon.png">
    <link href="../../html/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../../html/css/sb-admin-2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="../../html/js/jquery.min.js"></script>
    <script src="../../html/js/bootstrap.min.js"></script>
    <script src="../../html/js/punto_venta_vende.js"></script>
    <script src="../../html/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../../html/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        function guardarCliente () { //Funcion para guardar un nuevo vendedor, lee todos los datos de los registros y verifica que se introduzcan todos los datos importantes.
            //alert("aqui");
            var nombre          = $('#nombre').val();
            var calle           = $('#calle').val();
            var colonia         = $('#colonia').val();
            var codigo_postal   = $('#codigo_postal').val();
            var telefono        = $('#telefono').val();
            var celular         = $('#celular').val();
            var rfc             = $('#rfc').val();
            var no_exterior     = $('#no_exterior').val();
            var no_interior     = $('#no_interior').val();
            var municipio       = $('#municipio').val();
            var estado          = $('#estado').val();

            if(nombre == "") {
                alert("Llene correctamente todos los campos.");
                $('#nombre').focus();
            }
            else if(calle == "") {
                alert("Llene correctamente todos los campos.");
                $('#calle').focus();
            }
            else if(colonia == "") {
                alert("Llene correctamente todos los campos.");
                $('#colonia').focus();
            }
            else if(codigo_postal == "") {
                alert("Llene correctamente todos los campos.");
                $('#codigo_postal').focus();
            }
            else if(telefono == "") {
                alert("Llene correctamente todos los campos.");
                $('#telefono').focus();
            }
            else if(celular == "") {
                alert("Llene correctamente todos los campos.");
                $('#celular').focus();
            }
            else if(rfc == "") {
                alert("Llene correctamente todos los campos.");
                $('#rfc').focus();
            }
            else if(no_exterior == "") {
                alert("Llene correctamente todos los campos.");
                $('#no_exterior').focus();
            }
            else if(no_interior == "") {
                alert("Llene correctamente todos los campos.");
                $('#no_interior').focus();
            }
            else if(municipio == "") {
                alert("Llene correctamente todos los campos.");
                $('#municipio').focus();
            }
            else if(estado == "") {
                alert("Llene correctamente todos los campos.");
                $('#estado').focus();
            }
            else {
                $.ajax({
                    data: "nombre=" + nombre + "&calle=" + calle + "&colonia=" + colonia + "&codigo_postal=" + codigo_postal + "&telefono=" + telefono + "&celular=" + celular + "&rfc=" + rfc + "&no_exterior=" + no_exterior + "&no_interior=" + no_interior + "&municipio=" + municipio + "&estado=" + estado + "&accion=" +1,
                    type: "POST",
                    url: "../../models/guardarCliente.php",
                    success: function(data) {
                        alert(data);
                        if(data == "Cliente agregado correctamente") {
                            window.location = "./clientes_registrados.php";
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
            <a class="navbar-brand" style="color:white;">Agregar Clientes</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="clientes_menu.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
                <li class="dropdown">
                    <a href="../../views/principal.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                </li>
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
    	<div class="row">
    		<div class="col-md-10">
    			<h3 class="page-header">Clientes Registrados</h3>
    		</div>
    	</div>

                    <div class="modal-body">
                        <div class="row" hidden>
                            <input type="text" id="id_cliente" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Nombre:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="nombre" class="form-control" placeholder="Nombre empresa"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Calle:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="calle" class="form-control" placeholder="Calle"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Colonia:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="colonia" class="form-control" placeholder="Colonia"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Codigo Postal:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="codigo_postal" class="form-control" placeholder="Codigo Postal"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Telefono:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="telefono" class="form-control" placeholder="Telefono"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Celular:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="celular" class="form-control" placeholder="Celular"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>RFC:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="rfc" class="form-control" placeholder="RFC"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>No Exterior:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="no_exterior" class="form-control" placeholder="No Exterior" style="margin-top: 10px" pattern="\d*" maxlength=""></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>No Interior:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="no_interior" class="form-control" placeholder="No Interior" style="margin-top: 10px" pattern="\d*" maxlength=""></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Municipio:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="municipio" class="form-control" placeholder="Municipio" style="margin-top: 10px" pattern="\d*" maxlength=""></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Estado:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="estado" class="form-control" placeholder="Estado" style="margin-top: 10px" pattern="\d*" maxlength=""></div>
                        </div>
                        <div class="row" align="center">
                            <input type="button" class="btn btn-primary" value="Guardar" onclick="guardarCliente()">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
