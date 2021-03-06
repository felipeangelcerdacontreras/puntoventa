<?php
    session_start();
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Modificar Clientes</title>
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
	<script type="text/javascript">clientes(2);</script>
</head>
<body>
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
		<div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Modificar Clientes</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="./admin_clientes.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
                <li class="dropdown">
                    <a href="./admin.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                </li>
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
    	<div class="row">
    		<div class="col-md-10">
    			<h3 class="page-header">Clientes Registrados</h3>
    		</div>
            <div class="col-md-2">
                <br>
                <a href="#" class="btn btn-primary" style="font-size: 18px;" onclick="modificarCliente()">Modificar</a>
            </div>
    	</div>

    	<div class="row">
    		<div class="col-md-12">
    			<div class="panel panel-default">
    				<div class="panel-body" >
    					<div class="dataTable_wrapper" id="divClientes"></div>
	    			</div>
	    		</div>
	    	</div>
	    </div>

        <div class="modal fade" id="modal_cliente" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4  align="center" class="modal-title" id="myModalLabel">Modificar Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" hidden>
                            <input type="text" id="id_cliente" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>RFC:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="rfc_cliente" class="form-control" placeholder="RFC" maxlength="13"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Nombre:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="nom_cliente" class="form-control" placeholder="Nombre"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Calle:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="calle_cliente" class="form-control" placeholder="Calle"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>No Exterior:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="noExt_cliente" class="form-control" placeholder="N??mero exterior"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Colonia:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="col_cliente" class="form-control" placeholder="Colonia"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Municipio:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="municipio_cliente" class="form-control" placeholder="Municipio"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Estado:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="edo_cliente" class="form-control" placeholder="Estado"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Pa??s:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="pais_cliente" class="form-control" placeholder="Pa??s"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>C??digo Postal:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="cp_cliente" class="form-control" placeholder="C??digo Postal" style="margin-top: 10px" pattern="\d*" maxlength="5"></div>
                        </div>
                        <div align="center">
                            <input type="button" class="btn btn-primary" value="Modificar" onclick="actualizaCliente()">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>