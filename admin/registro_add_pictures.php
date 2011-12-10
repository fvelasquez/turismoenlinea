<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ax = fRequest::get("ax");
$res = "";
$sec = fRequest::get('seccion');
$id = fRequest::get('id');
$sitio = fRequest::get('sitio');
$secc = new SeccionClass();
$seccion = $secc->NombreSeccion($sec,'Nombre');

if(isset($_POST['subir']) && $_POST['subir'] == "Subir Imagenes"){	

	$uploader = new fUpload();
	$uploader->setMIMETypes(
    array(
        'image/gif',
        'image/jpeg',
        'image/pjpeg',
        'image/png'
    ),
    'The file uploaded is not an image'
	);
	$uploader->setMaxFileSize('2MB');
	$uploader->enableOverwrite();
	$urlDir = $seccion.'/'.$id.'/';
	try{
	$direct = new fDirectory($urlDir);
	}catch(Exception $e){
		fDirectory::create($urlDir);
		$direct = new fDirectory($urlDir);
	}
	
	$fs    = array();
	$uploaded = fUpload::count('foto');
	$date = date("Y-m-d H:i:s");
	$usuario = fSession::get("username");
	
	for ($i=0; $i < $uploaded; $i++) {
		try{			

			$fs[] 		= $uploader->move($direct,'foto',$i);	
			$fnombre 	= $fs[$i]->getName();
			$foto_url 	= $urlDir.$fnombre;
			$extension 	= $fs[$i]->getType();
			
			// Resize de la imagen ******************************************
				$image = new fImage($foto_url);
				$width  = $image->getWidth();
				$height = $image->getHeight();
				
				if($width > 400 || $height > 300){
					$image->resize(400, 0);
					$image->saveChanges();
				}
			// **************************************************************
			
			$fac = ($i+1);
			
			$qry = "Insert into usr_fotos (id_padre,url,fecha_agrega,usuario_agrega,orden,seccion,sitio,extension) ";
			$qry .= " VALUES ('$id','$foto_url','$date','$usuario','$fac','$sec','$sitio','$extension')";

			$res1 = $mysql_db->query($qry);
			
		}catch(Exception $e){
			
		}
		
		header("Location: index.php?seccion={$sec}&sitio={$sitio}&id={$id}&p=82&msg=Registro ingresado con exito y autorizado");
	}
}
?>
<div>
<?php 
	$qry2 = "SELECT * FROM usr_fotos WHERE id_padre = '$id' and seccion = '$sec'";
	$rr = mysql_query($qry2);
	
	while($r = mysql_fetch_assoc($rr))
	{
		echo '<div style="float:left"><img src="../admin/'.$r['url'].'" width="50"/><a href="delete_pictures.php?p='.fRequest::get("p").'&id='.fRequest::get("id").'&seccion='.fRequest::get("seccion").'&sitio='.fRequest::get("sitio").'&url='.($r['url']).'"><img src="images/delete.png" /></a></div>';
	}
?>
<div style="clear:both"></div>
</div>
<form name="fotos" id="fotos" method="post" action="registro_add_pictures.php" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td><h2>Subir Fotograf&iacute;as para <?php echo $id; ?>:</h2></td>
  </tr>
  <tr>
    <td>
        <input type="file" name="foto[]" id="foto" /><br />
        <input type="file" name="foto[]" id="foto" /><br />
        <input type="file" name="foto[]" id="foto" /><br />
        <input type="file" name="foto[]" id="foto" /><br />
        <input type="file" name="foto[]" id="foto" /><br />
        <input type="hidden" name="seccion" value="<?php echo fRequest::get("seccion"); ?>" />
        <input type="hidden" name="sitio" value="<?php echo fRequest::get("sitio"); ?>" />
        <input type="hidden" name="id" value="<?php echo fRequest::get("id"); ?>" />
    </td>
  </tr>
  <tr>
    <td>
    <input type="submit" name="subir" id="subir" value="Subir Imagenes" />
    <input type="button" name="finalizar" id="finalizar" value="Finalizar" onclick="window.location = 'index.php?p=83&seccion=<?php echo fRequest::get("seccion"); ?>&sitio=<?php echo fRequest::get("sitio"); ?>&msg=Registro ingresado con exito y autorizado'" />
    </td>
  </tr>
</table>
</form>