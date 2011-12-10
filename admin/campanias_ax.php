<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ax = fRequest::get("ax");
$campania = fRequest::get("campania");
$res = "";

if($ax == "banner"){
	
	$banner = fRequest::get("banner");
	$qry = "SELECT * FROM pubbanner WHERE Banner = '".$banner."'";
	$res = $mysql_db->query($qry);
	foreach($res as $r){
		echo '<img src="../images/'.$r['Filename'].'" border="0" />';
	}
}


if($ax == "activar"){
	$qry = "UPDATE pubdisplay SET Estado = '1' WHERE Campana = ".$campania;
	$mysql_db->query($qry);
	header("Location: index.php?p=22&msg=activado#".$banner);
}

if($ax == "desactivar"){
	$qry = "UPDATE pubdisplay SET Estado = '0' WHERE Campana = ".$campania;
	$mysql_db->query($qry);
	header("Location: index.php?p=22&msg=desactivado#".$banner);
}

if($ax == "editar"){		

	$nombre = fRequest::get("nombre");
	$banner = fRequest::get("banner");
	$fecha_inicial = fRequest::get("fecha_inicial");
	$fecha_final = fRequest::get("fecha_final");
	$impresiones = fRequest::get("impresiones");
	if($impresiones == ""){ $impresiones = 'NULL'; }
	if(isset($_POST['novence']) && $_POST['novence'] != ""){
		$novence = fRequest::get("novence");
	}else{
		$novence = '0'; 
	}
	if(isset($_POST['contador']) && $_POST['contador'] != ""){
		$contador = fRequest::get("contador");
	}else{
		$contador = '0'; 
	}
	$frecuencia = fRequest::get("frecuencia");
	if($frecuencia == ""){ $frecuencia = 'NULL'; }
	$preferencia = fRequest::get("preferencia");
	if($preferencia == ""){ $preferencia = 'NULL'; }
	if(isset($_POST['nohistorial']) && $_POST['nohistorial'] != ""){
		$nohistorial = fRequest::get("nohistorial");
	}else{
		$nohistorial = '0'; 
	}
	if(isset($_POST['spot']) && $_POST['spot'] != ""){
		$spot = fRequest::get("spot");
	}else{
		$spot = '0'; 
	}
	if(isset($_POST['seccion']) && $_POST['seccion'] != ""){
		$sec = fRequest::get("seccion");
		$sec = explode("|",$sec);
		$spot = $sec[0];
		$seccion = $sec[1];
	}else{
		$seccion = '0'; 
	}
	
	$res = $mysql_db->query("Select (Max(asignacion)+1) as siguiente FROM pubdisplaydetail WHERE Campana = ".$campania);
	foreach($res as $r){
		$asignacion = $r['siguiente'];
	}
	
	$qry = "UPDATE pubdisplay SET Nombre = '$nombre',Banner = '$banner',Fecha_ini = '$fecha_inicial',Fecha_fin = '$fecha_final',Impresiones = $impresiones, Contador = $contador, Novence = $novence, Frecuencia = $frecuencia, Preferencia = $preferencia, NoHistorial = $nohistorial WHERE Campana = $campania";
	$res2 = $mysql_db->query($qry);
	
	$qry = "INSERT INTO pubdisplaydetail (Campana, Asignacion, Spot, Seccion) Values ($campania, $asignacion, $spot, $seccion)";
	$res3 = $mysql_db->query($qry);

	echo "<script>opener.location.reload(); self.close();</script>";
	
}

if($ax == "crear"){
	
	$nombre = fRequest::get("nombre");
	$banner = fRequest::get("banner");
	$fecha_inicial = fRequest::get("fecha_inicial");
	$fecha_final = fRequest::get("fecha_final");
	$impresiones = fRequest::get("impresiones");
	if($impresiones == ""){ $impresiones = 'NULL'; }
	if(isset($_POST['novence']) && $_POST['novence'] != ""){
		$novence = fRequest::get("novence");
	}else{
		$novence = '0'; 
	}
	if(isset($_POST['contador']) && $_POST['contador'] != ""){
		$contador = fRequest::get("contador");
	}else{
		$contador = '0'; 
	}
	$frecuencia = fRequest::get("frecuencia");
	if($frecuencia == ""){ $frecuencia = 'NULL'; }
	$preferencia = fRequest::get("preferencia");
	if($preferencia == ""){ $preferencia = 'NULL'; }
	if(isset($_POST['nohistorial']) && $_POST['nohistorial'] != ""){
		$nohistorial = fRequest::get("nohistorial");
	}else{
		$nohistorial = '0'; 
	}
	if(isset($_POST['spot']) && $_POST['spot'] != ""){
		$spot = fRequest::get("spot");
	}else{
		$spot = '0'; 
	}
	if(isset($_POST['seccion']) && $_POST['seccion'] != ""){
		$seccion = fRequest::get("seccion");
	}else{
		$seccion = '0'; 
	}
   	$asignacion = 1;
	
	$qry = "INSERT INTO pubdisplay (Nombre,Banner,Fecha_ini, Fecha_fin, Impresiones, Contador, Novence, Frecuencia, Preferencia, NoHistorial,Estado) VALUES ('$nombre','$banner','$fecha_inicial','$fecha_final',$impresiones,$contador,$novence,$frecuencia,$preferencia, $nohistorial,1)";
	$res2 = $mysql_db->query($qry);
	$campania = $res2->getAutoIncrementedValue();
	
	$qry = "INSERT INTO pubdisplaydetail (Campana, Asignacion, Spot, Seccion) Values ($campania, $asignacion, $spot, $seccion)";
	$res3 = $mysql_db->query($qry);

	echo "<script>opener.location.reload(); self.close();</script>";
	
}
?>