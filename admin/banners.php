<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();
$date = date("Y-m-d H:i:s");
$res = $mysql_db->query("SELECT * FROM pubbanner ORDER BY Banner");

?>
<h2 style="margin:0">Listado de banners</h2>
<table width="780px" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td colspan="5" align="right"><a href="javascript: void(0);" onclick="window.open('banners_crea.php?ax=crear','','width=400px, height=215px');"><img src="images/add.png" width="16" height="16" alt="agregar banner" border="0">Nuevo banner</a></td>
  </tr>
  <tr class="table_title">
    <td>No.</td>
    <td>Nombre</td>
    <td>Archivo</td>
    <td>Link</td>
    <td>Acciones</td>
  </tr>
<?php 
$c = 0;
foreach($res as $r){
$c++;
?>
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td><a id="<?php echo $r['Banner']; ?>" /><?php echo $r['Banner']; ?></td>
    <td><strong><?php echo $r['Nombre']; ?></strong></td>
    <td><?php echo $r['Filename']; ?></td>
	<td><?php echo $r['Link']; ?></td>
    <td rowspan="2">
      <a href="javascript: void(0);" onclick="window.open('banners_crea.php?ax=editar&banner=<?php echo $r['Banner']; ?>','','width=400px, height=300px');"><img src="images/pencil.png" border="0" title="Editar Banner" />Editar</a><br />
      <?php if($r['Estado'] == 0){ ?>
      <a href="banners_ax.php?ax=activar&banner=<?php echo $r['Banner']; ?>"><img src="images/lightbulb.png" border="0" title="Activar Banner" />Activar</a><br />
      <?php }else{ ?>
      <a href="banners_ax.php?ax=desactivar&banner=<?php echo $r['Banner']; ?>"><img src="images/lightbulb_off.png" border="0" title="Desactivar Banner" />Desactivar</a><br />
      <?php } ?>
      <a href="banners_ax.php?ax=eliminar&banner=<?php echo $r['Banner']; ?>&ar=<?php echo $r['Filename']; ?>"><img src="images/delete.png" border="0" title="Eliminar Banner" />Eliminar</a>
    </td>
  </tr>
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td colspan="5"><img src="../images/<?php echo $r['Filename']; ?>" border="0" height="36"></td>
  </tr>
<?php } ?>
</table>
