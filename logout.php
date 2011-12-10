<?php
include_once($_SERVER['DOCUMENT_ROOT'] . 'init.php');
include_once("includes/conexion.php");
include_once("includes/funciones.php");

		$tipo = fSession::get("tipousuario");
		fSession::destroy();
		fCookie::set("turismoenlinea","default_value","10 seconds");
		
		if($tipo == "admin"){ $redir = "<script>window.location = 'admin/index.php?p=main'</script>";}
		if($tipo == "turismo"){ $redir = "<script>window.location = 'index.php?p=22'</script>";}
		if($tipo == "salud"){ $redir = "<script>window.location = 'index.php?p=22'</script>";}
	    echo $redir;
?>