<?php
	/** DATOS DEL EMISOR **/
	//$rfc_emisor = "HEHV920512FX6";

	$rfc_emisor = "AAA010101AAA";

	$nombre_emisor = "VIVIANA PATRICIA HERNANDEZ HUIZAR";
	$calle_emisor = "RIO CONCHOS";
	$noext_emisor = "1460";
	$colonia_emisor = "MAGDALENAS";
	$municipio_emisor = "TORREON"; 
	$estado_emisor = "COAHUILA";
	$pais_emisor = "MEXICO";
	$cp_emisor = "27010";
	$regimen_emisor = "Régimen de actividades empresariales";

	/** DOCUMENTOS DEL EMISOR **/

	// $rutaCertificado = "documentos/HEHV920512FX6.cer";
	// $rutaLlave = "documentos/HEHV920512FX6.key.pem";
	// $rutaSerial = "documentos/HEHV920512FX6.txt";

	$rutaCertificado = "../documents/CSD01_AAA010101AAA.cer";
	$rutaLlave = "../documents/CSD01_AAA010101AAA.key.pem";
	$rutaSerial = "../documents/CSD01_AAA010101AAA.txt";

	/** DATOS PARA TIMBRADO **/

	// $url_timbrado = "https://t2.facturacionmoderna.com/timbrado/wsdl";
	// $user_id = "RSI110228L88";
	// $user_password = "6a4f0d7deb9903659b378c3f3546518654f87bb1";

	$url_timbrado = "https://t1demo.facturacionmoderna.com/timbrado/wsdl";
	$user_id = "UsuarioPruebasWS";
	$user_password = "b9ec2afa3361a59af4b4d102d3f704eabdf097d4";
?>