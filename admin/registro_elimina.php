<?php
include ("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

$sec 	= fRequest::get('seccion');
$id 	= fRequest::get('id');
$sitio 	= fRequest::get('sitio');
$pagina	= fRequest::get('p');

if(isset($_GET['seccion']) && $_GET['seccion'] != ''){
$seccion 	= $secc->NombreSeccion($sec,'Nombre');
$seccionN 	= $secc->NombreSeccion($sec,'NombreLargo');
//Elimina todas las fotos que existan para este registro
$fo = $mysql_db->query("SELECT * FROM usr_fotos where seccion = ".$sec." AND id_padre = '".$id."'");
$totalfotos = $fo->countReturnedRows();
if ($totalfotos > 0)
{
 $del = $mysql_db->execute("DELETE FROM usr_fotos WHERE seccion = ".$sec." AND id_padre = '".$id."'");
 foreach($fo as $f)
 {
     $url = $f['url'];
     $ffoto = new fFile('/home/richam/public_html/turismoenlinea.org/admin/'.$url);
     $de = $ffoto->delete();
 }
}

//Elimina el registro de la base de datos
$del = $mysql_db->execute("DELETE FROM usr_".$seccion." WHERE id = ".$id."");

echo "<script>window.location = 'index.php?p=".$pagina."&seccion=".$sec."&sitio=".$sitio."&msg=Registro eliminado exitosamente'</script>";
} ?>