<?php
include("includes/constants.php");
include("includes/functions.php");
set_time_limit(0);

$reporte=$_GET['reporte'];
$idCuenta=NUMERO_CUENTA;
$nombreCuenta=NOMBRE_CUENTA;
$contrato=0;
$group="";
$order="";
$error="";

switch ($reporte) {
    case "cuentascorrientes":
        $nombreReporte="Consulta de Ctas. Ctes.";
		$moneda=$_POST['moneda'];
		if (validarFecha($_POST['desde']))
			$fechaDesde=date('Y-m-d', strtotime($_POST['desde']));
		else{
			$fechaDesde=date('Y-m-d',strtotime(date('d-m-Y')."- 1 month"));
			if ($_POST['desde']!="") $error="Debe completar un intervalo de fechas v&aacute;lido (dd-mm-aaaa).";
		}
			
		if (validarFecha($_POST['hasta']))
			$fechaHasta=date('Y-m-d', strtotime($_POST['hasta']));
		else{
			$fechaHasta=date('Y-m-d');
			if ($_POST['hasta']!="") $error="Debe completar un intervalo de fechas v&aacute;lido (dd-mm-aaaa).";
		}
		$campos="Fecha,Referencia,Debe,Haber,Saldo";
		if ($moneda!="0") $where="AND Moneda='$moneda' ";
		$where.="AND ('$fechaDesde'<=Fecha AND Fecha<='$fechaHasta')";
        break;
    case "vencimientos":
        $nombreReporte="Consulta de Vencimientos";
		$moneda=$_POST['moneda'];
		$comprobante=$_POST['comprobante'];
		if (validarFecha($_POST['desde']))
			$fechaDesde=date('Y-m-d', strtotime($_POST['desde']));
		else{
			$fechaDesde=date('Y-m-d',strtotime(date('d-m-Y')."- 1 month"));
			if ($_POST['desde']!="") $error="Debe completar un intervalo de fechas v&aacute;lido (dd-mm-aaaa).";
		}
		if (validarFecha($_POST['hasta']))
			$fechaHasta=date('Y-m-d', strtotime($_POST['hasta']));
		else{
			$fechaHasta=date('Y-m-d');
			if ($_POST['hasta']!="") $error="Debe completar un intervalo de fechas v&aacute;lido (dd-mm-aaaa).";
		}
		$campos="Vencimiento as 'Vto',Fecha,Comprobante as 'Cod',NumeroComprobante as 'Comprobante',Contrato,Boleto,RazonSocial as 'Raz&oacute;n Social',Moneda as 'Mda',ImporteOriginal as 'Imp.Orig.',Saldo,Iva as 'IVA',ImporteNeto as 'Imp.Neto'";
		if ($moneda!="0") $where="AND Moneda='$moneda' ";
		if ($comprobante!="0") $where.="AND Comprobante='$comprobante' ";
		$where.="AND ('$fechaDesde'<=Fecha AND Fecha<='$fechaHasta')";
        break;
    case "contratos":
        $nombreReporte="Estad&iacute;stica de Negocio";
		$intervalo=$_POST['intervalo'];
		$cereal=$_POST['cereal'];
		$puerto=$_POST['puerto'];
		if (validarFecha($_POST['desde']))
			$fechaDesde=date('Y-m-d', strtotime($_POST['desde']));
		else{
			$fechaDesde=date('Y-m-d',strtotime(date('d-m-Y')."- 1 month"));
			if ($_POST['desde']!="") $error="Debe completar un intervalo de fechas v&aacute;lido (dd-mm-aaaa).";
		}
		if (validarFecha($_POST['hasta']))
			$fechaHasta=date('Y-m-d', strtotime($_POST['hasta']));
		else{
			$fechaHasta=date('Y-m-d');
			if ($_POST['hasta']!="") $error="Debe completar un intervalo de fechas v&aacute;lido (dd-mm-aaaa).";
		}
		$campos="Contrato as 'N&uacute;mero',Fecha,NumeroComprador as 'Boleto',Comprador as 'Contrapartida',Producto as 'Cereal',Cantidad as 'Kilos',Puerto,concat_ws(' al ', DATE_FORMAT(FechaInicio,'%d/%m/%Y'), DATE_FORMAT(FechaFin,'%d/%m/%Y')) as 'Plazo Contract.'";
		switch ($intervalo) {
			case "0":
				$where="";
				break;
			case "FN";
				$where="AND ('$fechaDesde'<=Fecha AND Fecha<='$fechaHasta') ";
				break;
			case "PE";
				$where="AND (('$fechaDesde'<=FechaInicio AND FechaInicio<='$fechaHasta') AND ('$fechaDesde'<=FechaFin AND FechaFin<='$fechaHasta')) ";
				break;
		}		
		if ($cereal!="0") $where.="AND Producto='$cereal' ";
		if ($puerto!="0") $where.="AND Puerto='$puerto' ";
        break;
	case "descargas":
        $nombreReporte="Consulta de Descargas";
		$contrato=$_POST['contrato'];
		$comprador=$_POST['comprador'];
		if (validarFecha($_POST['desde']))
			$fechaDesde=date('Y-m-d', strtotime($_POST['desde']));
		else{
			$fechaDesde=date('Y-m-d',strtotime(date('d-m-Y')."- 1 month"));
			if ($_POST['desde']!="") $error="Debe completar un intervalo de fechas v&aacute;lido (dd-mm-aaaa).";
		}
		if (validarFecha($_POST['hasta']))
			$fechaHasta=date('Y-m-d', strtotime($_POST['hasta']));
		else{
			$fechaHasta=date('Y-m-d');
			if ($_POST['hasta']!="") $error="Debe completar un intervalo de fechas v&aacute;lido (dd-mm-aaaa).";
		}
        $campos="Contrato,Fecha,Numero as 'N&uacute;mero',Producto as 'Cereal',Puerto,Kilos,Merma,CPorte as 'C.Porte',Procedencia";
		if ($contrato!="") $where="AND Contrato='$contrato' ";
		if ($comprador!="0") $where.="AND Contrato IN (SELECT Contrato FROM Contratos WHERE COMPRADOR ='$comprador') ";
		$where.="AND ('$fechaDesde'<=Fecha AND Fecha<='$fechaHasta')";
		break;
	case "analisis":
        $nombreReporte="Consulta de An&aacute;lisis";
		$contrato=$_POST['contrato'];
		$campos="Contrato,Fecha,Numero as 'N&uacute;mero',Kilos,Honorarios,ACargo as 'A Cargo',Grado,GROUP_CONCAT(Descripcion SEPARATOR'<br>') as 'Descrip.',GROUP_CONCAT(Litros SEPARATOR'<br>') as 'Lit.',GROUP_CONCAT(Porcion SEPARATOR'<br>') as 'Porc.'";
        if ($contrato!="") $where="AND Contrato='$contrato' ";
		$group="GROUP BY Contrato,Fecha,Numero,Kilos,Honorarios,ACargo,Grado";
		$order="ORDER BY Fecha,Numero";
        break;
	case "comprobantes":
        $nombreReporte="Consulta de Comprobantes";
		$contrato=$_POST['contrato'];
		$comprobante=$_POST['comprobante'];
		$campos="Contrato,Comprobante,Emision as 'Emisi&oacute;n',Numero as 'N&uacute;mero',Form1116 as 'Form. 1116',FechaEmision as 'F. Emisi&oacute;n',FechaVencimiento as 'F. Vecimiento',Total,Kilos";
        if ($contrato!="") $where="AND Contrato='$contrato' ";
		if ($comprobante!="0") $where.="AND Comprobante='$comprobante' ";
		break;		
}
$link=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_NAME);
?>
<link rel="stylesheet" type="text/css" href="css/per.css">
				<div style="position:absolute;top:0px;left:0;z-index:0">
					<div style="position:absolute;top:50px;left:101px;z-index:2">
					<table width="1000">
						<tr>
							<td align="left">
							<b>Usuario <?=$idCuenta?>-<?=$nombreCuenta?></b><br><br>
							<form id="frm" name="frm" method="post" action="mostrarReporte.php?reporte=<?=$reporte?>">
								<div class="big"><?=$nombreReporte?></div><br>
								<div><?php include("filtrosReporte.php");?>	
								<input type="submit" name="Consultar" value="Consultar" class="button">
								<?php
								if ($error!="") 
									echo "<br><br>".$error;
								else{
									if ($_POST['Consultar']!="" || $_GET['inicio']!=""){
									
										$inicio = 0;
										if ($_GET['inicio']!="") $inicio = intval($_GET['inicio']) * 100;
										?>
										</div>
										
										<?php
											$query = mysqli_query($link,"SELECT COUNT(*) as filas FROM " . $reporte . " WHERE IdCuenta=$idCuenta $where");
											$row = mysqli_fetch_array($query);
											$indice="";
											
											if (round($row["filas"]/100)>0){									
												$indice="<br> | ";
												
												for($i=0;$i<round($row["filas"]/100);$i++){
													$j=$i+1;
													$indice.="<a href='#' onClick='actualizar_reporte($i)'>" . $j . "</a> | ";	
												}
											}
											echo $indice;
											
											//echo("SELECT $campos FROM " . $reporte . " WHERE IdCuenta=$idCuenta $where $group $order LIMIT $inicio, 100");
											$query = mysqli_query($link,"SELECT $campos FROM " . $reporte . " WHERE IdCuenta=$idCuenta $where $group $order LIMIT $inicio, 100");
											echo ("<br><br><table border=\"1\" cellspacing=\"0\" cellpadding=\"3\" class=\"tablaUsuarios\"><tr>");
											while ($fields=@mysqli_fetch_field($query)) 
												{
													echo ("<th align=\"left\" style=\"background-color:#FFD14C\">".$fields->name."</th>");
													if($fields->name=="Contrato" && $reporte=="vencimientos") $contrato=1;
													if($fields->name=="N&uacute;mero" && $reporte=="contratos") $contrato=2;
													if($fields->name=="Contrato" && $reporte=="descargas") $contrato=3;
													if($fields->name=="Contrato" && $reporte=="analisis") $contrato=4;
													if($fields->name=="Contrato" && $reporte=="comprobantes") $contrato=5;
												}
											echo ("</tr>\n");
											while ($rows = mysqli_fetch_array($query)) 
												{
													echo ("<tr>");
													$numero=0;
													for ($x=0; $x<@mysqli_num_fields($query); $x++) 
														{
															if (($contrato==1 && $x==4) || ($contrato==2 && $x==0) || ($contrato==3 && $x==0) || ($contrato==4 && $x==0) || ($contrato==5 && $x==0))
																echo ("<td align=\"left\"><a href='contrato.php?contrato=".htmlentities($rows[$x])."' target='new'>".htmlentities($rows[$x])."</a></td>");
															elseif ( ($contrato==2 && ($x==5)) || ($contrato==3 && ($x==5 || $x==6)) || ($contrato==4 && ($x==2 || $x==3)) || ($contrato==5 && $x==8))
																echo ("<td align=\"left\">".number_format($rows[$x],0,',','.')."</td>");
															elseif (($contrato==1 && $x==3) || ($contrato==3 && $x==7) || ($contrato==4 && ($x==6 || $x==7 || $x==8 || $x==9)) || (($contrato==5) &&($x==2 || $x==3 || $x==4)))
																echo ("<td align=\"left\">".$rows[$x]."</td>");
															else
																echo ("<td align=\"left\">".formatear(htmlentities($rows[$x]))."</td>");
														}
													echo ("</tr>\n");
												}
											echo ("</table>");
											echo $indice;
											
										mysqli_close($link);
										}
									}
									?>
							</form>
							</td>
						</tr>
					</table>
					</div>
				</div>
<script>
function actualizar_reporte(indice){
	document.getElementById("frm").action="mostrarReporte.php?reporte=<?php echo $reporte?>&inicio="+indice;
	document.getElementById("frm").submit();
}	
</script>
