<?php 
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if(isset($_GET['ax']) && $_GET['ax'] == "editar") {
	$titulo = "Edici&oacute;n de Spot";
}else{
	$titulo = "Creaci&oacute;n de Spot";
}
?>
<title><?php echo $titulo; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
</head>

<body>
<?php if(isset($_GET['ax']) && $_GET['ax'] == "editar") {
$spot = fRequest::get("spot");
$ut = new Utils();
$res = $mysql_db->query("SELECT * FROM pubspot WHERE Spot = ".$spot." ORDER BY Spot");	
foreach($res as $r){
?>
<form action="spots_ax.php" name="edita_spot" id="edita_spot" method="post">
	<label>Banner:</label>
    <input name="spot" type="text" id="spot" value="<?php echo $r['Spot']; ?>" size="11" maxlength="11" readonly="readonly" />
    <label>Nombre:</label>
    <input name="nombre" type="text" id="nombre" value="<?php echo $r['Nombre']; ?>" size="50" maxlength="100"/>
    <label>Dimensiones:</label>
    <input name="ancho" type="text" id="ancho" value="<?php echo $r['Width']; ?>" size="11" maxlength="11"/> x 
    <input name="alto" type="text" id="alto" value="<?php echo $r['Height']; ?>" size="11" maxlength="11"/>
    <label>Estirar:</label>
    <select name="estirar" id="estirar">
    	<option value="1" <?php if($r['Strech'] == "1"){ echo 'selected="selected"';} ?>>Si</option>
        <option value="0" <?php if($r['Strech'] == "0"){ echo 'selected="selected"';} ?>>No</option>
    </select>
    <br /><br />
    <input type="hidden" name="ax" value="editar" />
    <input type="submit" value="Guardar" /> <a href="javascript: self.close();" class="cancelar">Cancelar</a>
</form>
<?php 
}
}else{ 
?>
<form action="spots_ax.php" name="crea_spot" id="crea_spot" method="post">
  <label>Spot:</label>
    <input name="spot" type="text" id="spot" value="" size="11" maxlength="11" readonly="readonly" />
  <label>Nombre:</label>
    <input name="nombre" type="text" id="nombre" value="" size="50" maxlength="100"/>
  <label>Dimensiones:</label>
    <input name="ancho" type="text" id="ancho" value="" size="11" maxlength="11"/> x 
   	<input name="alto" type="text" id="alto" value="" size="11" maxlength="11"/>
  <label>Estirar:</label>
    <select name="estirar" id="estirar">
    	<option value="1" selected="selected">Si</option>
        <option value="0">No</option>
    </select>
    <input type="hidden" name="ax" value="crear" />
    <input type="submit" value="Guardar" /> <a href="javascript: self.close();" class="cancelar">Cancelar</a>
</form>
<?php } ?>
</body>
</html>