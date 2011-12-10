<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ax = fRequest::get("ax");
$usuario = fRequest::get("usuario");
$res = "";
if($ax == "activar"){
	$qry = "UPDATE usuario SET Estado = '1' WHERE usuario = '".$usuario."'";
	$mysql_db->query($qry);
	header("Location: index.php?p=4&msg=activado#".$usuario);
}
if($ax == "desactivar"){
	$qry = "UPDATE usuario SET Estado = '0' WHERE usuario = '".$usuario."'";
	$mysql_db->query($qry);
	header("Location: index.php?p=4&msg=desactivado#".$usuario);
}

if($ax == "eliminar"){
	
	$qry = "DELETE FROM usuario WHERE usuario = '".$usuario."'";
	$mysql_db->query($qry);
	header("Location: index.php?p=4&msg=eliminado");
}

if($ax == "editar"){
		$nombre = fRequest::get("nombre");
		$apellido = fRequest::get("apellido");
		$pregunta = fRequest::get("pregunta");
		$respuesta = fRequest::get("respuesta");
		$email = fRequest::get("email");
		$iden = fRequest::get("identificacion");
		$tel1 = fRequest::get("telefono1");
		$tel2 = fRequest::get("telefono2");
		$fax = fRequest::get("fax");
		$pais = fRequest::get("pais");
		$departamento = fRequest::get("depto");
		$ciudad = fRequest::get("ciudad");
		$zona = fRequest::get("zona");
		$colonia = fRequest::get("colonia");
		$direccion = fRequest::get("direccion");
		$fechanac = fRequest::get("fechanac");
		$entero = fRequest::get("como_entero");
		$tipo = fRequest::get("tipo");
		$estado = fRequest::get("estado");
		
		$password = fRequest::get("password");
		$passwordc = fRequest::get("passwordc");
		$passwordF = '';
		if($password == $passwordc){
			$passwordF = fCryptography::hashPassword($password);
		}else{
			echo "<script>window.location = 'index.php?p=41&ax=editar&usuario=".$usuario."&msg=errorpass'</script>";
		}
		
		
		$qry = "UPDATE usuario SET name1 = '$nombre',name2 = '$apellido',tel1 = '$tel1',tel2 = '$tel2',";
		$qry .= "fax = '$fax',no_identificacion = '$iden', pregunta = '$pregunta', respuesta = '$respuesta', email = '$email',";
		$qry .= "pais = '$pais',departamento = '$departamento', ciudad = '$ciudad', zona = '$zona', colonia = '$colonia',";
		$qry .= "direccion = '$direccion', fechanac = '$fechanac', entero = '$entero', tipo = '$tipo', estado = '$estado'";
		if($passwordF != ''){
		$qry .= ",contrasena = '$passwordF'";
		}
		$qry .= " WHERE usuario = '".$usuario."'";
		$res = $mysql_db->query($qry);
}

if($ax == "crear"){
	
	$nombre = fRequest::get("nombre");
		$apellido = fRequest::get("apellido");
		$pregunta = fRequest::get("pregunta");
		$respuesta = fRequest::get("respuesta");
		$email = fRequest::get("email");
		$iden = fRequest::get("identificacion");
		$tel1 = fRequest::get("telefono1");
		$tel2 = fRequest::get("telefono2");
		$fax = fRequest::get("fax");
		$pais = fRequest::get("pais");
		$departamento = fRequest::get("depto");
		$ciudad = fRequest::get("ciudad");
		$zona = fRequest::get("zona");
		$colonia = fRequest::get("colonia");
		$direccion = fRequest::get("direccion");
		$fechanac = fRequest::get("fechanac");
		$entero = fRequest::get("como_entero");
		$tipo = fRequest::get("tipo");
		$estado = fRequest::get("estado");
		
		$qry = "INSERT INTO usuario (usuario,name1,name2,tel1,tel2,fax,no_identificacion,pregunta,respuesta,email,pais,departamento,ciudad,zona,colonia,direccion,fechanac,entero,tipo,estado) VALUES ('$usuario','$nombre','$apellido','$tel1','$tel2','$fax','$iden','$pregunta','$respuesta','$email','$pais','$departamento','$ciudad','$zona','$colonia','$direccion','$fechanac','$entero','$tipo','$estado')";
		$res = $mysql_db->query($qry);
		
}
	echo "<script>window.location = 'index.php?p=4&msg=operacionexitosa'</script>";
?>