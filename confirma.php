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
<h3>Gracias por registrarse</h3>
<h4>Ingrese aqu&iacute;</h4>
<?php
$m =(isset($_GET['msg']) && $_GET['msg'] != '')?$_GET['msg']:"";
if($m != ""){
	echo '<div class="error">';
	echo $m;
	echo '</div>';
}
?>
<form name="form1" id="form1" method="post" action="login.php">
<table border="0" cellpadding="0" style="width: 399px; height: 127px" align="center">
<tr>
  <td><label for="usuario">Usuario:</label></td>
    <td>
        
        <input name="p" type="hidden" value="<?php 
		$p = $_GET['p'];
		$p = ($p == '')?$_POST['p']:$p;
		echo $p;?>">
        <input name="usuario" id="usuario" type="text" class="validate[required]" /> <strong><span style="color: #ff0000">*</span></strong>
        &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
    </td>
</tr>
<tr>
  <td><label for="password">Password:</label></td>
    <td><input name="password" id="password" type="password" class="validate[required]" />
        <strong><span style="color: #ff0000">*</span></strong>
        </td>
</tr>
<tr>
  <td>&nbsp;</td>
    <td>
            <input type="submit" name="Entrar" id="Entrar" value="Entrar" class="botoncito">
        </td>
</tr>
</table>