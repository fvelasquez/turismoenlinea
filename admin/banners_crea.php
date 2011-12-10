<?php 
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if(isset($_GET['ax']) && $_GET['ax'] == "editar") {
	$titulo = "Edici&oacute;n de Banners";
}else{
	$titulo = "Creaci&oacute;n de Banners";
}
?>
<title><?php echo $titulo; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
</head>

<body>
<?php if(isset($_GET['ax']) && $_GET['ax'] == "editar") {
$banner = fRequest::get("banner");
$ut = new Utils();
$date = date("Y-m-d H:i:s");
$res = $mysql_db->query("SELECT * FROM pubbanner WHERE Banner = ".$banner." ORDER BY Banner");	
foreach($res as $r){
?>
<form action="banners_ax.php" name="edita_banner" id="edita_banner" enctype="multipart/form-data" method="post">
	<label>Banner:</label>
    <input name="banner" type="text" id="banner" value="<?php echo $r['Banner']; ?>" size="11" maxlength="11" readonly="readonly" />
    <label>Nombre:</label>
    <input name="nombre" type="text" id="nombre" value="<?php echo $r['Nombre']; ?>" size="50" maxlength="100"/>
    <label>Archivo:</label>
    <img src="../images/<?php echo $r['Filename']; ?>" border="0" /><br />
    <input name="file[]" type="file" id="file" value="" size="30"/> 
    <label>Link:</label>
    <input name="link" type="text" id="link" value="<?php if($r['Link'] == ""){ echo "http://"; }else{ echo $r['Link']; } ?>" size="50" maxlength="500"/><br />
    <input type="hidden" name="fanterior" value="<?php echo $r['Filename']; ?>" />
    <input type="hidden" name="ax" value="editar" />
    <input type="submit" value="Guardar" /> <a href="javascript: self.close();" class="cancelar">Cancelar</a>
</form>
<?php 
}
}else{ 
?>
<form action="banners_ax.php" name="crea_banner" id="crea_banner" enctype="multipart/form-data" method="post">
  <label>Banner:</label>
    <input name="banner" type="text" id="banner" value="" size="11" maxlength="11" readonly="readonly" />
  <label>Nombre:</label>
    <input name="nombre" type="text" id="nombre" value="" size="50" maxlength="100"/>
    <label>Archivo:</label>
    <input name="file[]" type="file" id="file" value="" size="30"/>
  <label>Link:</label>
    <input name="link" type="text" id="link" value="http://" size="50" maxlength="500"/><br />
    <input type="hidden" name="ax" value="crear" />
    <input type="submit" value="Guardar" /> <a href="javascript: self.close();" class="cancelar">Cancelar</a>
</form>
<?php } ?>
</body>
</html>