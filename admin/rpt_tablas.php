<?php
include ("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

$sec 	= fRequest::get('seccion');
$sitio 	= fRequest::get('sitio');
$pagina	= fRequest::get('p');

$seccion 	= $secc->NombreSeccion($sec,'Nombre');
$res = $mysql_db->query("SELECT * FROM seccion WHERE estado = 1 ORDER BY NombreLargo, seccion");
?>
<script>
    function eliminaFila(seccion,sitio,id)
    {
        var con = confirm('Esta seguro de querer eliminar la fila?');
        if(con)
        {
            window.location = 'index.php?p=87&pa=<?php echo fRequest::get('p'); ?>&seccion='+seccion+'&sitio='+sitio+'&id='+id;
        }else{
            return false;
        }
    }

    function exportar(sec)
    {
        window.location= "rpt_tablas_ex.php?seccion="+sec;
    }
</script>
<form action="index.php" method="GET">
<strong>Listado de registros en tabla:</strong>
<select name="seccion">
<?php
$c = 0;
$s = "";
foreach($res as $r){
$c++;
    echo '<option value="'.$r['seccion'].'" ';
    if($sec == $r['seccion']){ echo 'selected="selected" ';}
    echo '>'.$r['NombreLargo'].'</option>';
}
?>
</select>
<input type="submit" name="buscar" value="Buscar" />
<?php if ($sec != ''){ ?>
<input type="button" value="Exportar a Excel" onmousedown="exportar('<?php echo $sec; ?>');" />
<?php } ?>
<input type="hidden" name="p" value="<?php echo $pagina; ?>" />
<input type="hidden" name="sitio" value="<?php echo $sitio; ?>" />
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#FF6600" style="color:#FFF; font-weight:bold;">
<?php
$c = 0;
if ($sec != ''){
$cols	= $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." and display_listado = 1 ORDER BY orden");
$fields = array();
foreach($cols as $d){
?>
    <td>
		<?php
        $fields[] = $d['nombre'];
        echo $d['nombre_largo'];
        ?>
    </td>
<?php
}
?>
	<td>Acciones</td>
  </tr>
<?php
$flt = "";
if(isset($_GET['search']) && $_GET['search'] != ""){
	$search = fRequest::get("search");
	$flt = "WHERE nombre LIKE '%".$search."%'";
}
$ord = "ORDER BY nombre";
if(isset($_GET['ord']) && $_GET['ord'] != ""){
	$ord = fRequest::get("ord");
}
$r = $mysql_db->query("SELECT * FROM usr_".$seccion." ".$flt." ".$ord);

$i = 1;
foreach($r as $d){
$c++;
?>
    <tr bgcolor="<?php echo $ut->ncolor($c);?>">
<?php foreach($fields as $f){ ?>
        <td>
        	<?php echo $d[$f]; ?>
        </td>
<?php } ?>
		<td>
                    <a href="javascript: eliminaFila('<?php echo $sec; ?>','<?php echo $sitio; ?>','<?php echo $d['id'];?>')">Eliminar</a>
                </td>
    </tr>
<?php
}
}
?>
</table>