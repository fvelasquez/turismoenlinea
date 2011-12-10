<?php
include ("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

$sec 	= fRequest::get('seccion');
$id 	= fRequest::get('id');

if(isset($_GET['seccion']) && $_GET['seccion'] != ''){
$seccion 	= $secc->NombreSeccion($sec,'Nombre');
$seccionN 	= $secc->NombreSeccion($sec,'NombreLargo');

$cols		= $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." ORDER BY orden");

$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
mysql_select_db(BDD_NAME,$link);

$re = mysql_query("SELECT * FROM usr_".$seccion." WHERE id = ".$id."");
$r = mysql_fetch_assoc($re);
?>
<form id="enviar" name="enviar" method="post" action="autorizar_ax.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="2">
	<h2>Ingreso de <?php echo $seccionN; ?>
		<div style="float:right; color:#ffffff; width:200px; text-align:right;">
		<?php if($_GET['seccion'] == 26){?>
		<a href="index.php?p=84&id=<?php echo fRequest::get("id");?>&seccion=<?php echo fRequest::get("seccion");?>&from=admin&ax=editarsitio&sitio=2&msg=creado"><img src="images/images.jpeg" alt="Editar Relaciones" border="0"/> Relaciones</a>
		<?php } ?>
		<a href="index.php?p=82&id=<?php echo fRequest::get("id");?>&seccion=<?php echo fRequest::get("seccion");?>&sitio=2&msg=creado"><img src="images/picture_edit.png" alt="Editar Imagenes" border="0"/> Imagenes</a>
		</div>
	</h2>
</td>
</tr>
  <tr>
    <td width="30%">
<?php 
$cc = 0;
$cd = 0;
$ca = 0;
foreach($cols as $d){
	$cc++;
	echo '<tr bgcolor="'.$ut->ncolor($cc,"#f0f0f0","").'"><td>';
?>
	<strong><?php echo $d['nombre_largo']; ?>: </strong> </td>
    <td>
    	<?php echo $ut->generateInput($r[$d['nombre']],$d['display_busqueda'],$d['tamano'],$d['nombre'],$d['tipo'],$d['seccion']); ?>
    </td>
    </tr>
<?php
}
?>
	</td>
  	</tr>
  	<tr>
        <td colspan="2">
	        <input type="hidden" name="seccion" value="<?php echo fRequest::get("seccion"); ?>" />
            <input type="hidden" name="sitio" value="<?php echo fRequest::get("sitio"); ?>" />
        	<input type="hidden" name="ax" value="editar" />
            <input type="hidden" name="id" value="<?php echo fRequest::get("id"); ?>" />
            <input type="hidden" name="from" value="admin" />
            
            <input name="Enviar" type="submit" value="Guardar Cambios" />
        </td>
    </tr>
</table>
</form>
<?php
}else{
$secciones	= $mysql_db->query("SELECT * FROM seccion WHERE sitio = 2 AND estado = 1 AND NOT seccion IN (28,27,26) ORDER BY orden");
?>
<form id="enviar" name="enviar" method="get" action="index.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
        	<strong>De que sitio desea registrar?:</strong><br />
            <select name="sitio">
                <option value="">Seleccione...</option>
                <option value="2">Turismoenlinea.org</option>
                <!-- option value="1">Saludenlinea.org</option -->
            </select><br />
            <strong>Que desea registrar?:</strong><br />
            <select name="seccion">
                <option value="">Seleccione...</option>
                <?php foreach($secciones as $s){ ?>
                <option value="<?php echo $s['seccion'];?>"><?php echo $s['NombreLargo']; ?></option>
                <?php } ?>
            </select><br /><br />
			<input name="Enviar" type="submit" value="Registrar" />
            <input type="hidden" name="p" value="<?php echo $_GET["p"]; ?>" />
        </td>
    </tr>
</table>
</form>
<?php } ?>