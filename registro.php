<?php
$ut = new Utils();

if(isset($_GET['grabar']) && $_GET['grabar'] == 'grabar'){
	
	$nombre = fRequest::get("txtNombre");
	$apellido = fRequest::get("txtApellido");
	$email = fRequest::get("txtCorreo");
	$pais = fRequest::get("cmbPais");
	$usuario  = fRequest::get("txtUsuario");
	$pass = fRequest::get("txtPass");
	$password = $ut->GeneraPassword($pass);
	$pregunta = fRequest::get("txtPregunta");
	$respuesta = fRequest::get("txtRespuesta");
	
	$res = $mysql_db->query("INSERT INTO usuario (usuario,contrasena,pregunta,respuesta,name1,name2,email,pais,password) VALUES ('$usuario','".$password."','$pregunta','$respuesta','$nombre','$apellido','$email','$pais','$pass')");
	
	//Redirect porque los headers ya han sido enviados por index.php
	echo "<script>window.location = 'index.php?p=20'</script>";
}
?>
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css"/>
<script src="js/jquery.validationEngine-en.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script language="javascript" type="text/javascript">
// <!CDATA[
$(document).ready(function() {
	$("#form1").validationEngine()
});


function checkUser() {

}

// ]]>
</script>
    Registro de usuario GRATIS!<br />
    Si ya tiene usuario creado porfavor Ingrese en el apartado superior.<br />
    &nbsp;&nbsp;&nbsp;<br /><br />
    Los campos marcados con <span style="color: #cc0000">(*) &nbsp;</span>son obligatorios<br /><br />
    <form id="form1" name="form1" action="index.php" method="get">
    <table style="width: 100%; color: #000000;">
        <tr>
            <td align="right" style="width: 119px">Nombre: <span style="color: Red; font-weight: bold">*</span></td>
            <td style="width: 2px">
                <input type="text" name="txtNombre" ID="txtNombre" class="validate[required]"/></td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">Apellido: <strong><span style="color: #ff0000">*</span></strong></td>
            <td style="width: 2px">
                <input type="text" name="txtApellido" ID="txtApellido" class="validate[required]"/></td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">Correo Electronico: <strong><span style="color: #ff0000">*</span></strong></td>
            <td style="width: 2px">
				<input type="text" name="txtCorreo" id="txtCorreo" Width="248px" class="validate[required,custom[email]]"/>
            </td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px; height: 24px;">Pais:</td>
            <td style="width: 2px; height: 24px;">
            	<select name="cmbPais" id="cmbPais">
                <option value="">Seleccione...</option>
				<?php
					$link = mysql_connect('127.0.0.1','root', 'igj6114154');
					mysql_select_db('hface_turismoenlinea',$link);
					
                    $pr = mysql_query("SELECT * FROM pais ORDER BY Codigo");
					while($p = mysql_fetch_assoc($pr)){
						echo '<option value="'.$p["Codigo"].'">'.$p["Nombre"].'</option>';
					}
                ?>
                </select>
                </td>
            <td style="width: 3px; height: 24px">&nbsp;</td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">
                <br />
            </td>
            <td style="width: 2px">
            </td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">Usuario: <strong><span style="color: #ff0000">*</span></strong></td>
            <td style="width: 2px">
			<input type="text" name="txtUsuario" id="txtUsuario" class="validate[required]" onblur="checkUser();"/>
            </td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">Contraseña: <strong><span style="color: #ff0000">*</span></strong></td>
            <td style="width: 2px">
                <input type="password" ID="txtPass" name="txtPass" class="validate[required]"/>
            </td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">Repita su contraseña: <strong><span style="color: #ff0000">*</span></strong></td>
            <td style="width: 2px">
                <nobr><input type="password" name="txtPass2" id="txtPass2" class="validate[required]"/></nobr>
            </td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">
                <br />
            </td>
            <td style="width: 2px">
            </td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td colspan="2">Para recordar su contraseña:</td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">Pregunta:</td>
            <td style="width: 2px">
                <input type="text" name="txtPregunta" ID="txtPregunta" Width="246px" class="validate[required]"/></td>
            <td style="width: 3px">
            </td>
        </tr>
        <tr>
            <td align="right" style="width: 119px">Respuesta:</td>
            <td style="width: 2px">
                <input type="text" name="txtRespuesta" ID="txtRespuesta" Width="245px" class="validate[required]"/></td>
            <td style="width: 3px">
            </td>
        </tr>
    </table>
    <center>
    	<input type="hidden" id="p" name="p" value="<?php echo $_GET["p"]; ?>" />
        <input type="hidden" id="grabar" name="grabar" value="grabar" />
        <input type="submit" ID="btnEnvio" class="botoncito" value="Enviar" /><br />
        &nbsp;</center>
    <br />
    <br />
</form>