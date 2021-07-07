<?php
  include 'php/conexion.php';
  require('fpdf/fpdf.php');

  date_default_timezone_set('America/Mexico_City');
  $fechaHoy = date("d/m/Y H:i:s");

  $id_venta = $_GET['id_venta'];
  $recibido = $_GET['recibido'];
  $cambio = $_GET['cambio'];

  class paperpdf extends FPDF { 
    var $javascript; 
    var $n_js; 

    function IncludeJS($script) { 
        $this->javascript=$script; 
    } 

    function _putjavascript() { 
        $this->_newobj(); 
        $this->n_js=$this->n; 
        $this->_out('<<'); 
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]'); 
        $this->_out('>>'); 
        $this->_out('endobj'); 
        $this->_newobj(); 
        $this->_out('<<'); 
        $this->_out('/S /JavaScript'); 
        $this->_out('/JS '.$this->_textstring($this->javascript)); 
        $this->_out('>>'); 
        $this->_out('endobj'); 
    } 

    function _putresources() { 
        parent::_putresources(); 
        if (!empty($this->javascript)) { 
            $this->_putjavascript(); 
        } 
    } 

    function _putcatalog() { 
        parent::_putcatalog(); 
        if (!empty($this->javascript)) { 
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>'); 
        } 
    } 
  }

  $query = "Select datos_usuarios.nombre as nom, nombre_cliente, venta.total, venta_detalle.total as totalA, cantidad, precio_unitario, producto.nombre as art from venta inner join venta_detalle on venta_detalle.id_venta = venta.id_venta inner join producto on producto.id_producto = venta_detalle.id_articulo inner join usuarios on usuarios.id = venta.id_user inner join datos_usuarios on datos_usuarios.id_user = usuarios.id_user left join cliente on cliente.id_cliente = venta.id_cliente where venta.id_venta = $id_venta";

  $venta = mysqli_query($con, $query);
  if($ventaDet = mysqli_fetch_array($venta)) {
    $nom_cliente = $ventaDet['nombre_cliente'];
    $vendedor = $ventaDet['nom'];
    $total = $ventaDet['total'];

    if($nom_cliente == null)
      $nom_cliente = "Publico en General";
  }
  $pdf = new paperpdf; 
  $pdf->AddPage('P');
  $pdf->SetFont('Arial', '', 29);
  $pdf->Cell(200,12,$pdf->Image('img/scnlogo2.png',55, 10, 100, 30),0,0,'L');

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
  $pdf->SetFont('Arial', '', 29);
  $articulos = mysqli_query($con, $query);

  while($articulosDet = mysqli_fetch_array($articulos)) {
    $articulo = $articulosDet['art'];
    $cantidad = $articulosDet['cantidad'];
    $precio_unitario = $articulosDet['precio_unitario'];
    $totalA = $articulosDet['totalA'];    
    
    $pdf->MultiCell(75, 10, utf8_decode(substr($articulo, 0, 30)), 0, 'L');
    $valorY = $pdf->GetY();
    $pdf->SetXY(80, $valorY - 10);
    $pdf->MultiCell(40, 10, utf8_decode($cantidad."x"), 0, 'R');
    $pdf->SetXY(118, $valorY - 10);
    $pdf->MultiCell(40, 9, utf8_decode("$".$precio_unitario), 0, 'R');
    $pdf->SetXY(145, $valorY - 10);
    $pdf->MultiCell(50, 9, utf8_decode("$".$totalA), 0, 'R');
    $pdf->Ln(5);
  }

  $valorY = $pdf->GetY();

  $pdf->SetFont('Arial', '', 33);
  $pdf->SetXY(30, $pdf->GetY());
  $pdf->Cell(150, 11, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $pdf->SetXY(30, $pdf->GetY() - 9);
  $pdf->Cell(150, 11, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $pdf->SetXY(50, $pdf->GetY());
  $pdf->SetFont('Arial', 'B', 50);
  $pdf->Cell(10, 11, utf8_decode("Total: "), 0, 1, 'L', 0);  
  $pdf->SetXY(105, $pdf->GetY() - 10);
  $pdf->Cell(90, 11, utf8_decode("$".number_format($total, 2, '.', '')), 0, 1, 'L', 0);
  $pdf->SetXY(60, $pdf->GetY());
  $pdf->SetFont('Arial', '', 33);
  $pdf->Cell(45, 11, utf8_decode("Recibido:  "), 0, 1, 'R', 0);
  $pdf->SetXY(105, $pdf->GetY() - 10);
  $pdf->Cell(90, 11, utf8_decode("$".number_format($recibido, 2, '.', '')), 0, 1, 'L', 0);
  $pdf->SetXY(60, $pdf->GetY());
  $pdf->Cell(45, 11, utf8_decode("Su cambio:  "), 0, 1, 'R', 0);
  $pdf->SetXY(105, $pdf->GetY() - 10);
  $pdf->Cell(90, 11, utf8_decode("$".number_format($cambio, 2, '.', '')), 0, 1, 'L', 0);
  $pdf->SetFont('Arial', '', 27);
  $pdf->SetXY(30, $pdf->GetY());
  $pdf->Cell(150, 11, utf8_decode('¡GRACIAS POR SU COMPRA!'), 0, 1, 'C', 0);
  $pdf->SetFont('Arial', '', 20);
  $pdf->SetXY(30, $pdf->GetY());
  $pdf->Cell(150, 11, utf8_decode('No se hacen cambios ni devoluciones'), 0, 1, 'C', 0);

  $pdf->IncludeJS("print('true');"); 
  $pdf->Output();
?>