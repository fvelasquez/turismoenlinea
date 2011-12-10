<?php
include ("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

?>
<?php
if(isset($_GET['tabla']) && $_GET['tabla'] != ''){
$tab = $_GET['tabla'];
$name = explode('_',$tab);
if(count($name) > 2){
$nname = $name[1].'_'.$name[2];
}else{
$nname = $name[1];
}

$seccion = $secc->getColumnatabla('seccion','seccion',"nombre = '{$nname}'");

//$cols		= $mysql_db->query("SHOW COLUMNS FROM ".$tab);
$cols		= $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$seccion." order by orden");
?>
<style> 
  	#test-list { list-style: none; padding: 0; margin: 0 40px; } 
  	#test-list li { margin: 0 0 10px 0; background: #eaf3fa; padding: 15px; } 
  	#test-list .handle { float: left; margin-right: 10px; cursor: move; } 
	#test-log { padding: 5px; border: 1px solid #ccc; } 

	#adnew { display:none;}
</style>

<script type="text/javascript"> 
// When the document is ready set up our sortable with it's inherant function(s) 
$(document).ready(function() { 
	$("#adnewbtn").click(function(){
		$("#adnew").toggle('slow');
	});
	
	$("#test-list").sortable({ 
    	handle : '.handle', 
    	update : function () { 
      		var order = $('#test-list').sortable('serialize'); 
      		$("#info").load("seccion_ax.php?ax=reorder&seccion=<?php echo $seccion; ?>&"+order); 
    	} 
  	}); 
}); 
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>  
	<tr>
		<th colspan="4"><h2>Modificacion de Tabla <?php echo $tab; ?></h2></th>
	</tr>
    <tr bgcolor="#333399" style="color:#ffffff">
		<th>Campo</th>
		<th>Tipo</th>
		<th>Null?</th>
		<th>Default</th>
</tr>
</thead>
<tbody>
<tr>
    <td colspan="4">
		<a href="#" id="adnewbtn">Agregar Nuevo</a>
		<div id="adnew">
		<form id="enviar" name="enviar" method="post" action="seccion_ax.php">
			<label>Nombre campo:</label>
			<input type="text" size="30" name="nombre" />
			<label>Nombre despliege:</label>
			<input type="text" size="30" name="nombre_largo" />
			<label>Tipo:</label>
				<select name="tipo">
					<option value="varchar">Texto</option>
					<option value="char">Caracter</option>
					<option value="int">Integral</option>
					<option value="text">Cuadro de Texto</option>
					<option value="date">Fecha</option>
					<option value="datetime">Fecha y hora</option>
					<option value="time">Hora</option>
					<option value="checkbox">Checkbox</option>
					<option value="radio">Radio</option>
					<option value="rating">Rating (Estrellas)</option>
				</select>
			<label>Largo:</label>
			<input type="text" size="30" name="largo" />
			<label>Null?:</label>
			<input type="radio" name="null" value="S" />Si
			<input type="radio" name="null" value="N" checked="checked"/>No

			<label>Desplegar en Busqueda?:</label>
			<input type="radio" name="desplegar_busqueda" value="1" />Si
			<input type="radio" name="desplegar_busqueda" value="0" checked="checked"/>No
			
			<label>Desplegar en Listado?:</label>
			<input type="radio" name="desplegar_listado" value="1" />Si
			<input type="radio" name="desplegar_listado" value="0" checked="checked"/>No

			<label>Desplegar en Detalle?:</label>
			<input type="radio" name="desplegar_detalle" value="1" />Si
			<input type="radio" name="desplegar_detalle" value="0" checked="checked"/>No

			<label>Estatus:</label>
			<input type="radio" name="estado" value="1" checked="checked"/>Activo
			<input type="radio" name="estado" value="0"/>Inactivo

			<label>Default:</label>
			<input type="text" size="30" name="default" />

			<input type="hidden" name="tabla" value="<?php echo $tab; ?>" />
			<input type="hidden" name="ax" value="newfield" />
			<input type="hidden" name="p" value="<?php echo fRequest::get("p"); ?>" />
			<input type="hidden" name="seccion" value="<?php echo $seccion; ?>" />
			<input name="Enviar" type="submit" value="Guardar" />
		</form>
		</div>
		<pre>
			<div id="info">Waiting for update</div>
		</pre>
		<br/>
			<ul id="test-list">
<?php 
$cc = 0;
$cd = 0;
$ca = 0;
foreach($cols as $d){
	$cc++;
//	if($ca > 0){ echo '<tr bgcolor="'.$ut->ncolor($cc,"#f0f0f0","").'"><td>'; }
?>
	  	<li id="listItem_<?php echo $d['nombre']; ?>">
			<img src="../images/arrow.png" alt="move" width="16" height="16" class="handle" />
			<strong><?php echo $d['nombre']; ?></strong>
			[tipo = <?php echo $d['tipo']; ?>] 
			[tama&ntilde;o = <?php echo $d['tamano']; ?>]
			[estado = <?php echo $d['estado']; ?>]
			
			<div style="float:right">
				<a href="secciones_edita.php?p=<?php echo fRequest::get("p"); ?>&tabla=<?php echo $tab; ?>&sitio=<?php echo URL_SITIO; ?>"><img src="images/pencil.png" alt="edit" width="16" height="16" class="edit" /></a>
				<a href="seccion_ax.php?p=<?php echo fRequest::get("p"); ?>&ax=eliminar&tabla=<?php echo $tab; ?>&sitio=<?php echo URL_SITIO; ?>&seccion=<?php echo $seccion; ?>&nombre=<?php echo $d['nombre']; ?>"><img src="images/delete.png" alt="delete" width="16" height="16" class="delete" /></a>
			</div>
		</li>
<?php 
$ca++;
}
?>
		</ul>
	</td>
  	</tr>
</tbody>
</table>
</form>
<?php
}else{
	
$sql = "SHOW TABLES FROM ".BDD_NAME;
$secciones	= $mysql_db->query($sql);
?>
<form id="enviar" name="enviar" method="get" action="index.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><input type="hidden" name="sitio" value="Turismoenlinea.org" />
            <strong>Tabla a editar?:</strong><br />
            <select name="tabla">
                <option value="">Seleccione...</option>
                <?php 
				foreach($secciones as $s){ 
				?>
                <option value="<?php echo $s['Tables_in_richam_turismoenlinea'];?>"><?php echo $s['Tables_in_richam_turismoenlinea']; ?></option>
                <?php } ?>
            </select><br /><br />
			<input name="Enviar" type="submit" value="Registrar" />
            <input type="hidden" name="p" value="<?php echo $_GET["p"]; ?>" />
        </td>
    </tr>
</table>
</form>
<?php } ?>