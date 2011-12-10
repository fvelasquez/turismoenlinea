<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();
$date = fRequest::get("date");
$hash = fRequest::get("key");
$recordar = fRequest::get("recordar");

if (fCryptography::checkPasswordHash($date, $hash)) {

	$usuario = fRequest::get('usuario');
	$password = fRequest::get('password');
	$hash1 = "";
	$res = $mysql_db->query("SELECT * FROM usuario WHERE usuario = '$usuario'");
	foreach($res as $r){
		$hash1 = $r['contrasena'];
		$username = $r['usuario'];
		$name1 = $r['name1'];
		$name2 = $r['name2'];
		$email = $r['email'];
		$tipo = $r['tipo'];
	}
	//echo fCryptography::hashPassword($password);
	if (fCryptography::checkPasswordHash($password, $hash1)) {
		
		fSession::open();
		fSession::set("username",$username);
		fSession::set("nombre",$name1);
		fSession::set("apellido",$name2);
		fSession::set("email",$email);
		fSession::set("tipousuario",$tipo);
		if($recordar == "S"){
			fCookie::set("turismoenlinea",$recordar);
			fCookie::set("turismoenlinea",$username);
		}
	    echo "<script>window.location = 'index.php?p=1'</script>";
		
	}else{
		echo "<script>window.location = 'index.php?p=1&m=lerror'</script>";
	}

}else{
	echo "<script>window.location = 'index.php?p=login&m=herror'</script>";
}
?>