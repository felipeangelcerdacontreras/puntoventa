
<?php
include "./conn.php"; 
$numventa = $_POST['numventa'];
$plazo = 15;


//DEVOLVER  los datos de la ultima venta 
$resultado = mysql_query("SELECT * FROM `ventas` where idVenta= '$numventa' and tipo_pago = 'Credito'");

while($mostrar = mysql_fetch_array($resultado)){
    

  
     $cliente = $mostrar['idCliente'];
    $fecha = $mostrar['fecha_venta'];
    $total = $mostrar['total_venta'];
    $kilostotal = $mostrar['kilostotal_venta'];

 
    
    
}

$rs = mysql_query("SELECT MAX(idCuentaspc) AS id FROM cuentas_porcobrar ");
	if ($row = mysql_fetch_row($rs)) {
		$idcuentas = trim($row[0]);
	}


$check="SELECT * FROM cuentas_porcobrar WHERE numventa= '$numventa'";
$rs = mysql_query($check);
$data = mysql_fetch_array($rs);
if($data[0] >= 1) {
      $cpp=("UPDATE `cuentas_porcobrar` SET `kilos_totales`='$kilostotal',`monto_total`='$total '  WHERE idCuentaspc= $idcuentas");
      $resultU= mysql_query($cpp) or die(mysql_error());
}

else
{
    
    $fecha = date('Y-m-j');
    $nuevafecha = strtotime ( "+".$plazo." day" , strtotime ( $fecha ) ) ;
//$nuevafecha = strtotime ( '+15 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
 

    
$sql=("INSERT INTO `cuentas_porcobrar` VALUES (NULL,'$numventa','$kilostotal','$total','$fecha','$nuevafecha','$cliente','SIN PAGAR','')");
$result= mysql_query($sql) or die(mysql_error());
}

?>