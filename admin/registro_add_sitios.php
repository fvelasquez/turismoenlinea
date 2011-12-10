<?php 
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$res = "";
$sec = fRequest::get('seccion');
$id = fRequest::get('id');
$sitio = fRequest::get('sitio');
$secc = new SeccionClass();
$ut = new Utils();
$seccion = $secc->NombreSeccion($sec,'Nombre');
$ax =(isset($_GET["ax"]) && $_GET["ax"] != "")?$_GET["ax"]:"agregarsitio";
?>
<form name="sitios_estable" id="sitios_estable" method="post" action="autorizar_ax.php">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td><h2>Agregar Centros a Sitio de Interes:</h2></td>
  </tr>
  <tr>
    <td>
    <?php
    $link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
mysql_select_db(BDD_NAME,$link);
	$dep = mysql_query("SELECT departamento FROM usr_".$seccion."");
	$departamento = 'Guatemala';
	while($d = mysql_fetch_assoc($dep)){
		$departamento = $d['departamento'];
	}
	
	$hotel = mysql_query("SELECT * FROM usr_hoteles WHERE departamento = '$departamento' ORDER BY zona, municipio, nombre");
	$resta= mysql_query("SELECT * FROM usr_restaurantes WHERE departamento = '$departamento' ORDER BY zona, municipio, nombre");
	$casas= mysql_query("SELECT * FROM usr_casas WHERE departamento = '$departamento' ORDER BY nombre");
	$entre= mysql_query("SELECT * FROM usr_entretenimiento WHERE departamento = '$departamento' ORDER BY nombre");
	$trans= mysql_query("SELECT * FROM usr_transporte WHERE departamento = '$departamento' ORDER BY nombre");
	if($ax == "editarsitio"){
	$hot = mysql_query("SELECT * FROM usr_establecimiento_sitiointeres WHERE tipo = 'hoteles' AND sitiointeres = '$id' ORDER BY establecimiento");
	$ho = array();
	while($h = mysql_fetch_assoc($hot)){
		$ho[$h['establecimiento']] = 1;
	}

	$res = mysql_query("SELECT * FROM usr_establecimiento_sitiointeres WHERE tipo = 'restaurantes' AND sitiointeres = '$id' ORDER BY establecimiento");
	$re = array();
	while($r = mysql_fetch_assoc($res)){
		$re[$r['establecimiento']] = 1;
	}
	$cas = mysql_query("SELECT * FROM usr_establecimiento_sitiointeres WHERE tipo = 'casas' AND sitiointeres = '$id' ORDER BY establecimiento");
	$ca= array();
	while($c = mysql_fetch_assoc($cas)){
		$ca[$c['establecimiento']] = 1;
	}
	$ent = mysql_query("SELECT * FROM usr_establecimiento_sitiointeres WHERE tipo = 'entretenimiento' AND sitiointeres = '$id' ORDER BY establecimiento");
	$en = array();
	while($e = mysql_fetch_assoc($ent)){
		$en[$e['establecimiento']] = 1;
	}
	$tra = mysql_query("SELECT * FROM usr_establecimiento_sitiointeres WHERE tipo = 'transporte' AND sitiointeres = '$id' ORDER BY establecimiento");
	$tr = array();
	while($t = mysql_fetch_assoc($tra)){
		$tr[$t['establecimiento']] = 1;
	}
	
	}
    
	?>
    	<h2>Hoteles en el departamento de <?php echo $departamento; ?></h2>
        <div id="showdiv">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
        	<tr>
        <?php 
		$i = 0;
		while($h = mysql_fetch_assoc($hotel)){ 
		$i++;
		?>
        	<td bgcolor="<?php echo $ut->ncolor($i)?>">
            <strong><?php echo utf8_encode($h['nombre']); ?></strong><br />
            <?php if($h['zona'] != ''){echo 'Zona '.utf8_encode($h['zona']); }?>
            <?php if($h['municipio'] != ''){echo ' - '.utf8_encode($h['municipio']); }?>
            </td>
            <td bgcolor="<?php echo $ut->ncolor($i)?>">
            <?php if($ax == "editarsitio"){?>
            <input type="checkbox" name="hotel[]" value="<?php echo $h['id']; ?>" <?php if(array_key_exists($h['id'],$ho)){ echo 'checked="checked"';}?>/>
            <?php }else{ ?>
            <input type="checkbox" name="hotel[]" value="<?php echo $h['id']; ?>" />
            <?php } ?>
            </td>
        <?php 
			if(($i%4) == 0){ echo '</tr><tr>';}
		} 
		?>
	        </tr>
        </table>
        </div>
        <h2>Restaurantes en el departamento de <?php echo $departamento; ?></h2>
        <div id="showdiv">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
        	<tr>
        <?php 
		$i = 0;
		while($r = mysql_fetch_assoc($resta)){ 
		$i++;
		?>
        	<td bgcolor="<?php echo $ut->ncolor($i)?>">
			<strong><?php echo utf8_encode($r['nombre']); ?></strong><br />
            <?php if($r['zona'] != ''){echo 'Zona '.utf8_encode($r['zona']); }?>
            <?php if($r['municipio'] != ''){echo ' - '.utf8_encode($r['municipio']); }?>
            </td>
            <td bgcolor="<?php echo $ut->ncolor($i)?>">
            <?php if($ax == "editarsitio"){?>
            <input type="checkbox" name="restaurante[]" value="<?php echo $r['id']; ?>" <?php if(array_key_exists($r['id'],$re)){ echo 'checked="checked"';}?>/>
            <?php }else{ ?>
            <input type="checkbox" name="restaurante[]" value="<?php echo $r['id']; ?>" />
            <?php } ?>
            </td>
        <?php 
			if(($i%4) == 0){ echo '</tr><tr>';}
		} 
		?>
	        </tr>
        </table>
        </div>
        <h2>Casas</h2>
        <div id="showdiv">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
        	<tr>
        <?php 
		$i = 0;
		while($c = mysql_fetch_assoc($casas)){ 
		$i++;
		?>
        	<td bgcolor="<?php echo $ut->ncolor($i)?>">
			<strong><?php echo utf8_encode($c['nombre']); ?></strong><br />
            <?php if($c['zona'] != ''){echo 'Zona '.utf8_encode($c['zona']); }?>
            <?php if($c['municipio'] != ''){echo ' - '.utf8_encode($c['municipio']); }?>
            </td>
            <td bgcolor="<?php echo $ut->ncolor($i)?>">
            <?php if($ax == "editarsitio"){?>
            <input type="checkbox" name="casa[]" value="<?php echo $c['id']; ?>" <?php if(array_key_exists($c['id'],$ca)){ echo 'checked="checked"';}?>/>
            <?php }else{ ?>
            <input type="checkbox" name="casa[]" value="<?php echo $c['id']; ?>" />
            <?php } ?>
            </td>
        <?php 
			if(($i%4) == 0){ echo '</tr><tr>';}
		} 
		?>
	        </tr>
        </table>
        </div>
        <h2>Entretenimiento</h2>
        <div id="showdiv">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
        	<tr>
        <?php 
		$i = 0;
		while($e = mysql_fetch_assoc($entre)){ 
		$i++;
		?>
        	<td bgcolor="<?php echo $ut->ncolor($i)?>">
			<strong><?php echo utf8_encode($e['nombre']); ?></strong><br />
            <?php if($e['zona'] != ''){echo 'Zona '.utf8_encode($e['zona']); }?>
            <?php if($e['municipio'] != ''){echo ' - '.utf8_encode($e['municipio']); }?>
            </td>
            <td bgcolor="<?php echo $ut->ncolor($i)?>">
            <?php if($ax == "editarsitio"){?>
            <input type="checkbox" name="entretenimiento[]" value="<?php echo $e['id']; ?>" <?php if(array_key_exists($e['id'],$en)){ echo 'checked="checked"';}?>/>
            <?php }else{ ?>
            <input type="checkbox" name="entretenimiento[]" value="<?php echo $e['id']; ?>" />
            <?php } ?>
            </td>
        <?php 
			if(($i%4) == 0){ echo '</tr><tr>';}
		} 
		?>
	        </tr>
        </table>
        </div>
        <h2>Transporte</h2>
        <div id="showdiv">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
        	<tr>
        <?php 
		$i = 0;
		while($t = mysql_fetch_assoc($trans)){ 
		$i++;
		?>
        	<td bgcolor="<?php echo $ut->ncolor($i)?>">
			<strong><?php echo utf8_encode($t['nombre']); ?></strong><br />
            <?php if($t['zona'] != ''){echo 'Zona '.utf8_encode($t['zona']); }?>
            <?php if($t['municipio'] != ''){echo ' - '.utf8_encode($t['municipio']); }?>
            </td>
            <td bgcolor="<?php echo $ut->ncolor($i)?>">
            <?php if($ax == "editarsitio"){?>
            <input type="checkbox" name="transporte[]" value="<?php echo $t['id']; ?>" <?php if(array_key_exists($t['id'],$tr)){ echo 'checked="checked"';}?>/>
            <?php }else{ ?>
            <input type="checkbox" name="transporte[]" value="<?php echo $t['id']; ?>" />
            <?php } ?>
            </td>
        <?php 
			if(($i%4) == 0){ echo '</tr><tr>';}
		} 
		?>
	        </tr>
        </table>
        </div>
    	<input type="hidden" name="ax" value="<?php echo $ax; ?>" />
        
        <input type="hidden" name="seccion" value="<?php echo fRequest::get("seccion"); ?>" />
        <input type="hidden" name="sitio" value="<?php echo fRequest::get("sitio"); ?>" />
        <input type="hidden" name="id" value="<?php echo fRequest::get("id"); ?>" />
        <?php if($ax == "editarsitio"){?>
        <input type="hidden" name="from" value="editar" />
        <?php }else{?>
        <input type="hidden" name="from" value="admin" />
        <?php } ?>
        
    </td>
  </tr>
  <tr>
    <td>
    <?php if($ax == "editarsitio"){?>
    <input type="submit" name="subir" id="subir" value="Guardar" />
    <?php }else{?>
    <input type="submit" name="subir" id="subir" value="Continuar" />
    <?php } ?>
    </td>
  </tr>
</table>
</form>