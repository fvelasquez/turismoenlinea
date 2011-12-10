<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();
$date = date("Y-m-d H:i:s");
$res = $mysql_db->query("SELECT pd.Campana, pd.Banner, pdd.Spot, pdd.Seccion, pdd.Asignacion, pb.Nombre as BannerNombre, ps.Sitio, pd.Nombre, pb.Filename, pd.Fecha_ini, pd.Fecha_fin, pd.Contador, pd.Novence, pd.Estado, pd.Frecuencia, pd.Preferencia, pd.NoHistorial FROM pubdisplay pd INNER JOIN (SELECT Campana, Asignacion, Spot, Seccion FROM pubdisplaydetail pdda WHERE Asignacion = (SELECT max(Asignacion) FROM pubdisplaydetail WHERE Campana = pdda.Campana)) pdd ON pd.Campana = pdd.Campana INNER JOIN pubbanner pb ON pb.Banner = pd.Banner INNER JOIN pubspot ps ON pdd.Spot = ps.Spot");

?>
<h2 style="margin:0">Listado de Capa&ntilde;as</h2>
<table width="780px" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td colspan="8" align="right"><a href="javascript: void();" onclick="window.open('campanias_crea.php?ax=crear','','width=450px, height=700px, scrollbars=1');"><img src="images/add.png" width="16" height="16" alt="agregar campa&ntilde;a" border="0">Nueva campa&ntilde;a</a></td>
  </tr>
  <tr class="table_title">
    <td>Campa&ntilde;a</td>
    <td>Nombre</td>
    <td>Banner</td>
    <td>Imagen</td>
    <td>Spot</td>
    <td>Contador</td>
    <td>Estado</td>
    <td>Acciones</td>
  </tr>
<?php 
$c = 0;
foreach($res as $r){
$c++;
?>
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td><a id="<?php echo $r['Campana']; ?>" /><?php echo $r['Campana']; ?></td>
    <td><strong><?php echo $r['Nombre']; ?></strong></td>
    <td><?php echo $r['BannerNombre']; ?></td>
    <td><?php echo $r['Filename']; ?></td>
    <td><?php echo $r['Spot']; ?></td>
    <td><?php echo $r['Contador']; ?></td>
    <td><?php echo $r['Estado']; ?></td>
    <td rowspan="2">
      <a href="javascript: void(0);" onclick="window.open('campanias_crea.php?ax=editar&campania=<?php echo $r['Campana']; ?>','','width=450px, height=700px, scrollbars=1');"><img src="images/pencil.png" border="0" title="Editar Campa&ntilde;a" />Editar</a><br />
      <?php if($r['Estado'] == 0){ ?>
      <a href="campanias_ax.php?ax=activar&campania=<?php echo $r['Campana']; ?>"><img src="images/lightbulb.png" border="0" title="Activar Campa&ntilde;a" />Activar</a><br />
      <?php }else{ ?>
      <a href="campanias_ax.php?ax=desactivar&campania=<?php echo $r['Campana']; ?>"><img src="images/lightbulb_off.png" border="0" title="Desactivar Campa&ntilde;a" />Desactivar</a><br />
      <?php } ?>
      <!--a href="campanias_ax.php?ax=eliminar&campania=<?php echo $r['Campana']; ?>"><img src="images/delete.png" border="0" title="Eliminar Campa&ntilde;a" />Eliminar</a-->
    </td>
  </tr>
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td colspan="7"><img src="../images/<?php echo $r['Filename']; ?>" border="0" height="36"></td>
  </tr>
<?php } ?>
</table>
