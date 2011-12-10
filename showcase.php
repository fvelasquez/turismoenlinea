<?php 
$sec = new SeccionClass(); 
$ut = new Utils();
$seccion = $_GET['seccion'];

$spot->GeneraBanner(14); 
$id 		= fRequest::get('id');
$seccion 	= fRequest::get('seccion');
$secncorto 	= $sec->NombreSeccion($seccion,'Nombre');
$secnlargo	= $sec->NombreSeccion($seccion,'NombreLargo');
$tot 		= 0;
$res 		= $mysql_db->query("SELECT count(*) as tot FROM usr_".$secncorto." ");
foreach($res as $r){
	$tot = $r["tot"];
}
if($tot > 0){
$iData 		= $sec->getInformacionItem($id,$seccion);
?>
<link rel="stylesheet" type="text/css" href="css/svwp_style.css"/>
<script type="text/javascript" language="javascript" src="js/jquery.slideViewerPro.1.0.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.timers-1.2.js"></script>
<div id="search">
	<a href="index.php?p=6&seccion=<?php echo $seccion;?>"><img src="images/busqueda_<?php echo $secncorto;?>.jpg" alt="Has clic aqui para buscar mas <?php echo $secnlargo; ?>" border="0" /></a>
</div>
<div id="galleryDisplayShowcase">
<div id="tituloDisplay">
	<?php 
	if($seccion == 26){
		echo $secnlargo.''; 
	}else{
		echo $secnlargo.''; 
	}
	?>
</div>
<div id="galleryDisplay" class="svwp">
	<ul>
<?php
$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
mysql_select_db(BDD_NAME,$link);

$i = 0;
foreach($iData as $d){
	
	$nombreSeccion = $secncorto;
	$fotos = mysql_query("select * from usr_fotos where id_padre = ".$d['id']." AND seccion = ".$seccion." order by orden LIMIT 0,1");
?>
<?php if(mysql_num_rows($fotos) > 0){?>
    	<?php while($g = mysql_fetch_assoc($fotos)){ ?>
        <?php
		$i++;
		$desc = "";
		//$desc .= '<strong>'.$sec->NombreSeccion($seccion,'NombreLargo').': '.$d['nombre'].'</strong><br />';
		if(isset($d['direccion']) && $d['direccion'] != ''){
			$desc .= 'Direcci&oacute;n: ';
			$desc .= trim($d['direccion']);
			if(isset($d['zona']) && $d['zona'] != ''){ 
				$desc .= ', Zona'.$d['zona']; 
			}
			if(isset($d['departamento']) && $d['departamento'] != ''){ 
				$desc .= ', '.$d['departamento'];
			}
		}
//		$desc .= "<br />";
//		$desc .= '<strong>Pais:</strong> '.trim($d['pais']);
		$desc .= "<br />";
		if(isset($d['telefono1']) || isset($d['telefono2']) || isset($d['telefono3'])){
			$desc .= 'Tel&eacute;fonos: ';
			if(isset($d['telefono1']) && $d['telefono1'] != ''){
				$desc .= trim($d['telefono1']);
			}
			if(isset($d['telefono2']) && $d['telefono2'] != ''){
				$desc .= ' / '.$d['telefono2'];
			}
			if(isset($d['telefono3']) && $d['telefono3'] != ''){
				$desc .= ' / '.$d['telefono3'];
			}
		}
		?>
    	<li>
        <div class="title_image"><?php echo $d['nombre']; ?></div>
        <img src="admin/<?php echo $g['url']; ?>" alt="" width="500" height="375" />
        <div class="detail_image"><?php echo $desc; ?></div>
        </li>
        <?php } ?>
<script>
	$(window).bind("load",function(){
		$("div#galleryDisplay").slideViewerPro({
			thumbs:4,
			autoslide:true,
			asTimer: 10000,
			typo:false,
			galBorderWidth: 0,
			thumbsBorderOpacity: 0,
			buttonsTextColor: "#707070",
			buttonsWidth: 40,
			thumbsActiveBorderOpacity: 0.2,
			shuffle: false,
			Theight:450
		});
	});
</script>
<?php } ?>
<?php } 
if($i == 0){
?>
            <li>
                <div class="title_image">Publicidad</div>
                <img src="publicidad/publicidad_1.jpg" alt="" width="500" height="375" />
                <div class="detail_image">Visitanos www.saludenlinea.org</div>
            </li>
<script>
	$(window).bind("load",function(){
		$("div#galleryDisplay").slideViewerPro({
			thumbs:4,
			autoslide:true,
			asTimer: 10000,
			typo:false,
			galBorderWidth: 0,
			thumbsBorderOpacity: 0,
			buttonsTextColor: "#707070",
			buttonsWidth: 40,
			thumbsActiveBorderOpacity: 0.2,
			shuffle: false,
			Theight:450
		});
	});
</script>
<?php } ?>
    </ul>
</div>
<div style="clear:both">&nbsp;</div>
</div>
<?php }else{ ?>
	<div class="alerta">En este momento no tenemos datos de <?php echo $secnlargo; ?></div><br />
	<h3 style="text-align:center">
    Si tienes <?php echo $secnlargo; ?> y quisieras aparecer en este sitio, &iexcl;Contactanos!<br />
    <a href="index.php?p=5"><img src="images/contactenos.png" border="0" /></a>
    </h3>
<?php }?>