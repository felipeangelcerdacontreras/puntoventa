
<?php
include "./conn.php"; 

//Recibimos las variables
$cliente = $_POST['cliente'];
$tipopago = $_POST['tipodepago'];
$numventa2 = $_POST['numventa2'];
$fecha = $_POST['fechaz'];;
$comentario= $_POST['comentario'];;

//insertar en venta
$sql=("INSERT INTO ventas VALUES($numventa2,'$cliente','$fecha','','','$tipopago',0,0,0,'$comentario')");
$result= mysql_query($sql) or die(mysql_error());
?>
