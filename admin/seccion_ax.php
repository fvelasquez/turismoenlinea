<?php
include ("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

$p			= fRequest::get('p');
$tabla 		= fRequest::get('tabla');
$nombre 	= fRequest::get('nombre');
$nombre_largo 	= fRequest::get('nombre_largo');
$largo		= fRequest::get('largo');
$tipo 		= fRequest::get('tipo');
	// 0 = no show
	// 1 = textbox, 2 = combobox, 3 = datebox, 4 = checkbox, 
	// 5 = radiobutton, 6 = textarea, 7 = timeboxes, 8 = ratingInput
	if($tipo == 'varchar'){ $tipocol = '2'; }
	if($tipo == 'int'){ $tipocol = '2'; $largo = ''; }
	if($tipo == 'char'){ $tipocol = '2'; }
	if($tipo == 'date'){ $tipocol = '3'; $largo = ''; }
	if($tipo == 'checkbox'){ $tipo = 'CHAR'; $tipocol = '6'; }
	if($tipo == 'radio'){ $tipo = 'CHAR'; $tipocol = '5'; }
	if($tipo == 'time'){ $tipo = 'TIME'; $tipocol = '7'; $largo = ''; }
	if($tipo == 'rating'){ $tipo = 'CHAR'; $tipocol = '8'; }
	
$tipo					= strtoupper($tipo);
$seccion 				= fRequest::get('seccion');
$desplegar_busqueda		= fRequest::get('desplegar_busqueda');
$desplegar_listado		= fRequest::get('desplegar_listado');
$desplegar_detalle		= fRequest::get('desplegar_detalle');
$estado					= fRequest::get('estado');
$order 					= $secc->getColumnatabla('columna','max(orden)',"seccion = '$seccion'");
$order					= $order + 1;

$null		= fRequest::get('null');
	if($null == 'S'){ $nu = ' NULL'; }else{ $nu = ' NOT NULL'; }
$default	= fRequest::get('default');
$def 		= '';
if($default != ''){ $def = " DEFAULT '".$default."'"; }
$ax = fRequest::get('ax');

if($ax == 'newfield'){
	if($largo != ''){
		$coldata = $tipo.'('.$largo.') '.$nu.$def;
	}else{
		$coldata = $tipo.$nu.$def;
	}
	$ret = $ut->add_column_if_not_exist($tabla,$nombre,$coldata);
	if($ret){
		
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		$sql = "INSERT INTO columna (seccion,orden,nombre,nombre_largo, display_busqueda, display_listado, display_detalle, tipo, tamano, estado) values ($seccion,'$order','$nombre','$nombre_largo','$desplegar_busqueda','$desplegar_listado','$desplegar_detalle','$tipocol','$largo','$estado')";
		$res = mysql_query($sql);
		
		header('location: index.php?sitio='.URL_SITIO.'&tabla='.$tabla.'&p='.$p.'&m=creado');
	}else{
		
		$lnk = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$lnk);
		
		$cc = mysql_query("select count(*) as ran FROM columna where seccion = $seccion AND nombre like '$nombre'");
		mysql_affected_rows($lnk);
		if($con == 0){
			$llnk = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
			mysql_select_db(BDD_NAME,$llnk);
			
			$sql = "INSERT INTO columna (seccion,orden,nombre,nombre_largo, display_busqueda, display_listado, display_detalle, tipo, tamano, estado) values ($seccion,'$order','$nombre','$nombre_largo','$desplegar_busqueda','$desplegar_listado','$desplegar_detalle','$tipocol','$largo','$estado')";
			$res = mysql_query($sql);
		}
		
		header('location: index.php?sitio='.URL_SITIO.'&tabla='.$tabla.'&p='.$p.'&m=existe');
	}
}

if($ax == 'reorder'){
/* This is where you would inject your sql into the database 
but we're just going to format it and send it back 
*/ 
	$ro = 0;
	
	foreach ($_GET['listItem'] as $position => $item) : 
		$ro++;
		$sql[] = "UPDATE `columna` SET `orden` = ".($position + 1)." WHERE `nombre` = '$item' AND seccion = $seccion"; 
		$reor = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$reor);
		
		$r = mysql_query("UPDATE `columna` SET `orden` = ".($position + 1)." WHERE `nombre` = '$item' AND seccion = $seccion");
		
		mysql_close($reor);
		
	endforeach; 
	//print_r ($sql); 
	print_r ('Ordenado con exito!');
}

if($ax == 'eliminar')
{
	
	$del = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
	mysql_select_db(BDD_NAME,$del);
		
	$r = mysql_query("DELETE FROM `columna` WHERE `nombre` = '$nombre' AND seccion = $seccion");
	$r2 = mysql_query("ALTER TABLE `$tabla` DROP COLUMN $nombre");
		
	mysql_close($del);
	header('location: index.php?sitio='.URL_SITIO.'&tabla='.$tabla.'&p='.$p.'&m=eliminado');
	
}
?>