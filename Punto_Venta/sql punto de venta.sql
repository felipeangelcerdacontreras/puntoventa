
Use prodika_punto_venta;

Create table datos_usuarios(
	id_user int auto_increment primary key,
	nombre varchar(50),
	direccion varchar(150),
	telefono varchar(20),
	correo varchar(50)
);

Create table usuarios(
	id int auto_increment primary key,
	id_user int,
	user varchar(25),
	pass varchar(25),
	tipo varchar(25),
	codigo_cancelar varchar(25) null,
	crear int,
	modificar int,
	eliminar int,
	foreign key(id_user) references datos_usuarios(id_user)
);

Create table materia_prima(
	id_materiaP int auto_increment primary key,
	nombre_matP varchar(50),
	cantidad decimal(8,3),
	pto_reorden decimal(8,3)
);

Create table producto(
	id_producto int auto_increment primary key,
	id_matP int,
	clave varchar(20),
	nombre varchar(40),
	precio_unitario decimal(13,2),
	unidad_medida varchar(5),
	foreign key(id_matP) references materia_prima(id_materiaP)
);

Create table cliente(
	id_cliente int auto_increment primary key,
	rfc_cliente varchar(13),
	nombre_cliente varchar(50),
	calle_cliente varchar(50),
	noExt_cliente varchar(5),
	col_cliente varchar(50),
	municipio_cliente varchar(30),
	edo_cliente varchar(20),
	pais_cliente varchar(30),
	cp_cliente varchar(6)
);

Create table venta(
	id_venta int auto_increment primary key,
	id_cliente int null,
	fecha datetime,
	hora time,
	forma_pago varchar(40),
	forma_pago2 varchar(40) null,
	total decimal(13,2),
	id_user int,
	venta_cancelada int null,
	nro_cuenta int null,
	monto_tarjeta decimal(13,2) null,
	monto_efectivo decimal(13,2) null,
	foreign key(id_user) references usuarios(id),
	foreign key(id_cliente) references cliente(id_cliente)
);

Create table abonos(
	id_abono int auto_increment primary key,
	idAbono_cuenta int null,
	fecha_abono date,
	id_user int,
	monto_abono decimal(13,2),
	foreign key(id_user) references usuarios(id)
);

Create table venta_mayoreo(
	id_venta int auto_increment primary key,
	idVenta int null,
	fecha datetime,
	hora time,
	kilos decimal(8,3),
	cliente varchar(50),
	forma_pago varchar(40),
	total decimal(13,2),
	id_user int,
	foreign key(id_user) references usuarios(id)
);

Create table venta_detalle(
	id_venta_detalle int auto_increment primary key,
	id_venta int,
	id_articulo int,
	precio_venta_si decimal(13,2),
	cantidad decimal(8,3),
	importe decimal(13,2),
	total decimal(13,2),
	foreign key(id_venta) references venta(id_venta)
);

Create table xml(
	id int auto_increment primary key,
	version varchar(5),
	folio int,
	fecha datetime,
	sello varchar(500),
	forma_pago varchar(40),
	no_certificado varchar(30),
	certificado varchar(2400),
	subtotal decimal(13,2),
	tipo_cambio varchar(10),
	moneda varchar(4),
	total decimal(13,2),
	metodo_pago varchar(5),
	condiciones_pago varchar(50),
	lugar_expedicion varchar(30),
	tipo_comprobante varchar(8),
	FolioFiscalOrig varchar(50),
	SerieFolioFiscalOrig varchar(30),
	FechaFolioFiscalOrig datetime,
	MontoFolioFiscalOrig decimal(13,2),
	rfc_emisor varchar(13),
	nombre_emisor varchar(50),
	calle_emisor varchar(50),
	noext_emisor varchar(5),
	colonia_emisor varchar(50),
	municipio_emisor varchar(30),
	estado_emisor varchar(20),
	pais_emisor varchar(30),
	cp_emisor varchar(6),
	expEn_calle varchar(50),
	expEn_noext varchar(5),
	expEn_colonia varchar(50),
	expEn_estado varchar(20),
	expEn_pais varchar(30),
	expEn_cp varchar(6),
	regimen_emisor varchar(50),
	rfc_receptor varchar(13),
	nombre_receptor varchar(50),
	calle_receptor varchar(50),
	noext_receptor varchar(5),
	colonia_receptor varchar(50),
	municipio_receptor varchar(30),
	estado_receptor varchar(20),
	pais_receptor varchar(30),
	cp_receptor varchar(6),
	total_impuestos_tras decimal(13,2),
	sello_sat varchar(500),
	nocertificado_sat varchar(30),
	sello_cfd varchar(500),
	fecha_timbrado datetime,
	uuid varchar(50),
	version_timbre varchar(5),
	id_venta int,
	cancelada int null,
	foreign key(id_venta) references venta(id_venta)
);

Create table conceptos(
	id int auto_increment primary key,
	id_xml int,
	valorUnitario decimal(13,2),
	descripcion varchar(200),
	cantidad decimal(8,3),
	importe decimal(13,2),
	unidad varchar(10),
	foreign key(id_xml) references xml(id)
);

Create table xmlNC(
	id int auto_increment primary key,
	version varchar(5),
	folio int,
	fecha datetime,
	sello varchar(500),
	forma_pago varchar(40),
	no_certificado varchar(30),
	certificado varchar(2400),
	subtotal decimal(13,2),
	tipo_cambio varchar(10),
	moneda varchar(4),
	total decimal(13,2),
	metodo_pago varchar(5),
	condiciones_pago varchar(50),
	lugar_expedicion varchar(30),
	tipo_comprobante varchar(8),
	FolioFiscalOrig varchar(50),
	SerieFolioFiscalOrig varchar(30),
	FechaFolioFiscalOrig datetime,
	MontoFolioFiscalOrig decimal(13,2),
	rfc_emisor varchar(13),
	nombre_emisor varchar(50),
	calle_emisor varchar(50),
	noext_emisor varchar(5),
	colonia_emisor varchar(50),
	municipio_emisor varchar(30),
	estado_emisor varchar(20),
	pais_emisor varchar(30),
	cp_emisor varchar(6),
	expEn_calle varchar(50),
	expEn_noext varchar(5),
	expEn_colonia varchar(50),
	expEn_estado varchar(20),
	expEn_pais varchar(30),
	expEn_cp varchar(6),
	regimen_emisor varchar(50),
	rfc_receptor varchar(13),
	nombre_receptor varchar(50),
	calle_receptor varchar(50),
	noext_receptor varchar(5),
	colonia_receptor varchar(50),
	municipio_receptor varchar(30),
	estado_receptor varchar(20),
	pais_receptor varchar(30),
	cp_receptor varchar(6),
	total_impuestos_tras decimal(13,2),
	sello_sat varchar(500),
	nocertificado_sat varchar(30),
	sello_cfd varchar(500),
	fecha_timbrado datetime,
	uuid varchar(50),
	version_timbre varchar(5),
	id_venta int,
	cancelada int null,
	foreign key(id_venta) references venta(id_venta)
);

Create table conceptosNC(
	id int auto_increment primary key,
	id_xml int,
	valorUnitario decimal(13,2),
	descripcion varchar(200),
	cantidad decimal(8,3),
	importe decimal(13,2),
	unidad varchar(10),
	foreign key(id_xml) references xml(id)
);

Create table impuestos_trasladados(
	id int auto_increment primary key,
	id_xml int,
	impuesto varchar(10),
	tasa decimal(8,2),
	importe decimal(13,2),
	foreign key(id_xml) references xml(id)
);

Create table peso(
	id_peso int auto_increment primary key,
	kilos varchar(10)
);

Create table caja(
	id_caja int auto_increment primary key,
	id_user int,
	monto_contenido decimal(12,2),
	limite decimal(12,2),
	minimo decimal(12,2),
	foreign key(id_user) references usuarios(id)
);

Create table retiros(
	id_retiro int auto_increment primary key,
	id_caja int,
	fecha datetime,
	monto decimal(12,2),
	foreign key(id_caja) references caja(id_caja)
);

Insert into datos_usuarios values(null, "Rodiva", "C. ...", "0007350325", "ventas@rodiva.com.mx");
Insert into usuarios values(null, 1, "suser", "123", "Administrador", "cancela123", 1, 1, 1);

Insert into materia_prima values(null, "Pulpa", 120, 15),
(null, "Carbon", 50, 6);


Insert into producto values(null, 1, "MIL", "Milanesa", 48.16, 'KG'),
(null, 1, "MOL", "Molida", 32.13, 'KG'),
(null, 1, "CRT", "Cortadillo", 52.12, 'KG'),
(null, 2, "CRB", "Carbon", 29.12, 'PZ');