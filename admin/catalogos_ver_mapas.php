<?php
include_once('../init.php');
include_once("../includes/conexion.php");
include_once("../includes/funciones.php");
$ut = new Utils();

?>
<h2 style="margin:0">Catalogos de Secciones</h2>
<table width="778px" border="0" cellspacing="0" cellpadding="3">
  <tr class="table_title">
    <td>Seccion</td>
    <td>Nombre</td>
    <td>Nombre Largo</td>
    <td>Acciones</td>
  </tr>
</table>

<?php 
$sec = new SeccionClass(); 
$seccion = $_GET['seccion'];
?>
    <?php 
	echo $sec->GeneraMapasEditable($_REQUEST);
	?>
