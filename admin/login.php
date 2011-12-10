<?php
$date = date("Y-m-d H:i:s");
$seckey = fCryptography::hashPassword($date);
$recordar = fCookie::get("turismoenlinea","");
if(isset($_GET['m']) && $_GET['m'] != ""){
	if($_GET['m'] == "herror"){
		echo "Hemos identificado un intento de acceso de manera no esperada, si cree que es un error porfavor comuniquese con el administrador del sitio.";
	}
	
	if($_GET['m'] == "lerror"){
		echo "Su usuario y/o password son incorrectos, porfavor intente nuevamente";
	}
}
?>
<?php 
$usuario = fSession::get("usuario"); 
if(isset($usuario) && $usuario != ""){
}else{
?>
<form name="login" id="login" action="login_ax.php" method="post">
	<table width="400" border="0" cellpadding="3" cellspacing="0" align="center">
    	<tr bgcolor="#FFFF99">
    	  <td colspan="2" align="center"><strong>Ingresa tu contrase&ntilde;a y password para continuar</strong></td>
   	    </tr>
    	<tr>
        	<td><strong>Usuario:</strong></td>
            <td><input name="usuario" type="text" id="usuario" /></td>
        </tr>
        <tr>
        	<td><strong>Password:</strong></td>
            <td><input name="password" type="password" id="password" /></td>
        </tr>
        <tr>
        	<td><strong>Recordarme la pr&oacute;xima vez: </strong></td>
            <td>
            <input name="recordar" type="checkbox" value="S" />
            <input type="hidden" name="key" id="key" value="<?php echo $seckey; ?>">
            <input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
            </td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td><input name="ingresar" type="submit" value="Ingresar" /></td>
        </tr>
    </table>
</form>
<?php } ?>