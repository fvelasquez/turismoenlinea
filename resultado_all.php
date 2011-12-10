<?php 
$sec = new SeccionClass(); 
$ut = new Utils();
?>
    <?php $spot->GeneraBanner(14); ?>&nbsp;&nbsp;<br />
    <?php
	$max = 25;
	$page = 0;
	$orden = "nombre";
	if(fRequest::get("page") != ''){ $page = fRequest::get("page"); }
	if(fRequest::get("orden") != ''){ $orden = fRequest::get("orden"); }
	
	
    $res = $sec->generaResultados($_SERVER['QUERY_STRING'],$max,$page,$orden,true);
	$opc = array(
				 "link"=>"index.php?p=71&seccion=&id=",
				 "target"=>"",
				 "order"=>true,
				 "ordercols"=>array(
									"NOMBRE"
									),
				 "even"=>true,
				 "paginate"=>true,
				 "paginate_page"=>$page,
				 "paginate_table"=>'',
				 "paginate_max"=>$max,
				 "filter"=>$_SERVER['QUERY_STRING'],
				 "orderbycombo"=>false,
				 "alltables"=>true
				 );
	echo $ut->GeneraGrid($res,$opc);
	
	?>