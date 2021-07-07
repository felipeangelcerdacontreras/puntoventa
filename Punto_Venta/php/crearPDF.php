<?php  
    include 'conexion.php';
    require('../fpdf/fpdf.php');
    include '../qrcode/qrlib.php';

    date_default_timezone_set('America/Mexico_City');

    $id_xml = $_GET['id_xml'];

    $fechaNom = date("dmY_His");

    $conceptos = mysqli_query($con, "Select conceptos.* from conceptos where id_xml = $id_xml");
    $XML = mysqli_query($con, "Select xml.*, nro_cuenta from xml left join venta on venta.id_venta = xml.id_venta where id = $id_xml");

    $datos_xml = mysqli_fetch_array($XML);

    //DATOS EMISOR
    $nombre_emisor = $datos_xml['nombre_emisor'];
    $rfc_emisor = $datos_xml['rfc_emisor'];
    $direccion_emisor = $datos_xml['calle_emisor']." ".$datos_xml['noext_emisor']." COL. ".$datos_xml['colonia_emisor'].", ".$datos_xml['municipio_emisor'].", ".$datos_xml['estado_emisor'].", ".$datos_xml['pais_emisor'].", C.P. ".$datos_xml['cp_emisor'];
    $regimen_emisor = $datos_xml['regimen_emisor'];

    //DATOS RECEPTOR
    $rfc_receptor = $datos_xml['rfc_receptor'];
    $nombre_receptor = $datos_xml['nombre_receptor'];
    $direccion_receptor = $datos_xml['calle_receptor']." ".$datos_xml['noext_receptor'].", ".$datos_xml['colonia_receptor'].", ".$datos_xml['municipio_receptor'].", ".$datos_xml['estado_receptor'].", ".$datos_xml['pais_receptor'].", C.P. ".$datos_xml['cp_receptor'];

    //DATOS XML
    $folio = $datos_xml['folio'];
    $fecha = str_replace(' ','T', $datos_xml['fecha']);
    $noCertificado = $datos_xml['no_certificado'];
    $lugar_expedicion = $datos_xml['lugar_expedicion'];
    $noCertificado_sat = $datos_xml['nocertificado_sat'];
    $fecha_timbrado = str_replace(' ','T', $datos_xml['fecha_timbrado']);
    $uuid = $datos_xml['uuid'];
    $uuid1 = substr($uuid, 0, 19);
    $uuid2 = substr($uuid, 19, 17);
    $sello = $datos_xml['sello'];
    $sello_sat = $datos_xml['sello_sat'];
    $version_timbre = $datos_xml['version_timbre'];

    $subtotal = $datos_xml['subtotal'];
    $impuestos = $datos_xml['total_impuestos_tras'];
    $total = $datos_xml['total'];
    $metodoPago = $datos_xml['metodo_pago'];
    $formaPago = $datos_xml['forma_pago'];
    $nro_cuenta = $datos_xml['nro_cuenta'];

    $matrixPointSize = 10;
    $errorCorrectionLevel = 'L';
    $tempDir = '../img/temp.png'; 

    ob_start();
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetMargins(15,20,20);
    $pdf->SetAutoPageBreak(true,20);  
    $pdf->SetFont('Arial','B',16);
     

    //*****ESTA ES EL AREA DEL RECTANGULO DE TODA LA FORMA*****
    $pdf->Rect(10, 10, 190, 275, 'D');

    $pdf->SetXY(20, 20);
    $pdf->Cell(60, 0, $pdf->Image('../img/scnlogo2.png', 20, 20, 85, 25), 0, 0, 'C');

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  Datos Factura  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%//
    $pdf->SetFont('Arial','B', 10);
    $pdf->SetXY(123, 20);
    $pdf->Cell(40, 7, utf8_decode('Factura'), 0, 1, 'L', 0);
    $pdf->Rect(122, 26, 71, 50, 'D');
    $pdf->SetFont('Arial','', 9);
    $pdf->SetXY(124, 29);
    $pdf->Cell(40, 7, utf8_decode('Folio'), 0, 1, 'L', 0);
    $pdf->SetXY(124, 34);
    $pdf->Cell(40, 7, utf8_decode('Lugar y Fecha de'), 0, 1, 'L', 0);
    $pdf->SetXY(124, 38);
    $pdf->Cell(40, 7, utf8_decode('Emisión CFDI'), 0, 1, 'L', 0);
    $pdf->SetXY(124, 43);
    $pdf->Cell(40, 7, utf8_decode('Certificado CSD'), 0, 1, 'L', 0);
    $pdf->SetXY(124, 48);
    $pdf->Cell(40, 7, utf8_decode('Certificado SAT'), 0, 1, 'L', 0);
    $pdf->SetXY(124, 53);
    $pdf->Cell(40, 7, utf8_decode('Folio SAT'), 0, 1, 'L', 0);
    $pdf->SetXY(124, 57);
    $pdf->Cell(40, 7, utf8_decode(''), 0, 1, 'L', 0);
    $pdf->SetXY(124, 62);
    $pdf->Cell(40, 7, utf8_decode('Fecha Certificación'), 0, 1, 'L', 0);
    $pdf->SetXY(124, 66);
    $pdf->Cell(40, 7, utf8_decode('SAT'), 0, 1, 'L', 0);

    $pdf->SetXY(154, 29);
    $pdf->Cell(40, 7, utf8_decode($folio), 0, 1, 'L', 0);
    $pdf->SetXY(154, 34);
    $pdf->Cell(40, 7, utf8_decode($lugar_expedicion), 0, 1, 'L', 0);
    $pdf->SetXY(154, 38);
    $pdf->Cell(40, 7, utf8_decode($fecha), 0, 1, 'L', 0);
    $pdf->SetXY(154, 43);
    $pdf->Cell(40, 7, utf8_decode($noCertificado), 0, 1, 'L', 0);
    $pdf->SetXY(154, 48);
    $pdf->Cell(40, 7, utf8_decode($noCertificado_sat), 0, 1, 'L', 0);
    $pdf->SetXY(154, 53);
    $pdf->Cell(40, 7, utf8_decode($uuid1), 0, 1, 'L', 0);
    $pdf->SetXY(154, 57);
    $pdf->Cell(40, 7, utf8_decode($uuid2), 0, 1, 'L', 0);
    $pdf->SetXY(154, 62);
    $pdf->Cell(40, 7, utf8_decode($fecha_timbrado), 0, 1, 'L', 0);
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%//

    $pdf->SetFont('Arial','B', 10);
    $pdf->SetXY(20, 50);
    $pdf->Cell(40, 7, utf8_decode($nombre_emisor), 0, 1, 'L', 0);
    $pdf->SetFont('Arial','', 10);
    $pdf->SetXY(20, 55);
    $pdf->Cell(40, 7, utf8_decode('R.F.C. '.$rfc_emisor), 0, 1, 'L', 0);
    $pdf->SetXY(20, 62);
    $pdf->MultiCell(94, 4, utf8_decode($direccion_emisor), 0);
    $pdf->SetXY(20, 70);
    $pdf->Cell(40, 7, utf8_decode('Regimen Fiscal:'), 0, 1, 'L', 0);
    $pdf->SetXY(20, 75);
    $pdf->Cell(40, 7, utf8_decode($regimen_emisor), 0, 1, 'L', 0);


    $pdf->SetXY(18, 80);
    $pdf->Cell(178, 7, utf8_decode('__________________________________________________________________________________________'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial','B', 10);
    $pdf->SetXY(20, 86);
    $pdf->Cell(40, 7, utf8_decode('Receptor'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial','', 10);
    $pdf->SetXY(20, 93);
    $pdf->Cell(40, 7, utf8_decode('R.F.C.'), 0, 1, 'L', 0);
    $pdf->SetXY(20, 98);
    $pdf->Cell(40, 7, utf8_decode('Nombre'), 0, 1, 'L', 0);
    $pdf->SetXY(20, 103);
    $pdf->Cell(40, 7, utf8_decode('Dirección'), 0, 1, 'L', 0);

    $pdf->SetXY(45, 93);
    $pdf->Cell(40, 7, utf8_decode($rfc_receptor), 0, 1, 'L', 0);
    $pdf->SetXY(45, 98);
    $pdf->Cell(40, 7, utf8_decode($nombre_receptor), 0, 1, 'L', 0);
    $pdf->SetXY(45, 104);
    // $pdf->Cell(148, 7, utf8_decode($direccion_receptor), 1, 1, 'L', 0);
    $pdf->MultiCell(148, 5, utf8_decode($direccion_receptor), 0);
    $pdf->SetXY(18, 110);
    $pdf->Cell(178, 7, utf8_decode('__________________________________________________________________________________________'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial','B', 10);
    $pdf->SetXY(20, 119);
    $pdf->Cell(40, 7, utf8_decode('Cantidad'), 0, 1, 'L', 0);
    $pdf->SetXY(40, 117);
    $pdf->Cell(40, 7, utf8_decode('Unidad de'), 0, 1, 'L', 0);
    $pdf->SetXY(42, 121);
    $pdf->Cell(40, 7, utf8_decode('Medida'), 0, 1, 'L', 0);
    $pdf->SetXY(60, 119);
    $pdf->Cell(40, 7, utf8_decode('Descripción'), 0, 1, 'L', 0);
    $pdf->SetXY(145, 119);
    $pdf->Cell(40, 7, utf8_decode('Valor unitario'), 0, 1, 'L', 0);
    $pdf->SetXY(175, 119);
    $pdf->Cell(40, 7, utf8_decode('Importe'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial','', 10);
    $mas = 126;
    while ($datos_concepto = mysqli_fetch_array($conceptos)) {
        $cantidad = $datos_concepto['cantidad'];
        $unidad = $datos_concepto['unidad'];
        $descrp = $datos_concepto['descripcion'];
        $valor_unitario = $datos_concepto['valorUnitario'];
        $importe = number_format($datos_concepto['importe'], 2);

        $pdf->SetXY(20, $mas);
        $pdf->Cell(40, 7, utf8_decode($cantidad), 0, 1, 'L', 0);
        $pdf->SetXY(42, $mas);
        $pdf->Cell(40, 7, utf8_decode($unidad), 0, 1, 'L', 0);
        $pdf->SetXY(60, $mas);
        $pdf->Cell(40, 7, utf8_decode($descrp), 0, 1, 'L', 0);
        $pdf->SetXY(145, $mas);
        $pdf->Cell(40, 7, utf8_decode($valor_unitario), 0, 1, 'L', 0);
        $pdf->SetXY(165, $mas);
        $pdf->Cell(26, 7, utf8_decode($importe), 0, 1, 'R', 0);
        $mas = $mas + 5;
    }
    $pdf->SetXY(18, $mas-3);
    $pdf->Cell(178, 7, utf8_decode('__________________________________________________________________________________________'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial','B', 10);

    $pdf->SetXY(145, $mas+2);
    $pdf->Cell(40, 7, utf8_decode('Sub-total'), 0, 1, 'L', 0);
    $pdf->SetXY(145, $mas+7);
    $pdf->Cell(40, 7, utf8_decode('Total'), 0, 1, 'L', 0);

    $pdf->SetXY(165, $mas+2);
    $pdf->Cell(26, 7, number_format($subtotal, 2), 0, 1, 'R', 0);
    $pdf->SetXY(165, $mas+7);
    $pdf->Cell(26, 7, number_format($total, 2), 0, 1, 'R', 0);

    $pdf->SetFont('Arial','', 10);
    $pdf->SetXY(20, $mas+12);
    $pdf->Cell(40, 7, utf8_decode('Condiciones de Pago: CONTADO'), 0, 1, 'L', 0);
    $pdf->SetXY(80, $mas+12);
    $pdf->Cell(112, 7, utf8_decode('Efectos fiscales al pago | '.$formaPago), 0, 1, 'R', 0);
    $pdf->SetXY(20, $mas+5);
    $pdf->Cell(40, 7, utf8_decode('Método de pago: '.$metodoPago), 0, 1, 'L', 0);

    if($nro_cuenta != null && $metodoPago!=99) {
        $pdf->SetXY(70, $mas+5);
        $pdf->Cell(40, 7, utf8_decode('Número de cuenta de Pago: '.$nro_cuenta), 0, 1, 'R', 0);
    }


    $pdf->SetFont('Arial','B', 10);
    $pdf->SetXY(20, $mas+18);
    $pdf->Cell(172, 6, utf8_decode('Cantidad con letra'), 1, 1, 'C', 0);
    $pdf->SetXY(20, $mas+24);
    $pdf->Cell(172, 6, utf8_decode(numtoletras($total)), 1, 1, 'C', 0);

    $pdf->Rect(20, $mas+32, 172, 78, 'D');
    $pdf->SetXY(23, $mas+34);
    $pdf->Cell(40, 7, utf8_decode('Sello digital del CFDI:'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial','', 8);
    $pdf->SetXY(23, $mas+41);
    $pdf->MultiCell(123, 4, utf8_decode($sello), 0);
    $pdf->SetFont('Arial','', 10);
    $pdf->SetXY(23, $mas+56);
    $pdf->Cell(40, 7, utf8_decode('Sello del SAT:'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial','', 8);
    $pdf->SetXY(23, $mas+63);
    $pdf->MultiCell(123, 4, utf8_decode($sello_sat), 0);
    $pdf->SetFont('Arial','', 10);
    $pdf->SetXY(23, $mas+85);
    $pdf->Cell(40, 7, utf8_decode('Cadena original del complemento de certificación digital del SAT:'), 0, 1, 'L', 0);
    $cadena = "||".$version_timbre."|".$uuid."|".$fecha_timbrado."|".$sello."|".$noCertificado_sat."||";
    $pdf->SetFont('Arial','', 8);
    $pdf->SetXY(23, $mas+92);
    $pdf->MultiCell(123, 4, utf8_decode($cadena), 0);

    $pdf->SetXY(149, $mas+41);
    QRcode::png('?re='.$rfc_emisor.'&rr='.$rfc_receptor."&tt=".$total."&id=".$uuid, $tempDir, $errorCorrectionLevel, $matrixPointSize, .1);
    $pdf->Cell(0, 12, $pdf->Image($tempDir, 149, $mas+34, 38), 0, 1, 'C');

    $pdf->Output();
    $nombre = "Factura_".$datos_xml['rfc_receptor']."_".$datos_xml['folio']."_".$fechaNom.".pdf";

    // $pdf->Output($nombre,'D');
    mysqli_close($con);
    ob_end_flush();

    function numtoletras($xcifra)
    {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );

        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                                
                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                                
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                                
                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN PESO $xdecimales/100 M.N. ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

    function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";

        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";

        return $xsub;
    }
?>