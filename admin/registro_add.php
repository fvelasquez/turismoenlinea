<?php
include ("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

$sec 	= fRequest::get('seccion');

if(isset($_GET['seccion']) && $_GET['seccion'] != ''){
$seccion 	= $secc->NombreSeccion($sec,'Nombre');
$seccionN 	= $secc->NombreSeccion($sec,'NombreLargo');

$cols		= $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." AND estado = 1 ORDER BY orden");
if($sec == '27'){
if($_GET['msg'] == 'creado'){
	echo '<div id="message">Mapa Agregado con Exito</div>';
}
?>
<form id="enviar" name="enviar" method="post" enctype="multipart/form-data" action="autorizar_ax.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
	<tr>
	<th colspan="2"><h2>Ingreso de Mapas</h2></th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>Nombre:</td>
		<td><input type="text" name="nombre" value="" size="50"></td>
	</tr>
	<tr>
		<td>Sitio al que pertenece:</td>
		<td><input type="text" name="sitio_interes" value="" size="50"></td>
	</tr>
	<tr>
		<td>Imagen:</td>
		<td><input type="file" name="imagen[]"></td>
	</tr>
	<tr>
		<td>PDF:</td>
		<td><input type="file" name="pdf[]"></td>
	</tr>
	<tr>
        <td>
	        <input type="hidden" name="seccion" value="<?php echo fRequest::get("seccion"); ?>" />
            <input type="hidden" name="sitio" value="<?php echo fRequest::get("sitio"); ?>" />
        	<input type="hidden" name="ax" value="crearmapa" />
			<input name="Enviar" type="submit" value="Registrar" />
        </td>
    </tr>
</tbody>
</table>
<?php
}else{
?>
<form id="enviar" name="enviar" method="post" action="autorizar_ax.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
	<tr>
	<th colspan="2"><h2>Ingreso de <?php echo $seccionN; ?></h2></th>
	</tr>
</thead>
<tbody>
<?php 
$cc = 0;
$cd = 0;
$cdd = 0;
$ca = 1;
foreach($cols as $d){
	$cc++;

//	if($cd > 1){ echo '</td></tr>'; $cd = 0;}
	if($ca > 0){ echo '<tr bgcolor="'.$ut->ncolor($cc,"#f0f0f0","").'"><td>'; }
?>
	<strong><?php echo $d['nombre_largo']; ?></strong></td>
    <td>
    	<?php echo $ut->generateInput("",$d['display_busqueda'],$d['tamano'],$d['nombre'],$d['tipo'],$d['seccion']); ?>
    </td>
    </tr>
<?php 
$ca++;
}
?>
  	<tr>
        <td>
	        <input type="hidden" name="seccion" value="<?php echo fRequest::get("seccion"); ?>" />
            <input type="hidden" name="sitio" value="<?php echo fRequest::get("sitio"); ?>" />
        	<input type="hidden" name="ax" value="crear" />
            <input type="hidden" name="from" value="admin" />
			<input name="Enviar" type="submit" value="Registrar" />
        </td>
    </tr>
</tbody>
</table>
</form>
<?php
} //End if de mapas
}else{
$secciones	= $mysql_db->query("SELECT * FROM seccion WHERE sitio = 2 AND estado = 1 AND NOT seccion IN (28) ORDER BY orden");
?>
<form id="enviar" name="enviar" method="get" action="index.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
        	<strong>De que sitio desea registrar?:</strong><br />
            <select name="sitio">
                <option value="2">Turismoenlinea.org</option>
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