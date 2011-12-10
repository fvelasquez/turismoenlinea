<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();
$date = date("Y-m-d H:i:s");
$res = $mysql_db->query("SELECT s.Nombre, ps.Nombre as psNombre, ps.Spot, ps.Width, ps.Height, ps.Sitio, ps.Strech FROM pubspot ps INNER JOIN sitio s ON ps.sitio = s.sitio ORDER BY Sitio, Spot");

?>
<h2 style="margin:0">Listado de areas de aparici&oacute;n de banners (spots)</h2>
<table width="780px" border="0" cellspacing="0" cellpadding="3">
  <!-- tr>
    <td colspan="6" align="right"><a href="javascript: window.open('banners_crea.php?ax=crear','','width=400px, height=215px');"><img src="images/add.png" width="16" height="16" alt="agregar banner" border="0">Nuevo banner</a></td>
  </tr-->
  <tr class="table_title">
    <td>Spot</td>
    <td>Nombre</td>
    <td>Dimensiones</td>
    <td>Estirar</td>
    <td>Acciones</td>
  </tr>
<?php 
$c = 0;
$sitio = "";
foreach($res as $r){
$c++;
if($sitio != $r['Sitio']){
?>
	<tr bgcolor="#CCCCCC">
		<td colspan="5"><strong><?php echo $r['Nombre']; ?></strong></td>
	</tr>
<?php } ?>
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td><a id="<?php echo $r['Spot']; ?>" /><?php echo $r['Spot']; ?></td>
    <td><?php echo $r['psNombre']; ?></td>
	<td><?php echo $r['Width']; ?> x <?php echo $r['Height']; ?></td>
    <td><?php if($r['Strech'] == "1"){ echo "Si"; }else{ echo "No"; } ?></td>
    <td rowspan="2">
      <a href="javascript: void(0);" onclick="window.open('spots_crea.php?ax=editar&spot=<?php echo $r['Spot']; ?>','','width=400px, height=300px');"><img src="images/pencil.png" border="0" title="Editar Spot" />Editar</a> 
      <!--a href="banners_ax.php?ax=eliminar&spot=<?php echo $r['Spot']; ?>"><img src="images/delete.png" border="0" title="Eliminar Spot" />Eliminar</a-->
    </td>
  </tr>
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td colspan="5"><img src="../images/<?php echo $r['Filename']; ?>" border="0" height="36"></td>
  </tr>
<?php 
$sitio = $r['Sitio'];
} ?>

</table>
