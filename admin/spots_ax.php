<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ax = fRequest::get("ax");
$spot = fRequest::get("spot");
if($ax == "editar"){
	$ut = new Utils();
	$nombre = fRequest::get("nombre");
	$alto = fRequest::get("alto");
	$ancho = fRequest::get("ancho");
	$estirar = fRequest::get("estirar");
		
	$qry = "UPDATE pubspot SET Nombre = '$nombre', Width = '$ancho',Height = '$alto',Strech = '$estirar' WHERE Spot = ".$spot;
	$res = $mysql_db->query($qry);
}
	echo "<script>opener.location.reload(); self.close();</script>";
?>