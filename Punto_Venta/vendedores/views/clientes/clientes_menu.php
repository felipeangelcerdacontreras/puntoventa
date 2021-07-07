<!DOCTYPE html>
<html>
<head>
	<title>Menu de clientes</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../html/img/favicon.png">
	<link href="../../html/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="../../html/css/sb-admin-2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="../../html/js/jquery.min.js"></script>
	<script src="../../html/js/bootstrap.min.js"></script>
	<script src="../../html/js/punto_venta_vende.js"></script>
</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
	        <div class="navbar-header">
	            <a class="navbar-brand" style="color:white;">Menú de clientes</a>
	        </div>
	        <form id="perfil" method="POST">
	            <ul class="nav navbar-top-links navbar-right">
	                <li class="dropdown">
                    	<a href="../principal.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
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
	                                <i class="fa fa-user-circle fa-5x"></i>
	                            </div>
	                            <div class="col-xs-9 text-right">
	                                <div>Lista de clientes</div>
	                            </div>
	                        </div>
	                    </div>
	                    <a href="clientes_registrados.php">
	                        <div class="panel-footer">
	                            <span class="pull-left">Ver clientes registrados</span>
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
	                                <div>Agregar clientes</div>
	                            </div>
	                        </div>
	                    </div>
	                    <a href="clientes_agregar.php">
	                        <div class="panel-footer">
	                            <span class="pull-left">Ir a agregar clientes</span>
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
	                                <div>Modificar clientes</div>
	                            </div>
	                        </div>
	                    </div>
	                    <a href="clientes_modificar.php">
	                        <div class="panel-footer">
	                            <span class="pull-left">Ir a modificar clientes</span>
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
	                                <div>Eliminar clientes</div>
	                            </div>
	                        </div>
	                    </div>
	                    <a href="clientes_eliminar.php">
	                        <div class="panel-footer">
	                            <span class="pull-left">Ir a eliminar clientes</span>
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
