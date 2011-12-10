<?php
$date = date("Y-m-d H:i:s");
$key = fCryptography::hashPassword($date);
?>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<script src="js/jquery.validationEngine-en.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script>
$(function(){
	$("#contacto").validationEngine();		   
});
</script>
Por favor ingrese sus datos:<br />
    Los campos marcados con <span style="color: #cc0000">(*) &nbsp;</span>son obligatorios<br />
    <br />
<?php
$m =(isset($_GET['msg']) && $_GET['msg'] != '')?$_GET['msg']:"";
if($m != ""){
	echo '<div class="error">';
	echo $m;
	echo '</div>';
}
?>
<form name="contacto" id="contacto" action="send_mail.php" method="post">
    <table border="0" cellpadding="0" cellspacing="0">        
        <tr>
            <td style="width: 100px; height: 14px" align="right">
                <label ID="Label1">Nombre:</label><span style="color: #cc0000">*</span></td>
            <td style="width: 100px; height: 14px">
                <input type="text" ID="tbnombre" class="validate[required]"/>
			</td>
            <td style="width: 100px; height: 14px">
            </td>
        </tr>
        <tr>
            <td style="width: 100px; height: 54px;" align="right">
                <label ID="Label2">Email:</label><span style="color: #cc0000">*</span></td>
            <td style="width: 100px; height: 54px;">
                <input type="text" ID="tbemail" class="validate[requider,custom[email]]"></td>
            <td style="width: 100px; height: 54px;">
            </td>
        </tr>
        <tr>
            <td style="width: 100px; height: 21px;" align="right">
                <label ID="Label3">Telefono:</label><span style="color: #cc0000">*</span></td>
            <td style="width: 100px; height: 21px;">
                <input type="text" ID="tbtelefono" name="tbtelefono" class="validate[required]" />
                </td>
            <td style="width: 100px; height: 21px;"></td>
        </tr>
        <tr>
            <td style="width: 100px" align="right">
                <label ID="Label4">Celular:</label><span style="color: #cc0000">*</span></td>
            <td style="width: 100px">
                <input type="text" ID="tbcelular"/></td>
            <td style="width: 100px">
            </td>
        </tr>
        <tr>
            <td style="width: 100px; height: 125px" align="right">
                <label ID="Label5">Comentarios:</label><span style="color: #cc0000">*</span></td>
            <td style="width: 100px; height: 125px">
                <textarea ID="tbcomentarios" class="validate[required]"></textarea>
                <input type="hidden" name="key" value="<?php echo $key; ?>" />
                <input type="hidden" name="from" value="<?php echo fRequest::get("p")?>" />
                <input type="hidden" name="date" value="<?php echo $date; ?>" />
			</td>
            <td style="width: 100px; height: 125px">
            </td>
        </tr>
    </table>
    <center>
        <input type="submit" id="Enviar" name="Enviar" value="Enviar" class="botoncito" /></center>
</form>