<?php 
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if(isset($_GET['ax']) && $_GET['ax'] == "editar") {
	$titulo = "Edici&oacute;n de Campa&ntilde;as";
}else{
	$titulo = "Creaci&oacute;n de Campa&ntilde;as";
}
?>
<title><?php echo $titulo; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
<link rel="stylesheet" type="text/css" href="../css/south-street/jquery-ui-1.8.custom.css"/>
<script src="../js/jquery-1.4.min.js"></script>
<script src="../js/jquery-ui-1.8.custom.min.js"></script>
<script src="../js/jquery.bgiframe.min.js"></script>
<script src="../js/jquery.pngFix.pack.js"></script>
<style>
table{ font-size:10px}
</style>
<script>
$(document).ready(function(){
		
		var Options = {
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Augosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			dateFormat: 'yy-mm-dd'
		};
		
		$('#fecha_inicial').datepicker(Options);
		$('#fecha_final').datepicker(Options);

        });

$(document).pngFix();
		
function selectBanner(){
	var banner = $('#banner').val();
	$.ajax({
		url: 'campanias_ax.php?ax=banner&banner='+banner,
		success: function(data) {
					$('#divimagen').html(data);
				  }
	});
}
</script>
</head>

<body>
<?php
$ut = new Utils();
if(isset($_GET['ax']) && $_GET['ax'] == "editar") {
$campania = fRequest::get("campania");
$res = $mysql_db->query("SELECT pd.Campana, pd.Banner, pdd.Spot, pdd.Seccion, pdd.Asignacion, pb.Nombre as BannerNombre, ps.Sitio, pd.Nombre, pb.Filename, pd.Fecha_ini, pd.Fecha_fin, pd.Impresiones, pd.Contador, pd.Novence, pd.Estado, pd.Frecuencia, pd.Preferencia, pd.NoHistorial FROM pubdisplay pd INNER JOIN (SELECT Campana, Asignacion, Spot, Seccion FROM pubdisplaydetail pdda WHERE Asignacion = (SELECT max(Asignacion) FROM pubdisplaydetail WHERE Campana = pdda.Campana)) pdd ON pd.Campana = pdd.Campana INNER JOIN pubbanner pb ON pb.Banner = pd.Banner INNER JOIN pubspot ps ON pdd.Spot = ps.Spot WHERE pd.Campana = ".$campania);	
foreach($res as $r){
?>
<form action="campanias_ax.php" name="edita_campania" id="edita_campania" method="post">
	<label>Campa&ntilde;a:</label>
    <input name="campania" type="text" id="campania" value="<?php echo $r['Campana'];?>" size="11" maxlength="11" readonly="readonly" />
    <label>Nombre:</label>
    <input name="nombre" type="text" id="nombre" value="<?php echo $r['Nombre'];?>" size="50" maxlength="100"/>
    <label>Banner:</label>
   	  <select name="banner" id="banner" onchange="selectBanner();">
      	<option value="">Seleccione...</option>
		<?php 
        $rban = $mysql_db->query("SELECT * FROM pubbanner WHERE Estado = 1");
        foreach($rban as $rb){
        ?>
    	<option value="<?php echo $rb['Banner'];?>" <?php if($r['Banner'] == $rb['Banner']){ echo 'selected="selected"'; }?>><?php echo $rb['Nombre'];?></option>
		<?php } ?>
      </select><br />
      <script>
      selectBanner();
      </script>
        <div id="divimagen">&nbsp;</div>
    <label>Validez:</label>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr class="table_title">
            <td width="25%">Fecha Inicial</td>
            <td width="25%">Fecha Final</td>
            <td width="25%">Impresiones</td>
            <td>No Vence</td>
        </tr>
        <tr>
            <td><input name="fecha_inicial" type="text" id="fecha_inicial" value="<?php $rfi = explode(" ",$r['Fecha_ini']); echo $rfi[0];?>" size="10" maxlength="10" /></td>
            <td><input name="fecha_final" type="text" id="fecha_final" value="<?php $rff = explode(" ",$r['Fecha_fin']); echo $rff[0];?>" size="10" maxlength="10" /></td>
            <td><input name="impresiones" type="text" id="impresiones" value="<?php echo $r['Impresiones'];?>" size="10" maxlength="10" /></td>
            <td><input type="checkbox" name="novence" id="novence" value="1" <?php if($r['Novence'] = "1"){ echo 'checked="checked"'; }?> /></td>
        </tr>
    </table>
    <label>Varios:</label>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr class="table_title">
            <td width="25%">Contador</td>
            <td width="25%">Frecuencia</td>
            <td width="25%">Preferencia</td>
            <td>No Historial</td>
        </tr>
        <tr>
            <td><input name="contador" type="text" id="contador" value="<?php echo $r['Contador'];?>" size="10" maxlength="11" /></td>
            <td><input name="frecuencia" type="text" id="frecuencia" value="<?php echo $r['Frecuencia'];?>" size="10" maxlength="11" /></td>
            <td><input name="preferencia" type="text" id="preferencia" value="<?php echo $r['Preferencia'];?>" size="10" maxlength="11" /></td>
            <td><input type="checkbox" name="nohistorial" id="nohistorial" value="1" <?php if($r['NoHistorial'] = "1"){ echo 'checked="checked"'; }?>/></td>
        </tr>
    </table>
    <label>Desplegado en los spots:</label>
    <?php 
	$res3 = $mysql_db->query("SELECT ps.Nombre as SpotNombre, ps.EsSeccion, s.Nombre as SitioNombre, ps.Spot, ps.Sitio   FROM pubspot ps INNER JOIN sitio s ON ps.Sitio = s.Sitio ORDER BY ps.Sitio, ps.Spot;");
	?>
	<ul>
	<?php
	$sa = "";
	$c = 0;
	foreach($res3 as $r3){
	$c++;
	if($sa != $r3['Sitio'] && $c > 1){ echo '</ul></li>'; }	
	if($sa != $r3['Sitio']){ echo '<li>'.$r3['SitioNombre'].'<ul>'; }
	if($r3['EsSeccion'] == "1"){ 
	
		$res2 = $mysql_db->query("SELECT se.seccion, s.Sitio, s.Nombre as SitioNombre, se.Nombre as SeccionNombre, se.estado, se.padre, se.orden, se.Visitas, se.Tipo FROM sitio s INNER JOIN seccion se ON s.Sitio = se.Sitio WHERE se.estado = 1 AND s.Sitio = ".$r3['Sitio']." ORDER BY s.Sitio, se.orden;");
	?>
    	<li><?php echo $r3['SpotNombre']; ?>
        	<ul>
            <?php foreach($res2 as $r2){ ?>
				<li><input type="checkbox" name="seccion" id="seccion" value="<?php echo $r3['Spot']; ?>|<?php echo $r2['seccion']; ?>" <?php if($r['Seccion'] == $r2['seccion']){ echo 'checked="checked"'; }?>/><?php echo $r2['SeccionNombre']; ?></li>
			<?php } 
			
			?>
            </ul>
        </li>
	<?php
	}else{
	?>
    	<li><input type="checkbox" name="spot" id="spot" value="<?php echo $r3['Spot']; ?>" <?php if($r['Spot'] == $r3['Spot']){ echo 'checked="checked"'; }?>/><?php echo $r3['SpotNombre']; ?></li>
	<?php
	}
	$sa = $r3['Sitio'];
	}
	?>
    </ul>
    </ul>
    <br />
    <input type="hidden" name="ax" value="editar" />
    <input type="submit" value="Guardar" /> <a href="javascript: self.close();" class="cancelar">Cancelar</a>
</form>
<?php 
}
}else{ 
?>
<form action="campanias_ax.php" name="crea_banner" id="crea_banner" method="post">
  <label>Campa&ntilde;a:</label>
    <input name="campania" type="text" id="campania" value="" size="11" maxlength="11" readonly="readonly" />
    <label>Nombre:</label>
    <input name="nombre" type="text" id="nombre" value="" size="50" maxlength="100"/>
    <label>Banner:</label>
   	  <select name="banner" id="banner" onchange="selectBanner();">
      	<option value="">Seleccione...</option>
		<?php 
        $rban = $mysql_db->query("SELECT * FROM pubbanner WHERE Estado = 1");
        foreach($rban as $rb){
        ?>
    	<option value="<?php echo $rb['Banner'];?>"><?php echo $rb['Nombre'];?></option>
		<?php } ?>
      </select><br />
        <div id="divimagen">&nbsp;</div>
    <label>Validez:</label>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr class="table_title">
            <td width="25%">Fecha Inicial</td>
            <td width="25%">Fecha Final</td>
            <td width="25%">Impresiones</td>
            <td>No Vence</td>
        </tr>
        <tr>
            <td><input name="fecha_inicial" type="text" id="fecha_inicial" value="" size="10" maxlength="10" /></td>
            <td><input name="fecha_final" type="text" id="fecha_final" value="" size="10" maxlength="10" /></td>
            <td><input name="impresiones" type="text" id="impresiones" value="" size="10" maxlength="10" /></td>
            <td><input type="checkbox" name="novence" id="novence" value="1" /></td>
        </tr>
    </table>
    <label>Varios:</label>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr class="table_title">
            <td width="25%">Contador</td>
            <td width="25%">Frecuencia</td>
            <td width="25%">Preferencia</td>
            <td>No Historial</td>
        </tr>
        <tr>
            <td><input name="contador" type="text" id="contador" value="" size="10" maxlength="11" /></td>
            <td><input name="frecuencia" type="text" id="frecuencia" value="" size="10" maxlength="11" /></td>
            <td><input name="preferencia" type="text" id="preferencia" value="" size="10" maxlength="11" /></td>
            <td><input type="checkbox" name="nohistorial" id="nohistorial" value="1" /></td>
        </tr>
    </table>
    <label>Desplegado en los spots:</label>
    <?php 
	$res = $mysql_db->query("SELECT ps.Nombre as SpotNombre, ps.EsSeccion, s.Nombre as SitioNombre, ps.Spot, ps.Sitio   FROM pubspot ps INNER JOIN sitio s ON ps.Sitio = s.Sitio ORDER BY ps.Sitio, ps.Spot;");
	?>
	<ul>
	<?php
	$sa = "";
	$c = 0;
	foreach($res as $r){
	$c++;
	if($sa != $r['Sitio'] && $c > 1){ echo '</ul></li>'; }	
	if($sa != $r['Sitio']){ echo '<li>'.$r['SitioNombre'].'<ul>'; }
	if($r['EsSeccion'] == "1"){ 
	
		$res2 = $mysql_db->query("SELECT se.seccion, s.Sitio, s.Nombre as SitioNombre, se.Nombre as SeccionNombre, se.estado, se.padre, se.orden, se.Visitas, se.Tipo FROM sitio s INNER JOIN seccion se ON s.Sitio = se.Sitio WHERE se.estado = 1 AND s.Sitio = ".$r['Sitio']." ORDER BY s.Sitio, se.orden;");
	?>
    	<li><?php echo $r['SpotNombre']; ?>
        	<ul>
            <?php foreach($res2 as $r2){ ?>
				<li><input type="checkbox" name="seccion" id="seccion" value="<?php echo $r['Spot']; ?>|<?php echo $r2['seccion']; ?>" /><?php echo $r2['SeccionNombre']; ?></li>
			<?php } 
			
			?>
            </ul>
        </li>
	<?php
	}else{
	?>
    	<li><input type="checkbox" name="spot" id="spot" value="<?php echo $r['Spot']; ?>" /><?php echo $r['SpotNombre']; ?></li>
	<?php
	}
	$sa = $r['Sitio'];
	}
	?>
    </ul>
    </ul>
    <br />
    <input type="hidden" name="ax" value="crear" />
    <input type="submit" value="Guardar" /> <a href="javascript: self.close();" class="cancelar">Cancelar</a>
</form>
<?php } ?>
</body>
</html>