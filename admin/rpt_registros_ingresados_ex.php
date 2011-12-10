<?php
include_once('../init.php');
include_once("../includes/conexion.php");
if(fSession::get("username") == "" && $_GET['p'] != 'login'){
	header("Location: index.php?p=login&url=".urlencode($_SERVER["QUERY_STRING"]));
}
include ("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

$sec 	= fRequest::get('seccion');
$sitio 	= fRequest::get('sitio');
$pagina	= fRequest::get('p');
$seccion 	= $secc->NombreSeccion($sec,'Nombre');

$filename ="reporte_registros_".$seccion.".xls";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

$res = $mysql_db->query("SELECT * FROM seccion WHERE estado = 1 ORDER BY NombreLargo, seccion");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#FF6600" style="color:#FFF; font-weight:bold;">
<?php
$c = 0;
if ($sec != ''){
$cols	= $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." and display_listado = 1 ORDER BY orden");
$fields = array();
foreach($cols as $d){
?>
    <td>
	<?php
        $fields[] = $d['nombre'];
        echo $d['nombre_largo'];
        ?>
    </td>
<?php
}
?>
</tr>
<?php
$r = $mysql_db->query("SELECT a.* FROM usr_".$seccion." as a ORDER BY a.nombre");
$i = 1;
foreach($r as $d){
$c++;
?>
    <tr bgcolor="<?php echo $ut->ncolor($c);?>">
<?php foreach($fields as $f){ ?>
        <td>
        	<?php echo $d[$f]; ?>
        </td>
<?php } ?>
    </tr>
<?php
}
}
?>
</table>
<br />
<strong>Total de registros:</strong> <?php echo $c; ?>