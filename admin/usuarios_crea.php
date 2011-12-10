<?php 
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
?>
<?php 
if(isset($_GET['ax']) && $_GET['ax'] == "editar") {
	$titulo = "Edici&oacute;n de Usuarios";
}else{
	$titulo = "Creaci&oacute;n de Usuarios";
}

//Datos de Pais
	$paises = $mysql_db->query("SELECT * FROM pais ORDER BY Codigo");
	$departamentos = $mysql_db->query("SELECT distinct departamento FROM usr_departamentos ORDER BY departamento");
?>
<h2><?php echo $titulo; ?></h2>
<link rel="stylesheet" type="text/css" href="../css/south-street/jquery-ui-1.8.custom.css">
<link rel="stylesheet" type="text/css" href="../css/validationEngine.jquery.css">
<script src="../js/jquery-ui-1.8.custom.min.js"></script>
<script src="../js/jquery.validationEngine-en.js"></script>
<script src="../js/jquery.validationEngine.js"></script>

<script>
$(document).ready(function(){
		
		var Options = {
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Augosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			dateFormat: 'yy-mm-dd'
		};
		
		$('#fechanac').datepicker(Options);

});

</script>
<?php 
if(isset($_GET['msg']) && $_GET['msg'] != ''){
	switch($_GET['msg']){
		case 'errorpass':
			$msg = 'Error: Los passwords ingresados no son iguales.';
		break;
	}
	echo '<div id="message">'.$msg.'</div><script>$(function(){ $(\'#password\').focus(); });</script>';
}
?>
<?php 
if(isset($_GET['ax']) && $_GET['ax'] == "editar") {
	$usuario = fRequest::get("usuario");
	$ut = new Utils();
	$date = date("Y-m-d H:i:s");
	$res = $mysql_db->query("SELECT * FROM usuario WHERE usuario = '".$usuario."' ORDER BY usuario");	
	foreach($res as $r){
?>
<form action="usuarios_ax.php" name="form1" id="form1" method="post">
    <label>Usuario:</label>
    	<input name="usuario" type="text" id="usuario" value="<?php echo $r['usuario']; ?>" size="20" maxlength="50" readonly="readonly" />
    <div style="background-color:#FFDEDE">
    <span class="form_subtext">Solo ingresa el password si deseas cambiarlo</span>
    <label>Password:</label>
    	<input name="password" type="password" id="password" value="" size="30" maxlength="50" />
	<label>Confirmar Password:</label>
    	<input name="passwordc" type="password" id="passwordc" value="" size="30" maxlength="50"  class="validate[confirm[password]]"/>
	</div>
    <label>Pregunta Secreta:</label>
    	<input name="pregunta" type="text" id="pregunta" value="<?php echo $r['pregunta']; ?>" size="30" maxlength="250" class="validate[required]" />
    <label>Respuesta Secreta:</label>
    	<input name="respuesta" type="text" id="respuesta" value="<?php echo $r['respuesta']; ?>" size="30" maxlength="250" class="validate[required]" />
    <label>Nombre:</label>
    	<input name="nombre" type="text" id="nombre" value="<?php echo $r['name1']; ?>" size="30" maxlength="150" class="validate[required]" />
    <label>Apellido:</label>
    	<input name="apellido" type="text" id="apellido" value="<?php echo $r['name2']; ?>" size="30" maxlength="150"/>
    <label>Correo Electr&oacute;nico:</label>
    	<input name="email" type="text" id="email" value="<?php echo $r['email']; ?>" size="30" maxlength="255" class="validate[required,email]" />
    <label>No. Identificacion:</label>
    	<input name="identificacion" type="text" id="identificacion" value="<?php echo $r['no_identificacion']; ?>" size="30" maxlength="150"/>
    <label>Telefonos:</label>
    	<input name="telefono1" type="text" id="telefono1" value="<?php echo $r['tel1']; ?>" size="10" maxlength="10" class="validate[required]"/>
    	<input name="telefono2" type="text" id="telefono2" value="<?php echo $r['tel2']; ?>" size="10" maxlength="10"/>
    <label>Fax:</label>
    	<input name="fax" type="text" id="fax" value="<?php echo $r['fax']; ?>" size="10" maxlength="10"/>
    <label>Pais:</label>
        <select id="pais" name="pais" class="validate[required]">
    	<option value="">Seleccione...</option>
        <?php foreach($paises as $p){ ?>
        <option value="<?php echo $p['Nombre']; ?>" <?php if($r['pais'] == $p['Nombre']){ echo 'selected="selected"'; } ?>><?php echo $p['Nombre']; ?></option>
        <?php } ?>
    </select>
  <label>Departamento:</label>
    <select id="depto" name="depto" class="validate[required]">
    	<option value="">Seleccione...</option>
        <?php foreach($departamentos as $d){ ?>
        <option value="<?php echo $d['departamento']; ?>" <?php if($r['departamento'] == $d['departamento']){ echo 'selected="selected"'; } ?>><?php echo $d['departamento']; ?></option>
        <?php } ?>
    </select>
    <label>Ciudad:</label>
    	<input name="ciudad" type="text" id="ciudad" value="<?php echo $r['ciudad']; ?>" size="30" maxlength="50"/>
    <label>Zona:</label>
   		<input name="zona" type="text" id="zona" value="<?php echo $r['zona']; ?>" size="30" maxlength="50"/>
    <label>Colonia:</label>
    	<input name="colonia" type="text" id="colonia" value="<?php echo $r['colonia']; ?>" size="30" maxlength="50"/>
    <label>Direccion:</label>
    	<input name="direccion" type="text" id="direccion" value="<?php echo $r['direccion']; ?>" size="30" maxlength="50" class="validate[required]"/>
    <label>Fecha Nacimiento:</label>
    	<input name="fechanac" type="text" id="fechanac" value="<?php echo $r['fechanac']; ?>" size="10" maxlength="10"/>
    <label>Como se enter&oacute;?:</label>
    	<input name="como_entero" type="text" id="como_entero" value="<?php echo $r['entero']; ?>" size="30" maxlength="50"/>
    <label>Tipo:</label>
        <select id="tipo" name="tipo" class="validate[required]">
        	<option value="">Seleccione...</option>
            <option value="admin" <?php if($r['tipo'] == "admin"){ echo 'selected="selected"'; } ?>>Administrador</option>
            <option value="salud" <?php if($r['tipo'] == "salud"){ echo 'selected="selected"'; } ?>>Usuario Salud En Linea</option>
            <option value="turismo" <?php if($r['tipo'] == "turismo"){ echo 'selected="selected"'; } ?>>Usuario Turismo En Linea</option>
        </select>
    <label>Activar?:</label>
        <input name="estado" type="radio" value="1" <?php if($r['estado'] == "1"){ echo 'checked="checked"'; } ?>/> Si
        <input name="estado" type="radio" value="0" <?php if($r['estado'] == "0"){ echo 'checked="checked"'; } ?>/> No
        <br />
	    <br />
    <input type="hidden" name="ax" value="editar" />
    <input type="submit" value="Guardar" /> <a href="javascript: history.back(-1);" class="cancelar">Cancelar</a>
</form>
<?php 
}
}else{ 
?>
<form action="usuarios_ax.php" name="form1" id="form1" method="post">
  <label>Usuario:</label>
    <input name="usuario" type="text" id="usuario" value="" size="20" maxlength="50" class="validate[required]"/>
<label>Password:</label>
    <input name="password" type="password" id="password" value="" size="30" maxlength="50"  class="validate[required]"/>
<label>Confirmar Password:</label>
    <input name="password" type="password" id="password" value="" size="30" maxlength="50"  class="validate[required,confirm[password]]"/>
  <label>Pregunta Secreta:</label>
    <input name="pregunta" type="text" id="pregunta" value="" size="30" maxlength="250"/>
  <label>Respuesta Secreta:</label>
    <input name="respuesta" type="text" id="respuesta" value="" size="30" maxlength="250"/>
  <label>Nombre:</label>
    <input name="nombre" type="text" id="nombre" value="" size="30" maxlength="150" class="validate[required]"/>
  <label>Apellido:</label>
    <input name="apellido" type="text" id="apellido" value="" size="30" maxlength="150" class="validate[required]"/>
  <label>Correo Electr&oacute;nico:</label>
    <input name="email" type="text" id="email" value="" size="30" maxlength="255" class="validate[required,email]"/>
  <label>No. Identificacion:</label>
    <input name="identificacion" type="text" id="identificacion" value="" size="30" maxlength="150"/>
  <label>Telefonos:</label>
    <input name="telefono1" type="text" id="telefono1" value="" size="10" maxlength="10" class="validate[required]"/>
    <input name="telefono2" type="text" id="telefono2" value="" size="10" maxlength="10"/>
  <label>Fax:</label>
    <input name="fax" type="text" id="fax" value="" size="10" maxlength="10"/>
  <label>Pais:</label>
  	<select id="pais" name="pais" class="validate[required]">
    	<option value="">Seleccione...</option>
        <?php foreach($paises as $p){ ?>
        <option value="<?php echo $p['Codigo']; ?>"><?php echo $p['Nombre']; ?></option>
        <?php } ?>
    </select>
  <label>Departamento:</label>
    <select id="depto" name="depto" class="validate[required]">
    	<option value="">Seleccione...</option>
        <?php foreach($departamentos as $d){ ?>
        <option value="<?php echo $d['departamento']; ?>"><?php echo $d['departamento']; ?></option>
        <?php } ?>
    </select>
  <label>Ciudad:</label>
    <input name="ciudad" type="text" id="ciudad" value="" size="30" maxlength="50"/>
  <label>Zona:</label>
    <input name="zona" type="text" id="zona" value="" size="30" maxlength="50"/>
  <label>Colonia:</label>
    <input name="colonia" type="text" id="colonia" value="" size="30" maxlength="50"/>
  <label>Direccion:</label>
    <input name="direccion" type="text" id="direccion" value="" size="30" maxlength="50" class="validate[required]"/>
  <label>Fecha Nacimiento:</label>
    <input name="fechanac" type="text" id="fechanac" value="" size="10" maxlength="10"/>
  <label>Como se enter&oacute;?:</label>
    <input name="como_entero" type="text" id="como_entero" value="" size="30" maxlength="50" class="validate[required]"/>
  <label>Tipo:</label>
    <select id="tipo" name="tipo" class="validate[required]">
        <option value="">Seleccione...</option>
        <option value="admin">Administrador</option>
        <option value="salud">Usuario Salud En Linea</option>
        <option value="turismo">Usuario Turismo En Linea</option>
    </select>
  <label>Activar?:</label>
  <input name="estado" type="radio" value="1" /> Si
    <input name="estado" type="radio" value="0" checked /> No
    <br />
    <br />
<input type="hidden" name="ax" value="crear" />
	<input type="submit" value="Guardar" /> <a href="javascript: history.back(-1);" class="cancelar">Cancelar</a>
</form>
<?php } ?>
<script>
$(document).ready(function() {
	$("#form1").validationEngine()
})
</script>