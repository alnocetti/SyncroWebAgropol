<?php
switch ($reporte) {
    case "cuentascorrientes":
        if ($_POST['moneda']!="") $moneda=$_POST['moneda'];
		if ($_POST['desde']!="" && validarFecha($_POST['desde'])) 
			$desde=$_POST['desde'];
		else
			$desde=date('d-m-Y',strtotime(date('d-m-Y')."- 1 month"));
		if ($_POST['hasta']!="" && validarFecha($_POST['hasta'])) 
			$hasta=$_POST['hasta'];
		else
			$hasta=date('d-m-Y');
		?>
		Moneda
		<select name="moneda">
			<option value="ARS" <?php if ($moneda=="ARS") echo "selected"?>>Pesos</option>
			<option value="USD" <?php if ($moneda=="USD") echo "selected"?>>D&oacute;lares</option>
			<option value="0" <?php if ($moneda=="0") echo "selected"?>>Ambas</option>
		</select>
		Desde
		<input name="desde" size="10" value="<?=$desde?>">
		Hasta
		<input name="hasta" size="10" value="<?=$hasta?>">
		<?php
        break;
    case "vencimientos":
        $nombreReporte="Consulta de Vencimientos";
		if ($_POST['moneda']!="") $moneda=$_POST['moneda'];
		if ($_POST['comprobante']!="") $comprobante=$_POST['comprobante'];
		if ($_POST['desde']!="" && validarFecha($_POST['desde'])) 
			$desde=$_POST['desde'];
		else
			$desde=date('d-m-Y',strtotime(date('d-m-Y')."- 1 month"));
		if ($_POST['hasta']!="" && validarFecha($_POST['hasta'])) 
			$hasta=$_POST['hasta'];
		else
			$hasta=date('d-m-Y');
		?>
		Moneda
		<select name="moneda">
			<option value="ARS" <?php if ($moneda=="ARS") echo "selected"?>>Pesos</option>
			<option value="USD" <?php if ($moneda=="USD") echo "selected"?>>D&oacute;lares</option>
			<option value="0" <?php if ($moneda=="0") echo "selected"?>>Ambas</option>
		</select>
		Comprobante
		<select name="comprobante">
			<option value="0" <?php if ($comprobante=="0") echo "selected"?>>Todos</option>
			<option value="FC" <?php if ($comprobante=="FC") echo "selected"?>>Factura</option>
			<option value="ND" <?php if ($comprobante=="ND") echo "selected"?>>N.D&eacute;bito</option>
			<option value="NC" <?php if ($comprobante=="NC") echo "selected"?>>N.Cr&eacute;dito</option>
			<option value="LP" <?php if ($comprobante=="LP") echo "selected"?>>Liq.Parcial</option>
			<option value="LF" <?php if ($comprobante=="LF") echo "selected"?>>Liq.Final</option>
		</select>
		Desde
		<input name="desde" size="10" value="<?=$desde?>">
		Hasta
		<input name="hasta" size="10" value="<?=$hasta?>">
		<?php
        break;
    case "contratos":
        if ($_POST['intervalo']!="") $intervalo=$_POST['intervalo'];
		if ($_POST['cereal']!="") $cereal=$_POST['cereal'];
		if ($_POST['puerto']!="") $puerto=$_POST['puerto'];
		if ($_POST['desde']!="" && validarFecha($_POST['desde'])) 
			$desde=$_POST['desde'];
		else
			$desde=date('d-m-Y',strtotime(date('d-m-Y')."- 1 month"));
		if ($_POST['hasta']!="" && validarFecha($_POST['hasta'])) 
			$hasta=$_POST['hasta'];
		else
			$hasta=date('d-m-Y');
		?>
		Intervalo
		<select name="intervalo">
			<option value="0" <?php if ($intervalo=="0") echo "selected"?>>Completo</option>
			<option value="FN" <?php if ($intervalo=="FN") echo "selected"?>>Fecha de Negocio</option>
			<option value="PE" <?php if ($intervalo=="PE") echo "selected"?>>Per&iacute;odo de Entrega</option>
		</select>
		Cereal
		<select name="cereal">
			<option value="0" <?php if ($cereal=="0") echo "selected"?>>Todos</option>
			<?php
			$query = mysqli_query($link,"SELECT NombreProducto FROM Productos WHERE NombreProducto<>''");
			while ($row=@mysqli_fetch_array($query)){
				?>
				<option value="<?php echo $row["NombreProducto"]?>" <?php if ($cereal==$row["NombreProducto"]) echo "selected"?>><?php echo $row["NombreProducto"]?></option>	
			<?php
			}
			?>			
		</select>
		Puerto
		<select name="puerto">
			<option value="0" <?php if ($puerto=="0") echo "selected"?>>Todos</option>
			<?php
			$query = mysqli_query($link,"SELECT NombrePuerto FROM Puertos");
			while ($row=@mysqli_fetch_array($query)){
				?>
				<option value="<?php echo $row["NombrePuerto"]?>" <?php if ($puerto==$row["NombrePuerto"]) echo "selected"?>><?php echo $row["NombrePuerto"]?></option>	
			<?php
			}
			?>			
		</select>
		<br><br>
		Desde
		<input name="desde" size="10" value="<?=$desde?>">
		Hasta
		<input name="hasta" size="10" value="<?=$hasta?>">
		<?php
        break;
	case "descargas":
        $nombreReporte="Consulta de Descargas";
        if ($_POST['contrato']!="") $contrato=$_POST['contrato'];
		if ($_POST['comprador']!="") $comprador=$_POST['comprador'];
		if ($_POST['desde']!="" && validarFecha($_POST['desde'])) 
			$desde=$_POST['desde'];
		else
			$desde=date('d-m-Y',strtotime(date('d-m-Y')."- 1 month"));
		if ($_POST['hasta']!="" && validarFecha($_POST['hasta'])) 
			$hasta=$_POST['hasta'];
		else
			$hasta=date('d-m-Y');
		?>
		Contrato
		<input name="contrato" size="10" value="<?=$contrato?>">
		Comprador
		<select name="comprador">
			<option value="0" <?php if ($comprador=="0") echo "selected"?>>Todos</option>
			<?php
			$query = mysqli_query($link,"SELECT RazonSocial FROM Cuentas");
			while ($row=@mysqli_fetch_array($query)){
				?>
				<option value="<?php echo $row["RazonSocial"]?>" <?php if ($comprador==$row["RazonSocial"]) echo "selected"?>><?php echo $row["RazonSocial"]?></option>	
			<?php
			}
			?>			
		</select>
		<br><br>
		Desde
		<input name="desde" size="10" value="<?=$desde?>">
		Hasta
		<input name="hasta" size="10" value="<?=$hasta?>">
		<?php
        break;
	case "analisis":
        $nombreReporte="Consulta de Análisis";
		if ($_POST['contrato']!="") $contrato=$_POST['contrato'];
		?>
		Contrato
		<input name="contrato" size="10" value="<?=$contrato?>">
        <?php
		break;
	case "comprobantes":
        $nombreReporte="Consulta de Comprobantes";
		if ($_POST['contrato']!="") $contrato=$_POST['contrato'];
		if ($_POST['comprobante']!="") $comprobante=$_POST['comprobante'];
		?>
		Contrato
		<input name="contrato" size="10" value="<?=$contrato?>">
		Comprobante
		<select name="comprobante">
			<option value="0" <?php if ($comprobante=="0") echo "selected"?>>Todos</option>
			<option value="FC" <?php if ($comprobante=="FC") echo "selected"?>>Factura</option>
			<option value="ND" <?php if ($comprobante=="ND") echo "selected"?>>N.D&eacute;bito</option>
			<option value="NC" <?php if ($comprobante=="NC") echo "selected"?>>N.Cr&eacute;dito</option>
			<option value="LP" <?php if ($comprobante=="LP") echo "selected"?>>Liq.Parcial</option>
			<option value="LF" <?php if ($comprobante=="LF") echo "selected"?>>Liq.Final</option>
		</select>
		<?php
        break;		
}
?>