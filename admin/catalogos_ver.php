<?php
include ("../includes/funciones.php");
$ut = new Utils();
$secc = new SeccionClass();

$sec 	= fRequest::get('seccion');
$sitio 	= fRequest::get('sitio');
$pagina	= fRequest::get('p');

$seccion 	= $secc->NombreSeccion($sec,'Nombre');
$cols		= $mysql_db->query("SELECT * FROM columna WHERE seccion = ".$sec." and display_listado = 1 ORDER BY orden");
?>
<script>
	function deleteverify(p,seccion,sitio,id)
	{
		var conf = confirm('Esta seguro de querer eliminar este registro?');
		if(conf)
		{
			window.location = 'index.php?p='+p+'&seccion='+seccion+'&sitio='+sitio+'&id='+id+'';
		}	
	}
</script>
<form action="index.php" method="GET">
<strong>Buscar:</strong> <input type="text" name="search" id="search" value="" size="50" /> <input type="submit" name="buscar" value="Buscar" />
<input type="hidden" name="p" value="<?php echo $pagina; ?>" />
<input type="hidden" name="seccion" value="<?php echo $sec; ?>"  />
<input type="hidden" name="sitio" value="<?php echo $sitio; ?>" />
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#FF6600" style="color:#FFF; font-weight:bold;">
	<td>No.</td>
<?php 
$c = 0;
$fields = array();
foreach($cols as $d){
?>  
    <td>
		<?php
        $fields[] = $d['nombre'];
        echo $d['nombre_largo'];
        ?>
        <a href="index.php?p=<?php echo $pagina; ?>&seccion=<?php echo $sec; ?>&sitio=<?php echo $sitio; ?>&ord=ORDER by <?php echo $d['nombre']; ?> ASC"><img src="../images/sort_down.png" border="0" /></a>
        <a href="index.php?p=<?php echo $pagina; ?>&seccion=<?php echo $sec; ?>&sitio=<?php echo $sitio; ?>&ord=ORDER by <?php echo $d['nombre']; ?> DESC"><img src="../images/sort_up.png" border="0" /></a>
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
    	<td><?php echo $i++;?></td>
<?php foreach($fields as $f){ ?>
        <td>
        	<?php echo $d[$f]; ?>
        </td>
<?php } ?>
		<td>
			<a href="index.php?p=86&seccion=<?php echo $sec; ?>&sitio=<?php echo $sitio; ?>&id=<?php echo $d['id'];?>"><img src="images/pencil.png" border="0" /></a>
			<a href="javascript: void(0);" onclick="deleteverify('86','<?php echo $sec; ?>','<?php echo $sitio; ?>','<?php echo $d['id'];?>');"><img src="images/delete.png" border="0" /></a>
		</td>
    </tr>
<?php
}
?>
</table>