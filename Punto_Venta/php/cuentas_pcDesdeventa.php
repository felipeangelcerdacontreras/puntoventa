<?php
  include "./conn.php"; 

  // $numventa = $_POST['numventa'];
  // $abono= $_POST['abono']; 
  $numventa = $_POST['numventa'];
  $abono= $_POST['abono']; 

  $fecha = date('Y-m-d');

  //seleccionarla cuentaxcobrar qque tenga ese numero de venta 
  $cpc = ("SELECT ventas.idVenta, cuentas_porcobrar.idCuentaspc , cuentas_porcobrar.numventa FROM `ventas` INNER JOIN cuentas_porcobrar on ventas.idVenta = cuentas_porcobrar.numventa WHERE numventa='$numventa'");
  $rcpc= mysql_query($cpc) or die(mysql_error());
  while($rowC=mysql_fetch_array($rcpc)) {
    $folio = $rowC['idCuentaspc'];
  }

  $sql2 = ("INSERT INTO abono_cuentas VALUES ('','$folio','$fecha','$abono','Efectivo','','','','','','','')");
  $result2 = mysql_query($sql2) or die(mysql_error());

  $resultRemi= mysql_query("Select cuentas_porcobrar.monto_total, cuentas_porcobrar.idCuentaspc, abono_cuentas.restante_cabono, abono_cuentas.idAbonoCuentas, SUM(monto_cabono) AS SUMA FROM abono_cuentas INNER join cuentas_porcobrar on abono_cuentas.idCuentaspcAbo = cuentas_porcobrar.idCuentaspc WHERE idCuentaspcAbo='$folio'") or die(mysql_error());
  while($row2 = mysql_fetch_array($resultRemi))
  {
    $totalfin = $row2[0]; 
    $MontoFin= $row2[4]; 
  }
  $restototal = $totalfin-$MontoFin;

  $sql3=("UPDATE abono_cuentas SET restante_cabono ='$restototal' WHERE idCuentaspcAbo='$folio'" );       
  $result3= mysql_query($sql3) or die(mysql_error());

         
 if ($restototal==0) {

  $finalizar=("UPDATE cuentas_porcobrar SET estatus='PAGADA' WHERE idCuentaspc='$folio'" );       
        $fin3= mysql_query($finalizar) or die(mysql_error());
   # code...
 }
 else{

   $abon=("UPDATE cuentas_porcobrar SET estatus='ABONADA' WHERE idCuentaspc='$folio'" );       
        $abon3= mysql_query($abon) or die(mysql_error());
 }





//header ("Location: ./cuentas_pcABONO.php?folio=$folio");
?>