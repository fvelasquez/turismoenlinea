<?php 
$sec = new SeccionClass(); 
$ut = new Utils();
if(isset($_SESSION['Seccion']) && $_SESSION['Seccion'] != ''){ $seccion = $_SESSION['Seccion']; }else{ $seccion = '19'; }
if(isset($_GET['seccion']) && $_GET['seccion'] != ''){ $seccion = $_GET['seccion']; }else{ $seccion = '19'; }
?>
    <?php $spot->GeneraBanner(14); ?>&nbsp;&nbsp;<br />
    <?php
	$max = 25;
	$page = 0;
	$orden = "nombre";
	if(fRequest::get("page") != ''){ $page = fRequest::get("page"); }
	if(fRequest::get("orden") != ''){ $orden = fRequest::get("orden"); }
	
	
    $res = $sec->generaResultados($_SERVER['QUERY_STRING'],$max,$page,$orden,false);
	$opc = array(
				 "link"=>"index.php?p=8&seccion=".$seccion."&id=",
				 "target"=>"",
				 "order"=>true,
				 "ordercols"=>array(
									"TIPO",
									"NOMBRE",
									"ZONA"
									),
				 "even"=>true,
				 "paginate"=>true,
				 "paginate_table"=>"usr_".$sec->NombreSeccion($seccion,'Nombre'),
				 "paginate_page"=>$page,
				 "paginate_max"=>$max,
				 "filter"=>$_SERVER['QUERY_STRING'],
				 "orderbycombo"=>false,
				 "alltables"=>false
				 );
	echo $ut->GeneraGrid($res,$opc);
	
	?>