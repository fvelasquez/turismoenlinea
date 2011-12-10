<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();
$date = date("Y-m-d H:i:s");
$res = $mysql_db->query("SELECT * FROM seccion WHERE estado = 1 ORDER BY Sitio, seccion");

?>
<h2 style="margin:0">Catalogos de Secciones</h2>
<table width="778px" border="0" cellspacing="0" cellpadding="3">
  <tr class="table_title">
    <td>Seccion</td>
    <td>Nombre</td>
    <td>Nombre Largo</td>
    <td>Acciones</td>
  </tr>
<?php 
$c = 0;
$s = "";
foreach($res as $r){
$c++;

if($s != $r['Sitio']){
?>
  <tr bgcolor="#FF9900" style="color:#FFF">
    <td colspan="4"><strong><?php echo $secc->NombreSitio($r['Sitio']); ?></strong></td>
  </tr>
<?php
}
$s = $r['Sitio'];
?>
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td><strong><?php echo $r['seccion']; ?></strong></td>
    <td><?php echo $r['Nombre']; ?></td>
	<td><?php echo $r['NombreLargo']; ?></td>
    <td align="right">
      <?php if($r['seccion'] == '27'){ ?>
      <a href="index.php?p=88&seccion=<?php echo $r['seccion']; ?>&sitio=<?php echo $r['Sitio']; ?>"><img src="images/page_find.png" border="0" title="Ver Datos del Catalogo" />Ver Datos</a>
      <?php }else{ ?>
      <a href="index.php?p=85&seccion=<?php echo $r['seccion']; ?>&sitio=<?php echo $r['Sitio']; ?>"><img src="images/page_find.png" border="0" title="Ver Datos del Catalogo" />Ver Datos</a>
      <?php } ?>
       | 
      <a href="index.php?p=81&seccion=<?php echo $r['seccion']; ?>&sitio=<?php echo $r['Sitio']; ?>"><img src="images/page_green.png" width="16" height="16" alt="agregar registro" border="0">Agregar Registro</a>
    </td>
  </tr>
<?php } ?>
</table>
