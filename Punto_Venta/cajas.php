<?php
    include 'php/conexion.php';
    session_start();
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cajas</title>
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
	<script type="text/javascript">cajas();</script>
</head>
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
		<div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Cajas</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="./admin.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
<!--                 <li class="dropdown">
                    <a href="./admin.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                </li> -->
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
    	<div class="row">
    		<div class="col-lg-8">
    			<h3 class="page-header">Cajas Registradas</h3>
    		</div>
    		<div class="col-md-2">
                <br>
                <a href="#" class="btn btn-primary" style="font-size: 20px;" onclick="nueva_caja()"> <i class="fa fa-plus-circle"></i> Nuevo </a>
            </div>
    	</div>

    	<div class="row">
    		<div class="col-lg-12">
    			<div class="panel panel-default">
    				<div class="panel-body" >
    					<div class="dataTable_wrapper" id="divCajas"></div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
    </div>

    <div class="modal fade" id="modal_caja" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
		        <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            <h4  align="center" class="modal-title" id="myModalLabel">Modificar Caja</h4>
		        </div>
		        <div class="modal-body">
		        	<div class="row" hidden>
		        		<input type="text" id="id_caja" class="form-control">
		        	</div>
		        	<div class="row">
		        		<div class="col-md-4" style="text-align: right;"><h4><label>Limite:</label></h4></div>
		        		<div class="col-md-7"><input type="number" id="limite_caja" class="form-control"></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-md-4" style="text-align: right;"><h4><label>Minimo en Caja:</label></h4></div>
		        		<div class="col-md-7"><input type="number" id="minimo_caja" class="form-control"></div>
		        	</div>
		        </div>
		        <div class="modal-footer" style="text-align: center;">
		        	<button type="button" class="btn btn-primary" onclick="edit_caja();">Editar</button>
		        </div>
	        </div>
        </div>
    </div>

    <div class="modal fade" id="modal_caja_nueva" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
		        <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            <h4  align="center" class="modal-title" id="myModalLabel">Crear Caja</h4>
		        </div>
		        <div class="modal-body">
		        	<div class="row" hidden>
		        		<input type="text" id="id_caja" class="form-control">
		        	</div>
		        	<div class="row">
		        		<div class="col-md-4" style="text-align: right;"><h4><label>Usuario:</label></h4></div>
		        		<div class="col-md-7">
		        			<select id="usuarios" class="form-control">
		        				<option value="0">Seleccione un usuario...</option>
		        				<?php
                                    $articulos = mysqli_query($con, 'Select id_user , user from usuarios');
                                    while ($articulo = mysqli_fetch_array($articulos)) {
                                        $id_user = $articulo['id_user'];
                                        $nom_user = $articulo['user'];
                                ?>
                                    <option value="<?=$id_user;?>"><?php echo $nom_user;?></option>
                                <?php }   ?>
		        			</select>
		        		</div>
		        	</div>
		        	<div class="row">
		        		<div class="col-md-4" style="text-align: right;"><h4><label>Limite:</label></h4></div>
		        		<div class="col-md-7"><input type="number" id="limite_caja2" class="form-control"></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-md-4" style="text-align: right;"><h4><label>Minimo en Caja:</label></h4></div>
		        		<div class="col-md-7"><input type="number" id="minimo_caja2" class="form-control"></div>
		        	</div>
		        </div>
		        <div class="modal-footer" style="text-align: center;">
		        	<button type="button" class="btn btn-primary" onclick="guardar_caja();">Guardar</button>
		        </div>
	        </div>
        </div>
    </div>
</div>
</body>
</html>