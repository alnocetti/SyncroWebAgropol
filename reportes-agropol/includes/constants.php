<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("America/Argentina/Buenos_Aires");
header('Content-Type: text/html; charset=utf-8');

//defines de las Tablas de Bases de Datos.
define("DB_SERVER", "localhost");
define("DB_NAME", "reportesagropol");
define("DB_USER", "root");
define("DB_PASSWORD", "agro2020");

//defines wsCargaReportes JSON
define("CARPETA_JSON", "json/");
define("ARCHIVO_ANALISIS", "Analisis.json");
define("ARCHIVO_COMPROBANTES", "Comprobantes.json");
define("ARCHIVO_CONTRATOS", "Contratos.json");
define("ARCHIVO_CUENTAS", "Cuentas.json");
define("ARCHIVO_CUENTAS_CORRIENTES", "CuentasCorrientes.json");
define("ARCHIVO_DESCARGAS", "Descargas.json");
define("ARCHIVO_PRODUCTOS", "Productos.json");
define("ARCHIVO_PUERTOS", "Puertos.json");
define("ARCHIVO_VENCIMIENTOS", "Vencimientos.json");

//defines LOG
define("CARPETA_LOG", "log/");
define("ARCHIVO_LOG", "log.log");

//defines de la cuenta
define("NUMERO_CUENTA", "010014");
define("NOMBRE_CUENTA", "FRANCISCO SELLART S.A.");
?>