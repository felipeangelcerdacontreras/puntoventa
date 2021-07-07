<?php
    include "conexion.php";
    session_start();
    
    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");

   date_default_timezone_set('America/Mexico_City');
   $fechaHoy = date("d/m/Y H:i:s");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Imprimir Inventario</title>
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

    <style type="text/css" media="print">
      @media print {
        #imprimir {display:table;}
        #wrapper {display:none;}
        .button {display:none}
        #customers, body {font-size: 8px;}
      }
    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
        <div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Imprimir inventario</a>
        </div>
        <form id="perfil" method="POST">
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a onclick="window.print();" style="color:white;"><i class="fa  fa-file-o fa-fw"></i> Imprimir</a>
                </li>
                <li class="dropdown">
                    <a href="../materia_prima.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
            </ul>
        </form>
    </nav>
</div>

  <div id="imprimir" class="col-md-10 col-md-offset-1" style="background-color:#fdfdfd;">
    <div style=" height:100%;">
      <table class="table table-bordered table-hover" align="center" id="tabla">
        <thead>
          <tr>
            <th colspan="1"><center><img src="../img/scnlogo.png" width="150"></center></th>
            <th colspan="4" style="font-size: 20px;"><center> INVENTARIO A LA FECHA / HORA: <?=$fechaHoy;?></center></th>
          </tr>
          <tr>
            <th>No. Producto</th>
            <th>Categoria</th>
            <th>Nombre Producto</th>
            <th>Cantidad</th>
             <th>Real</th>
          </tr>
        </thead>
        <tbody>
<?php
  
  $consuta = mysqli_query($con,"SELECT * FROM materia_prima ORDER BY categoria ASC"); //linea para agrupar la materia prima por categoria
  while($producto = mysqli_fetch_array($consuta)) {
    $id_materiaP = $producto['id_materiaP'];
    $nombre_matP = $producto['nombre_matP'];
    $cantidad = $producto['cantidad'];
    $categoria = $producto['categoria'];
?>
          <tr class="odd gradeX">
            <td><?php echo $id_materiaP;?></td>
            <td><?php echo $categoria;?></td>
            <td><?php echo $nombre_matP;?></td>
            <td><?php echo number_format($cantidad, 2, '.', '');?></td>
            <td></td>
          </tr>
<?php
  }
?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>