<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();
$date = date("Y-m-d H:i:s");
$res = $mysql_db->query("SELECT r.sitio, s.Nombre as SitioNombre, r.id, r.nombre, r.seccion, r.usuario, r.idseccion, r.fecha FROM registros r inner join sitio s on r.sitio = s.Sitio");

?>
<?php 
if(isset($_GET['msg']) && $_GET['msg'] != ''){
	switch($_GET['msg']){
		case 'eliminado':
			$msg = 'El usuario ha sido eliminado.';
		break;
		case 'activado':
			$msg = 'El usuario ha sido dado de alta.';
		break;
		case 'desactivado':
			$msg = 'El usuario ha sido dado de baja.';
		break;
	}
	echo '<div id="message">'.$msg.'</div><script>$(function(){ $(\'#password\').focus(); });</script>';
}
?>
<h2 style="margin:0">Listado para Autorizaci&oacute;n</h2>
<table width="780px" border="0" cellspacing="0" cellpadding="3">
  <tr class="table_title">
    <td>Fecha</td>
    <td>Secci&oacute;n</td>
    <td>Id</td>
    <td>Nombre</td>
    <td>Usuario</td>
    <td>Acciones</td>
  </tr>
<?php 
$c = 0;
$tip = "";
foreach($res as $r){
$c++;
if($tip != $r['SitioNombre']){
?>
	<tr bgcolor="#CCCCCC">
    	<td colspan="6"><strong>Sitio: <?php echo $r['SitioNombre']; ?></strong></td>
    </tr>
<?php }
$tip = $r['SitioNombre'];
?>    
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td><a id="<?php echo $r['id']; ?>" /><?php echo $r['fecha']; ?></td>
    <td><?php echo $r['seccion']; ?></td>
    <td><?php echo $r['id']; ?></td>
    <td><?php echo $r['nombre']; ?></td>
	<td><?php echo $r['usuario']; ?></td>
    <td>
      <a href="index.php?p=51&sit=<?php echo $r['sitio']; ?>&sec=<?php echo $r['idseccion']; ?>&r=<?php echo $r['id']; ?>"><img src="images/accept.png" border="0" title="Activar Usuario" />Aprobar</a>
    </td>
  </tr>
<?php } ?>
</table>
