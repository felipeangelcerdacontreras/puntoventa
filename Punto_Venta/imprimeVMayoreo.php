<?php
  session_start();
  include 'php/conn.php';
  require('fpdf/pdf_js.php');

  date_default_timezone_set('America/Mexico_City');
  $fechaHoy = date("d/m/Y H:i:s");

  $id_venta = $_GET['id_venta'];
  // $recibido = $_GET['recibido'];
  // $cambio = $_GET['cambio'];

  $vendedor = $_SESSION['nombre'];

  class PDF_AutoPrint extends PDF_JavaScript {

    function AutoPrint($dialog = false) {
      $param = ($dialog ? 'true' : 'false');
      $script = "print($param);";
      $this->IncludeJS($script);
    }

    function AutoPrintToPrinter($server, $printer, $dialog = false) {
      $script = "var pp = getPrintParams();";
      if($dialog)
        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
      else
        $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
      $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
      $script .= "print(pp);";
      $this->IncludeJS($script);
    }
  }

  $query = "Select clientes.nombre, ventas.total_con_descuento, venta_detalle.kg_detalle, venta_detalle.precio_venta, nombrepv from ventas inner join venta_detalle on venta_detalle.idVentaF = ventas.idVenta inner join productos_venta on productos_venta.idProductosventa = venta_detalle.tipoProdDetalle left join clientes on clientes.id = ventas.idCliente where ventas.idVenta = $id_venta";

  $venta = mysql_query($query);
  if($ventaDet = mysql_fetch_array($venta)) {
    $nom_cliente = $ventaDet['nombre'];
    $total = $ventaDet['total_con_descuento'];

    if($nom_cliente == null)
      $nom_cliente = "Publico en General";
  }

  $pdf = new PDF_AutoPrint();
  $pdf->AddPage();
  $pdf->SetFont('Arial', '', 26);

  $pdf->Image('img/prodika.png', 55, 10, 100, 30);

  $pdf->SetXY(30, 44);
  $pdf->Cell(150, 10, utf8_decode('VIVIANA PATRICIA HERNANDEZ HUIZAR'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 58);
  $pdf->Cell(150, 10, utf8_decode('Calle Rio Conchos 1460'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 71);
  $pdf->Cell(150, 10, utf8_decode('Col. Magdalenas, Torreon, Coahuila.'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 83);
  $pdf->Cell(150, 10, utf8_decode('Ofic. 018714553988'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 96);
  $pdf->Cell(150, 10, utf8_decode('RFC: HEHV920512FX6'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 110);
  $pdf->Cell(150, 10, utf8_decode($fechaHoy.' Venta: '.$id_venta), 0, 1, 'C', 0);
  $pdf->SetXY(30, 123);
  $pdf->Cell(150, 10, utf8_decode('Le atendio: '.$vendedor), 0, 1, 'C', 0);
  $pdf->SetXY(30, 135);
  $pdf->Cell(150, 10, utf8_decode('Cliente: '.$nom_cliente), 0, 1, 'C', 0);
  $pdf->SetXY(30, 145);
  $pdf->Cell(150, 10, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 147);
  $pdf->Cell(150, 10, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $valorY = 147;

  $articulos = mysql_query($query);
  while($articulosDet = mysql_fetch_array($articulos)) {
    $articulo = $articulosDet['nombrepv'];
    $cantidad = $articulosDet['kg_detalle'];
    $precio_unitario = $articulosDet['precio_venta'];
    $totalA = $cantidad * $precio_unitario;
    $valorY = $valorY + 10;

    $pdf->SetFont('Arial', '', 26);
    $pdf->SetXY(10, $valorY);
    $pdf->Cell(60, 9, utf8_decode(substr($articulo, 0, 20)), 0, 1, 'L', 0);

    $pdf->SetFont('Arial', '', 24);
    $valorY = $valorY + 8;
    $pdf->SetXY(35, $valorY);
    $pdf->Cell(22, 9, utf8_decode($cantidad." x"), 0, 1, 'R', 0);
    $pdf->SetXY(90, $valorY);
    $pdf->Cell(20, 9, utf8_decode("$".number_format($precio_unitario, 2,'.',',')), 0, 1, 'R', 0);
    $pdf->SetXY(140, $valorY);
    $pdf->Cell(30, 9, utf8_decode("$".number_format($totalA, 2,'.',',')), 0, 1, 'R', 0);
  }

  $pdf->SetFont('Arial', '', 28);
  $pdf->SetXY(30, $valorY + 6);
  $pdf->Cell(150, 11, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $pdf->SetXY(30, $valorY + 8);
  $pdf->Cell(150, 11, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $pdf->SetXY(22, $valorY + 16);
  $pdf->Cell(65, 11, utf8_decode("Total de su compra: "), 0, 1, 'L', 0);
  $pdf->SetXY(125, $valorY + 16);
  $pdf->Cell(45, 11, utf8_decode("$".number_format($total, 2, '.', ',')), 0, 1, 'R', 0);
  // $pdf->SetXY(70, $valorY + 27);
  // $pdf->Cell(45, 11, utf8_decode("Recibido: "), 0, 1, 'R', 0);
  // $pdf->SetXY(125, $valorY + 27);
  // $pdf->Cell(45, 11, utf8_decode("$".number_format($recibido, 2, '.', '')), 0, 1, 'R', 0);
  // $pdf->SetXY(70, $valorY + 37);
  // $pdf->Cell(45, 11, utf8_decode("Su cambio: "), 0, 1, 'R', 0);
  // $pdf->SetXY(125, $valorY + 37);
  // $pdf->Cell(45, 11, utf8_decode("$".number_format($cambio, 2, '.', '')), 0, 1, 'R', 0);
  $pdf->AutoPrint(true);
  $pdf->Output();

  header('./punto_ventaC.php');
?>