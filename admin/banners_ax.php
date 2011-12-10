<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ax = fRequest::get("ax");
$banner = fRequest::get("banner");
$res = "";
if($ax == "activar"){
	$qry = "UPDATE pubbanner SET Estado = '1' WHERE Banner = ".$banner;
	$mysql_db->query($qry);
	header("Location: index.php?p=2&msg=activado#".$banner);
}
if($ax == "desactivar"){
	$qry = "UPDATE pubbanner SET Estado = '0' WHERE Banner = ".$banner;
	$mysql_db->query($qry);
	header("Location: index.php?p=2&msg=desactivado#".$banner);
}

if($ax == "eliminar"){
	$dirfoto = "../images/".fRequest::get('ar');
	$archivo = new fFile($dirfoto);
	$archivo->delete();	
	
	$qry = "DELETE FROM pubbanner WHERE Banner = ".$banner;
	$mysql_db->query($qry);
	header("Location: index.php?p=2&msg=eliminado");
}

if($ax == "editar"){
	$ut = new Utils();
	$uploader = new fUpload();
		$uploader->setMIMETypes(
			array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
			'El archivo subido no es una imagen'
		);
		
		$uploader->setMaxFileSize('2MB');
		$uploader->enableOverwrite();
		
		$files    = array();
		$uploaded = fUpload::count('file');
		$fecha_crea = date('Y-m-d h:i:s');
		$nombre = fRequest::get("nombre");
		$fanterior = fRequest::get("fanterior");
		$link = fRequest::get("link");
		$dir = new fDirectory('../images');
		$archivo = '';
		$tipo = '';
		for ($i=0; $i < $uploaded; $i++) {		
			try{
				$files = $uploader->move($dir, 'file', $i);
				$archivo = $files->getName();
				$tipo = $files->getMimeType();
				switch($tipo){
					case "image/gif":
						$tipo = "gif";
					break;
					case "image/jpeg":
						$tipo = "jpg";
					break;
					case "image/png":
						$tipo = "png";
					break;
				}
			}catch(Exception $e){
				$res = $e;
			}
		}
		
		$qry = "UPDATE pubbanner SET Nombre = '$nombre',";
		if($archivo != ""){
			//Elimina el archivo anterior para agregar el nuevo
			$dirfoto = "../images/".$fanterior;
			$arc = new fFile($dirfoto);
			$arc->delete();
			//Agrega al query el valor del nuevo archivo
			$qry .= "Filename = '$archivo',Tipo = '$tipo',";
		}
		$qry .= "Link = '$link' WHERE Banner = ".$banner;
		$res = $mysql_db->query($qry);
}

if($ax == "crear"){
	
	$ut = new Utils();
	$uploader = new fUpload();
		$uploader->setMIMETypes(
			array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
			'El archivo subido no es una imagen'
		);
		
		$uploader->setMaxFileSize('2MB');
		//$uploader->enableOverwrite();
		
		$files    = array();
		$uploaded = fUpload::count('file');
		$fecha_crea = date('Y-m-d h:i:s');
		$nombre = fRequest::get("nombre");
		$link = fRequest::get("link");
		$dir = new fDirectory('../images');
		$da = $mysql_db->query("Select (max(Banner)+1) as actual FROM pubbanner");
		foreach($da as $d){
			$banner = $d["actual"];
		}
		
		for ($i=0; $i < $uploaded; $i++) {
			
			try{
				$files = $uploader->move($dir, 'file', $i);
				$archivo = $files->getFilename();
				$tipo = $files->getMimeType();
				switch($tipo){
					case "image/gif":
						$tipo = "gif";
					break;
					case "image/jpeg":
						$tipo = "jpg";
					break;
					case "image/png":
						$tipo = "png";
					break;
				}
				
				$mysql_db->query("INSERT INTO pubbanner (Banner,Nombre,Filename,Tipo,Link,Estado) VALUES ($banner,'$nombre','$archivo','$tipo','$link',0)");
				//print_r($res);
			}catch(Exception $e){
				print_r($e);
			}
		}
}
	echo "<script>opener.location.reload(); self.close();</script>";
?>