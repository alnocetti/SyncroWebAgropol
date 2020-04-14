<?php
include("includes/constants.php");
include("includes/functions.php");
set_time_limit(0);

$contrato=$_GET['contrato'];

$link=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_NAME);
$query = mysqli_query($link,"SELECT * FROM contratos WHERE Contrato=$contrato");
$row = mysqli_fetch_array($query);
?>
<link rel="stylesheet" type="text/css" href="css/per.css">
<script src="javascript/functions.js"></script>

				<div style="position:absolute;top:0px;left:0;z-index:0">
					<div style="position:absolute;top:50px;left:50px;z-index:2">
					<table width="600">
						<tr>
							<td align="left" class="big" valign="top"><b>Slip de Negocio</b></td>
							<td align="left"><b>Contrato Número</b> <?=htmlentities($row["Contrato"])?><br><br>
											 Número de Comprador <?=htmlentities($row["NumeroComprador"])?><br><br>
											 Fecha del Contrato <?=formatear(htmlentities($row["Fecha"]))?><br>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Modo de Operación</td>
							<td><?=formatear(htmlentities($row["Operacion"]))?></td>
						</tr>
						<tr>
							<td>Modalidad de Venta</td>
							<td><?=formatear(htmlentities($row["Venta"]))?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Vendedor</td>
							<td><?=formatear(htmlentities($row["Vendedor"]))?></td>
						</tr>
						<tr>
							<td>Comprador</td>
							<td><?=formatear(htmlentities($row["Comprador"]))?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Producto</td>
							<td><?=formatear(htmlentities($row["Producto"]))?></td>
						</tr>
						<tr>
							<td>Cosecha</td>
							<td><?=formatear(htmlentities($row["Cosecha"]))?></td>
						</tr>
						<tr>
							<td>Cantidad</td>
							<td><?=number_format(htmlentities($row["Cantidad"]), 0, ',', '.')?><?php if (strlen($row["CantidadTexto"])>0) echo " o " . formatear(htmlentities($row["CantidadTexto"]))?></td>
						</tr>
						<tr>
							<td>Precio</td>
							<td><?=formatear(htmlentities($row["Precio"]))?> <?=formatear(htmlentities($row["Moneda"]))?></td>
						</tr>
						<tr>
							<td>Condiciones</td>
							<td><?=formatear(htmlentities($row["Condiciones"]))?></td>
						</tr>
						<tr>
							<td>Tipo</td>
							<td><?=htmlentities($row["Tipo"])?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Plazo Contractual</td>
							<td><?=formatear(htmlentities($row["FechaInicio"]))?> al <?=formatear(htmlentities($row["FechaFin"]))?></td>
						</tr>
						<tr>
							<td>Fecha de Pago</td>
							<td><?=formatear(htmlentities($row["FechaPago"]))?></td>
						</tr>
						<tr>
							<td>Forma de Pago</td>
							<td><?=formatear(htmlentities($row["FormaPago"]))?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Procedencia</td>
							<td><?=formatear(htmlentities($row["Procedencia"]))?></td>
						</tr>
						<tr>
							<td>Destino</td>
							<td><?=formatear(htmlentities($row["Destino"]))?></td>
						</tr>
						<tr>
							<td>Puerto</td>
							<td><?=formatear(htmlentities($row["Puerto"]))?></td>
						</tr>
						<tr>
							<td>Puesto Sobre</td>
							<td><?=formatear(htmlentities($row["PuestoSobre"]))?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="button" name="Cerrar" value="Cerrar" class="button" onClick="window.close()"></td>
						</tr>
					</table>
				</div>
			</div>
			<?mysqli_close($link);?>