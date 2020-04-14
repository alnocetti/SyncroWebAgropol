<?php
include("includes/constants.php");
include("includes/functions.php");

$mensaje="";
$aJSONSalida=Array(); 
$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_NAME);

cargaJSONenBaseDeDatos("Cuentas",CARPETA_JSON.ARCHIVO_CUENTAS,$mensaje,$link,$aJSONSalida);
cargaJSONenBaseDeDatos("Productos",CARPETA_JSON.ARCHIVO_PRODUCTOS,$mensaje,$link,$aJSONSalida);
cargaJSONenBaseDeDatos("Puertos",CARPETA_JSON.ARCHIVO_PUERTOS,$mensaje,$link,$aJSONSalida);
cargaJSONenBaseDeDatos("Comprobantes",CARPETA_JSON.ARCHIVO_COMPROBANTES,$mensaje,$link,$aJSONSalida);
cargaJSONenBaseDeDatos("Descargas",CARPETA_JSON.ARCHIVO_DESCARGAS,$mensaje,$link,$aJSONSalida);
cargaJSONenBaseDeDatos("Vencimientos",CARPETA_JSON.ARCHIVO_VENCIMIENTOS,$mensaje,$link,$aJSONSalida);
cargaJSONenBaseDeDatos("Contratos",CARPETA_JSON.ARCHIVO_CONTRATOS,$mensaje,$link,$aJSONSalida);
cargaJSONenBaseDeDatos("Analisis",CARPETA_JSON.ARCHIVO_ANALISIS,$mensaje,$link,$aJSONSalida);
cargaJSONenBaseDeDatos("CuentasCorrientes",CARPETA_JSON.ARCHIVO_CUENTAS_CORRIENTES,$mensaje,$link,$aJSONSalida);

mysqli_close($link);

echo json_encode($aJSONSalida);

//echo $mensaje;
$mensaje = rtrim($mensaje,"<br>");
$mensaje=str_replace("<br>","\n",$mensaje);

$log=file_get_contents(CARPETA_LOG.ARCHIVO_LOG);
if($log!="") $mensaje.="\n".file_get_contents(CARPETA_LOG.ARCHIVO_LOG);
file_put_contents(CARPETA_LOG.ARCHIVO_LOG, date("Y-m-d H:i:s"). " " .$mensaje);
?>  