<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

$sec = fRequest::get('sec');
$id = fRequest::get('r');
$sitio = fRequest::get('sit');

$seccion = $secc->NombreSeccion($sec,'Nombre');
$res = $mysql_db->query("SELECT * FROM usr_".$seccion." WHERE id = '$id'");
$cols = $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." ORDER BY orden");

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
<script>
	function aprobar(){
		$('#ax').val('aprobar');
		$('#editar_aut').submit();
	}
	
	function rechazar(){
		$('#ax').val('rechazar');
		$('#editar_aut').submit();
	}
</script>
<h2 style="margin:0">Paso 2: Revisi&oacute;n de datos ingresados</h2>
<form id="editar_aut" action="autorizar_ax.php" method="post" name="editar_aut">
<table width="780px" border="0" cellspacing="0" cellpadding="3">
<?php 
$c = 0;
$tip = "";
foreach($res as $r){
$c++;
$cc = 0;
	foreach($cols as $d){
	$cc++;
?>
  <tr bgcolor="<?php echo $ut->ncolor($cc,"#f0f0f0","");?>">
    <td><?php echo $d['nombre_largo']; ?></td>
    <td>
    	<?php echo $ut->generateInput($r[$d['nombre']],$d['display_busqueda'],$d['tamano'],$d['nombre'],$d['tipo'],$d['seccion']); ?>
    </td>
  </tr>
<?php 
	}
?>
  <tr>
	<td>&nbsp;</td>
    <td>
	    <input type="hidden" name="ax" id="ax" value="" />
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="sitio" id="sitio" value="<?php echo $sitio; ?>" />
        <input type="hidden" name="seccion" id="seccion" value="<?php echo $sec; ?>" />
    	<input type="button" name="enviar" value="Aprobar" onclick="aprobar();"/>
        <a href="javascript: void(0);" onclick="rechazar();" class="cancelar">Rechazar</a>
    </td>
  </tr>
<?php
} ?>
</table>
</form>