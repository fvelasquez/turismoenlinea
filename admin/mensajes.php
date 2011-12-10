<?php
$m =(isset($_GET['msg']) && $_GET['msg'] != '')?$_GET['msg']:"";
if($m != ""){
	echo '<h3>';
	echo $m;
	echo '</h3>';
}
?>
<a href="index.php?p=81&seccion=<?php echo $_GET['seccion'];?>&sitio=<?php echo $_GET['sitio'];?>">Ingresar Otro Registro</a>