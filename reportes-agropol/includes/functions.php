<?php
function formatear($dato) {
	if (date('Y-m-d', strtotime($dato)) == $dato)
		if (is_null($dato))
			return "";
		else
			return date('d-m-Y', strtotime($dato));
    else {
      if (is_numeric($dato)){
		if($dato==0)
			return "-";
		else
			return number_format($dato, 2, ',', '.');
		}
	  else
			return $dato;
    }
}

function archivoJSON($tabla,$link,&$mensaje,&$archivoOK,$objectJSON,&$error){
	switch(json_last_error()) {
        case JSON_ERROR_NONE:
            $error.="sin errores";
			mysqli_query($link,"DELETE FROM $tabla");
			$archivoOK=true;
        break;
        case JSON_ERROR_DEPTH:
            $error.="excedido tamaño máximo de la pila";
        break;
        case JSON_ERROR_STATE_MISMATCH:
            $error.="desbordamiento de buffer o los modos no coinciden";
        break;
        case JSON_ERROR_CTRL_CHAR:
            $error.="encontrado carácter de control no esperado";
        break;
        case JSON_ERROR_SYNTAX:
            $error.="error de sintaxis, JSON mal formado";
        break;
        case JSON_ERROR_UTF8:
            $error.="caracteres UTF-8 malformados, posiblemente codificados de forma incorrecta";
        break;
        default:
            $error.="error desconocido";
        break;
		
		$mensaje.=$error;
	}
}

function cargaJSONenBaseDeDatos($entidadArchivo,$pathJSON,&$mensaje,$link,&$aJSONSalida){
	$data = file_get_contents($pathJSON);
	$registrosJSON = json_decode(utf8_encode($data),true);
	
	$archivoOK=false;
	$registrosOK=0;
	$registro=1;
	$camposQuery="";
	$error="";
	
	$mensaje.="Archivo $entidadArchivo: ";
	$objectJSON = new stdClass();
	$objectJSON->NombreArchivo = $entidadArchivo;
	archivoJSON($entidadArchivo,$link,$mensaje,$archivoOK,$objectJSON,$error);
	$objectJSON->MensajeArchivo=$error;
	
	if ($archivoOK){
		if ($entidadArchivo=="Comprobantes"||$entidadArchivo=="Descargas"||$entidadArchivo=="Vencimientos"||$entidadArchivo=="Contratos"||$entidadArchivo=="Analisis"||$entidadArchivo=="CuentasCorrientes"){
			switch($entidadArchivo){
				case "Comprobantes":
					foreach ($registrosJSON as $registroJSON) {
						$iCampo=0;
						if ($camposQuery!="") $camposQuery.="\n";
						foreach ($registroJSON as $campo){
							if(is_string($campo)|| strtotime($campo))
								$campo=addslashes($campo);
								
							if($iCampo==2) // COMPROBANTE
								$campo=convierteCodigoComprobante($campo);
									
							$camposQuery.="$campo,";
							$iCampo++;		
						}
						$registrosOK++;	
					}
					$camposQuery = rtrim($camposQuery,",");
					insertJSONaTabla($link,$entidadArchivo,$mensaje,$registrosOK,$camposQuery,$objectJSON);	
				break;
				case "Descargas":
					foreach ($registrosJSON as $registroJSON) {
						$iCampo=0;
						if ($camposQuery!="") $camposQuery.="\n";
						foreach ($registroJSON as $campo){
							if(is_string($campo)|| strtotime($campo))
								$campo=addslashes($campo);
							
							switch($iCampo){
								case 4: // PRODUCTO
									$campo=traerNombreProducto($campo,$link);
									break;
								case 5: // PUERTO
									$campo=traerNombrePuerto($campo,$link);
									break;
							}
							$camposQuery.="$campo,";	
							$iCampo++;	
						}
						$registrosOK++;	
					}
					$camposQuery = rtrim($camposQuery,",");
					insertJSONaTabla($link,$entidadArchivo,$mensaje,$registrosOK,$camposQuery,$objectJSON);	
				break;
				case "Vencimientos":
					foreach ($registrosJSON as $registroJSON) {
						$iCampo=0;
						if ($camposQuery!="") $camposQuery.="\n";
						foreach ($registroJSON as $campo){
							if ($iCampo!=5){ // CODIGO NO UTILIZADO
								if(is_string($campo)|| strtotime($campo)) 
									$campo=addslashes($campo);
										
								switch($iCampo){
									case 1: // MONEDA
										$campo=convierteCodigoMoneda($campo);
										break;
									case 2: // COMPROBANTE
										$campo=convierteCodigoComprobante($campo);
										break;
								}
								$camposQuery.="$campo,";
							}
							$iCampo++;
						}
						$registrosOK++;	
					}
					$camposQuery = rtrim($camposQuery,",");
					insertJSONaTabla($link,$entidadArchivo,$mensaje,$registrosOK,$camposQuery,$objectJSON);	
				break;
				case "Contratos":
					foreach ($registrosJSON as $registroJSON) {
						$iCampo=0;
						if ($camposQuery!="") $camposQuery.="\n";
						foreach ($registroJSON as $campo){
							if ($iCampo==17){ // FECHA PAGO NULL
								if($campo=="")
									$camposQuery.="\N,";
							}else{
								if(is_string($campo)|| strtotime($campo)) $campo=addslashes($campo);
									switch($iCampo){
										case 5: // VENDEDOR
											$campo=traerNombreCuenta($campo,$link);
											break;
										case 6: // COMPRADOR
											$campo=traerNombreCuenta($campo,$link);
											break;
										case 7: // PRODUCTO
											$campo=traerNombreProducto($campo,$link);
											break;
										case 12: // MONEDA
											$campo=convierteCodigoMoneda($campo);
											break;
										case 19: // PROCEDENCIA
											$campo=traerNombrePuerto($campo,$link);
											break;
										case 20: // DESTINO
											$campo=traerNombrePuerto($campo,$link);
											break;
										case 21: // PUERTO
											$campo=traerNombrePuerto($campo,$link);
											break;			
									}
								$camposQuery.="$campo,";	
							}
							$iCampo++;
						}
						$registrosOK++;
					}
					$camposQuery = rtrim($camposQuery,",");
					insertJSONaTabla($link,$entidadArchivo,$mensaje,$registrosOK,$camposQuery,$objectJSON);	
				break;
				case "Analisis":
					foreach ($registrosJSON as $registroJSON) {		
						$iCampo=0;
						if ($camposQuery!="") $camposQuery.="\n";
						foreach ($registroJSON as $campo){
							if(is_string($campo)|| strtotime($campo)){
								if ($iCampo==2 && is_numeric($campo)) // FECHA No viene en JSON se agrega como NULL
									$camposQuery.="\N,";
								$campo=addslashes($campo);
							}
							else{
								if ($iCampo==2 && is_numeric($campo)) // FECHA No viene en JSON se agrega como NULL
									$camposQuery.="\N,";
							}
							$iCampo++;
							$camposQuery.="$campo,";	
						}
						$registrosOK++;		
					}
					$camposQuery = rtrim($camposQuery,",");
					insertJSONaTabla($link,$entidadArchivo,$mensaje,$registrosOK,$camposQuery,$objectJSON);	
				break;
				case "CuentasCorrientes":
					$cuenta="";
					$monedaCorte=0;
					
					foreach ($registrosJSON as $registroJSON) {		
						if($cuenta!=$registroJSON["Cuenta"] || $monedaCorte!=$registroJSON["Moneda"]) $saldo=0;
							
						$cuenta=$registroJSON["Cuenta"];
						$moneda=convierteCodigoMoneda($registroJSON["Moneda"]);
						$monedaCorte=$registroJSON["Moneda"];
						$fecha=$registroJSON["Fecha"];
						$referencia=addslashes($registroJSON["Referencia"]);
						if($registroJSON["DebeHaber"]){
							$debe=$registroJSON["Saldo"];
							$haber=0;
						}else{
							$debe=0;
							$haber=$registroJSON["Saldo"];
						}
						if($saldo==0){
							$debe=0;
							$haber=0;
							$saldo=$registroJSON["Saldo"];	
						}else{
							$saldo+=$registroJSON["Saldo"];
						}
						$camposQuery.="$cuenta,$moneda,$fecha,$referencia,$debe,$haber,$saldo\n";
						$registrosOK++;
						
					}
					insertJSONaTabla($link,$entidadArchivo,$mensaje,$registrosOK,$camposQuery,$objectJSON);
				break;
			}
	}
	else{ // CUENTAS, PRODUCTOS y PUERTOS
			foreach ($registrosJSON as $registroJSON) {
				if ($camposQuery!="") $camposQuery.="\n";
				foreach ($registroJSON as $campo){
					if(is_string($campo)|| strtotime($campo))
						$campo=addslashes($campo);
					$camposQuery.="$campo,";
				}
				$registrosOK++;	
			}
			$camposQuery = rtrim($camposQuery,",");
			insertJSONaTabla($link,$entidadArchivo,$mensaje,$registrosOK,$camposQuery,$objectJSON);	
		}
	}
	$aJSONSalida[]=$objectJSON;
}
function traerNombreProducto($idProducto,$link){	
		$query = mysqli_query($link,"SELECT NombreProducto FROM Productos WHERE IdProducto='".str_pad($idProducto,3,"0",STR_PAD_LEFT)."'");
		$row = mysqli_fetch_array($query);
		return $row["NombreProducto"];
}
function traerNombrePuerto($idPuerto,$link){
		$query = mysqli_query($link,"SELECT NombrePuerto FROM Puertos WHERE IdPuerto='$idPuerto'");
		$row = mysqli_fetch_array($query);
		return $row["NombrePuerto"];
}
function traerNombreCuenta($idCuenta,$link){
		$query = mysqli_query($link,"SELECT RazonSocial FROM Cuentas WHERE IdCuenta='".str_pad($idCuenta,6,"0",STR_PAD_LEFT)."'");
		$row = mysqli_fetch_array($query);
		return $row["RazonSocial"];
}
function insertJSONaTabla($link,$entidadArchivo,&$mensaje,$registrosOK,$camposQuery,&$objectJSON){
	file_put_contents(CARPETA_LOG.$entidadArchivo.".txt", $camposQuery);
	mysqli_options($link, MYSQLI_OPT_LOCAL_INFILE, true);
	if (mysqli_query($link,"LOAD DATA LOCAL INFILE '".CARPETA_LOG.$entidadArchivo.".txt' INTO TABLE $entidadArchivo FIELDS TERMINATED BY ','LINES TERMINATED BY '\n'"))
		$resultado.="Se importaron $registrosOK registro/s!";
	else{
		$resultado.="Error: ".mysqli_error($link);
	}
	unlink(CARPETA_LOG.$entidadArchivo.".txt");
	$objectJSON->Mensaje=$resultado;
	$mensaje.="<br>".$resultado."<br>";	
}
function convierteCodigoComprobante($idComprobante){
	switch($idComprobante){
		case 1:return "FC";
		case 2:return "ND";
		case 3:return "NC";
		case 4:return "LP";
		case 5:return "LF";
	}	
}
function convierteCodigoMoneda($idMoneda){
	switch($idMoneda){
		case 1:return "ARS";
		case 2:return "USD";
	}	
}
function validarFecha($fecha){
	$valores = explode('-', $fecha);
	if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
		return true;
    }
	return false;
}
?>