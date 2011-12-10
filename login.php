<?php
include_once($_SERVER['DOCUMENT_ROOT'] . 'init.php');
include_once("includes/conexion.php");
include_once("includes/funciones.php");
$spot = new spot();
if(isset($_POST['Entrar']) && $_POST['Entrar'] == 'Entrar'){

	$usuario = fRequest::get('usuario');
	$password = fRequest::get('password');
	echo $usuario;
	echo $password;
	$hash = "";
	$res = $mysql_db->query("SELECT * FROM usuario WHERE usuario = '$usuario'");
	foreach($res as $r){
		$hash = $r['contrasena'];
		$nombre = $r['name1'];
		$apellido = $r['name2'];
		$email = $r['email'];
		$tipo = $r['tipo'];
		$pais = $r['pais'];
	}

	if (fCryptography::checkPasswordHash($password, $hash)) {
		fSession::open();
//		fSession::setPath('/path/to/private/writable/dir');
//		fSession::setLength('30 minutes', '1 week');
		fSession::set("username",$usuario);
		fSession::set("nombre",$name1);
		fSession::set("apellido",$name2);
		fSession::set("email",$email);
		fSession::set("tipousuario",$tipo);
		fSession::set("pais",$pais);
		
		if($tipo == "admin"){ $redir = "<script>window.location = 'admin/index.php?p=1'</script>";}
		if($tipo == "turismo"){ $redir = "<script>window.location = 'index.php?p=22'</script>";}
		if($tipo == "salud"){ $redir = "<script>window.location = 'index.php?p=22'</script>";}
	    echo $redir;
	}else{
		$m = "Password o usuario incorrecto";
		$redir = "<script>window.location = 'index.php?";
		$redir .=(isset($_POST['p']) && $_POST['p'] != "")?"p=".$_POST['p']."&":"";
		$redir .= "msg=$m'</script>";
		echo $redir;
	}

	//Redirect porque los headers ya han sido enviados por index.php
	

	
}

?>