<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();
$date = date("Y-m-d H:i:s");
$res = $mysql_db->query("SELECT * FROM usuario ORDER BY tipo, usuario");

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
<h2 style="margin:0">Listado de Usuarios</h2>
<table width="780px" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td colspan="5" align="right"><a href="index.php?p=41&ax=crear"><img src="images/add.png" width="16" height="16" alt="Agregar usuario" border="0">Nuevo usuario</a></td>
  </tr>
  <tr class="table_title">
    <td>Usuario</td>
    <td>Nombre</td>
    <td>Contacto</td>
    <td>Acciones</td>
  </tr>
<?php 
$c = 0;
$tip = "";
foreach($res as $r){
$c++;
if($tip != $r['tipo']){
?>
	<tr bgcolor="#CCCCCC">
    	<td colspan="4"><strong>Tipo de usuario: <?php echo $r['tipo']; ?></strong></td>
    </tr>
<?php }
$tip = $r['tipo'];
?>    
  <tr bgcolor="<?php echo $ut->ncolor($c,"#f0f0f0","");?>">
    <td><a id="<?php echo $r['usuario']; ?>" /><?php echo $r['usuario']; ?></td>
    <td><?php echo $r['name1'].' '.$r['name2']; ?></td>
	<td>
	<strong>Email:</strong> <?php echo $r['email']; ?><br />
	<strong>Telefono:</strong> <?php echo $r['tel1']; ?>
    </td>
    <td>
      <a href="index.php?p=41&ax=editar&usuario=<?php echo $r['usuario']; ?>"><img src="images/pencil.png" border="0" title="Editar Usuario" />Editar</a>
      <?php if($r['estado'] == 0){ ?>
      <a href="usuarios_ax.php?ax=activar&usuario=<?php echo $r['usuario']; ?>"><img src="images/lightbulb.png" border="0" title="Activar Usuario" />Alta</a>
      <?php }else{ ?>
      <a href="usuarios_ax.php?ax=desactivar&usuario=<?php echo $r['usuario']; ?>"><img src="images/lightbulb_off.png" border="0" title="Desactivar Usuario" />Baja</a>
      <?php } ?>
      <a href="usuarios_ax.php?ax=eliminar&usuario=<?php echo $r['usuario']; ?>&ar=<?php echo $r['Filename']; ?>"><img src="images/delete.png" border="0" title="Eliminar Usuario" />Eliminar</a>
    </td>
  </tr>
<?php } ?>
</table>
