<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ax = fRequest::get("ax");
$res = "";
$sec = fRequest::get('seccion');
$id = fRequest::get('id');
$sitio = fRequest::get('sitio');
$secc = new SeccionClass();
$seccion = $secc->NombreSeccion($sec,'Nombre');

if($ax == "aprobar"){
	
	//Elimina el registro que se autorizo
	$res = $mysql_db->query("DELETE FROM registros WHERE id = '$id' AND idseccion = $sec AND sitio = $sitio");
	//Activa el registro
	
	$res = $mysql_db->query("SELECT * FROM usr_".$seccion." WHERE id = '$id'");
	$cols = $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." ORDER BY orden");
	$qry = "UPDATE usr_".$seccion." SET ";
	foreach($res as $r){
		$c = 0;
		foreach($cols as $d){
			$c++;
			$name = $d['nombre'];
			if($d['tipo'] == 7){ 
				$req = fRequest::get($name."_h").":".fRequest::get($name."_m");
			}else{
				$req = fRequest::get($name);
			}
			$req = str_replace("'","\'",$req);
			$req = str_replace('"','\"',$req);
			
			if($c == 1){
				$qry .= " ".$name." = '".$req."'";
			}else{
				$qry .= ",".$name." = '".$req."'";
			}
		}
	}
	$qry .= " WHERE id = $id";
	
	$res1 = $mysql_db->query($qry);
	$res2 = $mysql_db->query("UPDATE usr_".$seccion." SET activo = 1 WHERE id = '$id'");
	
	header("Location: index.php?p=5&msg=aprobado#".$id);

}

if($ax == "rechazar"){
	
	//Elimina el registro que se autorizo
	$res = $mysql_db->query("DELETE FROM registros WHERE id = '$id' AND idseccion = $sec AND sitio = $sitio");
	//Elimina el registro
	$res2 = $mysql_db->query("DELETE FROM usr_".$seccion." WHERE id = '$id'");
	
	header("Location: index.php?p=5&msg=rechazado#".$id);
	
}

if($ax == "editar"){
	
	$res = $mysql_db->query("SELECT * FROM usr_".$seccion." WHERE id = '$id'");
	$cols = $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." ORDER BY orden");
	$qry = "UPDATE usr_".$seccion." SET ";
	foreach($res as $r){
		$c = 0;
		foreach($cols as $d){
			$c++;
			$name = $d['nombre'];
			if($d['tipo'] == 7){ 
				$req = fRequest::get($name."_h").":".fRequest::get($name."_m");
			}else{
				$req = fRequest::get($name);
			}
			$req = str_replace("'","\'",$req);
			$req = str_replace('"','\"',$req);
			if($c == 1){
				$qry .= " ".$name." = '".$req."'";
			}else{
				$qry .= ",".$name." = '".$req."'";
			}
		}
	}
	$qry .= " WHERE id = $id";
	$res1 = $mysql_db->query($qry);
	
	header("Location: index.php?p=85&seccion=".$sec."&msg=editado#".$id);
}

if($ax == "crear"){
	
	$from = fRequest::get("from");
	$cols = $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." ORDER BY orden");
	$flds = "";
	$vals = "";
	$lastId = 0;
	$c = 0;
		foreach($cols as $d){
			$c++;
			$name = $d['nombre'];
			if($d['tipo'] == 7){ 
				$req = fRequest::get($name."_h").":".fRequest::get($name."_m");
			}else{
				$req = fRequest::get($name);
			}
			$req = str_replace("'","\'",$req);
			$req = str_replace('"','\"',$req);
			if($c == 1){
				$flds .= "".$name."";
				$vals .= "'".$req."'";
			}else{
				if($req != ""){
				$flds .= ",".$name."";
				$vals .= ",'".$req."'";
				}
			}
		}
	$qry = "Insert into usr_".$seccion." (".$flds.") VALUES (".$vals.")";
	
	
	$res1 = $mysql_db->query($qry);
	$lastId = $res1->getAutoIncrementedValue();
	
	$red =($from=="admin")?"Location: index.php?p=82&id=$lastId&seccion=$sec&sitio=$sitio&msg=creado":"Location: index.php?p=5&msg=creado";
	if ($sec == "26"){
		$red = "Location: index.php?p=84&id=$lastId&seccion=$sec&sitio=$sitio&msg=creado";
	}
	header($red);
		
}

if($ax == "crearmapa"){
	
	$from = fRequest::get("from");
	$nombre = fRequest::get("nombre");
	$sitio_interes = fRequest::get("sitio_interes");
	$lastId = 0;
	$c = 0;
	$qry = "Insert into usr_mapas (nombre,titulo,sitio_interes,descargable,activo) VALUES ('$nombre','$nombre','$sitio_interes','S','A')";
	$res1 = $mysql_db->query($qry);
	$lastId = $res1->getAutoIncrementedValue();
	
	// ** UPLOAD DE MAPA **
	$uploader = new fUpload();
	$uploader->setMIMETypes(
    array(
        'image/gif',
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'application/pdf',
        'application/x-pdf',
        'application/acrobat'
    ),
    'The file uploaded is not an image'
	);
	$uploader->setMaxFileSize('2MB');
	$uploader->enableOverwrite();
	$urlDir = $seccion.'/';
	try{
	$direct = new fDirectory($urlDir);
	}catch(Exception $e){
		fDirectory::create($urlDir);
		$direct = new fDirectory($urlDir);
	}
	
	$fs    = array();
	$uploaded = fUpload::count('imagen');
	$pdfoploaded = fUpload::count('pdf');
	$date = date("Y-m-d H:i:s");
	$usuario = fSession::get("username");
	
	for ($i=0; $i < $uploaded; $i++) {
		try{			

			$fs[] 		= $uploader->move($direct,'imagen',$i);	
			$fnombre 	= $fs[$i]->getName();
			$foto_url 	= $urlDir.$fnombre;
			$extension 	= $fs[$i]->getType();
			
			// Resize de la imagen ******************************************
			/*	$image = new fImage($foto_url);
				$width  = $image->getWidth();
				$height = $image->getHeight();
				
				if($width > 400 || $height > 300){
					$image->resize(400, 0);
					$image->saveChanges();
				}*/
			// **************************************************************
			
			$fac = ($i+1);
			
			$qry = "UPDATE usr_mapas SET imagen = '$fnombre' WHERE id = '$lastId'";
			$res1 = $mysql_db->query($qry);
			
		}catch(Exception $e){
			
		}
	}
	
	for ($i=0; $i < $pdfoploaded; $i++) {
		try{			

			$ps[] 		= $uploader->move($direct,'pdf',$i);	
			$pnombre 	= $ps[$i]->getName();
			$poto_url 	= $urlDir.$pnombre;
			$pac = ($i+1);
			
			$qryp = "UPDATE usr_mapas SET pdf = '$pnombre' WHERE id = '$lastId'";
			$resp = $mysql_db->query($qryp);
			
		}catch(Exception $e){
			
		}
	}

	$red = "Location: index.php?p=81&id=$lastId&seccion=$sec&sitio=$sitio&msg=creado";
	
	header($red);
}

if($ax == "agregarsitio"){
	$from = fRequest::get("from");
	$id   =  fRequest::get("id");
	$fecha = date("Y-m-d H:i:s");
	$usuario = fSession::get("username");
	
	$hotel =(isset($_POST['hotel']) && $_POST['hotel'] != '')?$_POST['hotel']:array();
	$resta = (isset($_POST['restaurante']) && $_POST['restaurante'] != '')?$_POST['restaurante']:array();
	$casas = (isset($_POST['casa']) && $_POST['casa'] != '')?$_POST['casa']:array();
	$entre = (isset($_POST['entretenimiento']) && $_POST['entretenimiento'] != '')?$_POST['entretenimiento']:array();
	$trans =(isset($_POST['transporte']) && $_POST['transporte'] != '')?$_POST['transporte']:array();
	
	foreach($hotel as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','hoteles')");
	}
	
	foreach($resta as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','restaurantes')");
	}
	
	foreach($casas as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','casas')");
	}
	
	foreach($entre as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','entretenimiento')");
	}
	
	foreach($trans as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','transporte')");
	}
	
	$red =($from=="admin")?"Location: index.php?p=82&id=$lastId&seccion=$sec&sitio=$sitio&msg=creado":"Location: index.php?p=5&msg=creado";
	header($red);
}

if($ax == "editarsitio"){
	$from = fRequest::get("from");
	$id   =  fRequest::get("id");
	$fecha = date("Y-m-d H:i:s");
	$usuario = fSession::get("username");
	
	$hotel =(isset($_POST['hotel']) && $_POST['hotel'] != '')?$_POST['hotel']:array();
	$resta = (isset($_POST['restaurante']) && $_POST['restaurante'] != '')?$_POST['restaurante']:array();
	$casas = (isset($_POST['casa']) && $_POST['casa'] != '')?$_POST['casa']:array();
	$entre = (isset($_POST['entretenimiento']) && $_POST['entretenimiento'] != '')?$_POST['entretenimiento']:array();
	$trans =(isset($_POST['transporte']) && $_POST['transporte'] != '')?$_POST['transporte']:array();
	
	$res = $mysql_db->query("DELETE FROM usr_establecimiento_sitiointeres WHERE sitiointeres = $id");
	
	foreach($hotel as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','hoteles')");
	}
	
	foreach($resta as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','restaurantes')");
	}
	
	foreach($casas as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','casas')");
	}
	
	foreach($entre as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','entretenimiento')");
	}
	
	foreach($trans as $h){
		$res = $mysql_db->query("INSERT INTO usr_establecimiento_sitiointeres (establecimiento,sitiointeres,fecha_asignacion,usuario_asignacion,activo,tipo) VALUES ($h,$id,'$fecha','$usuario','1','transporte')");
	}
	
	$red =($from=="editar")?"Location: index.php?p=86&id=$id&seccion=$sec&sitio=$sitio&msg=modificado":"Location: index.php?p=5&msg=creado";
	header($red);
}
?>