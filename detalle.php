<?php 
$sec = new SeccionClass(); 
$ut = new Utils();
$seccion = $_GET['seccion'];

$spot->GeneraBanner(14); 
$id 		= fRequest::get('id');
$seccion 	= fRequest::get('seccion');

$iData 		= $sec->getInformacionItem($id,$seccion);
?>&nbsp;&nbsp;<br />
<link rel="stylesheet" type="text/css" href="css/svwp_style.css"/>
<script type="text/javascript" language="javascript" src="js/jquery.slideViewerPro.1.0.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.timers-1.2.js"></script>
<?php
foreach($iData as $d){
	
	$gal = $sec->getGallery($id,$seccion);
?>
<div id="tituloDisplay">
	<?php 
	if($seccion == 26){
		echo $sec->NombreSeccion($seccion,'NombreLargo').': '.$d['departamento']. ' - '.$d['nombre']; 
	}else{
		echo $sec->NombreSeccion($seccion,'NombreLargo').': '.$d['nombre']; 
	}
	?>
</div>
<?php if(mysql_num_rows($gal) > 0){?>
<div id="galleryDisplay" class="svwp">
	<ul>
    	<?php while($g = mysql_fetch_assoc($gal)){ ?>
    	<li><img src="admin/<?php echo $g['url']; ?>" alt="<?php echo utf8_encode($g['descripcion']); ?>" width="500" height="375" /></li>
        <?php } ?>
    </ul>
</div>
<script>
	$(window).bind("load",function(){
		$("div#galleryDisplay").slideViewerPro({
			thumbs:6,
			autoslide:true,
			asTimer: 10000,
			typo:true,
			galBorderWidth: 0,
			thumbsBorderOpacity: 0,
			buttonsTextColor: "#707070",
			buttonsWidth: 40,
			thumbsActiveBorderOpacity: 0.8,
			Theight:375
		});
	});
</script>
<?php } ?>
<div id="infoDisplay">
<h2>Informaci&oacute;n General</h2>
	<table border="0" cellpadding="3" cellspacing="0">
    	<?php 
		if(isset($d['direccion']) && $d['direccion'] != ''){
			echo '<tr><td><strong>Direcci&oacute;n:</strong></td><td>';
			echo trim($d['direccion']);
			if(isset($d['zona']) && $d['zona'] != ''){ 
				echo ', Zona '.$d['zona']; 
			}
			echo '</td></tr>';
		}
		?>
        <tr><td valign="top" width="220"><strong>Pais:</strong></td><td><?php echo utf8_encode(trim($d['pais'])); ?></td></tr>
        <?php if(isset($d['departamento']) && $d['departamento'] != ''){  ?>
        <tr><td valign="top"><strong>Departamento:</strong></td><td><?php echo utf8_encode(trim($d['departamento'])); ?></td></tr>
		<?php } ?>
        <?php if(isset($d['municipio']) && $d['municipio'] != ''){  ?>
        <tr><td valign="top"><strong>Municipio:</strong></td><td><?php echo utf8_encode(trim($d['municipio'])); ?></td></tr>
		<?php } ?>
        <?php if(isset($d['telefono1']) || isset($d['telefono2']) || isset($d['telefono3'])){ ?>
        <tr><td valign="top"><strong>Tel&eacute;fonos:</strong></td><td>
        <?php
        if(isset($d['telefono1']) && $d['telefono1'] != ''){
	        echo $d['telefono1'];
        }
		if(isset($d['telefono2']) && $d['telefono2'] != ''){
			echo ' / '.$d['telefono2'];
		}
		if(isset($d['telefono3']) && $d['telefono3'] != ''){
			echo ' / '.$d['telefono3'];
		}
		?>
		</td></tr>
        <?php }  
		if (isset($d['fax']) && $d['fax'] != ''){
		?>        
        <tr><td valign="top"><strong>Fax:</strong></td><td><?php echo $d['fax']; ?></td></tr>
        <?php  
		}
		if (isset($d['email']) && $d['email'] != ''){
		?>        
        <tr><td valign="top"><strong>Correo Electr&oacute;nico:</strong></td><td><?php echo '<a href="mailto:'.$d['email'].'">'.$d['email'].'</a>'; ?></td></tr>
        <?php  
		}
		if (isset($d['estrellas']) && $d['estrellas'] != '0'){
		?>        
        <tr><td valign="top"><strong>Estrellas:</strong></td><td><?php echo $d['estrellas']; ?></td></tr>
        <?php 
		}
		if (isset($d['web']) && $d['web'] != ''){
		?>
        <tr><td valign="top"><strong>Sitio Web:</strong></td><td><?php echo '<a href="http://'.$d['web'].'">'.$d['web'].'</a>'; ?></td></tr>
        <?php } 
		if (isset($d['horaapertura']) && $d['horaapertura'] != '00:00:00' && isset($d['horacierre']) && $d['horacierre'] != '00:00:00'){
		?>
        <tr><td valign="top"><strong>Horario Atenci&oacute;n:</strong></td><td><?php echo $d['horaapertura']; ?> - <?php echo $d['horacierre']; ?></td></tr>
        <?php }
		if (isset($d['tipo']) && $d['tipo'] != ''){
		?>
        <tr><td valign="top"><strong>Tipo de Sitio:</strong></td><td><?php echo $d['tipo']; ?></td></tr>
		<?php }
		if(isset($d['tipocine']) || isset($d['tipoboliche']) || isset($d['tipomuseo']) || isset($d['tipogaleriaarte']) || isset($d['tipopatinaje']) || isset($d['tipogokart']) || isset($d['tipodiscotecas'])){ ?>
        <tr><td valign="top"><strong>Tipo :</strong></td><td>
        <?php
			if(isset($d['tipocine']) && $d['tipocine'] != ''){ echo 'Cine'; }
			if(isset($d['tipoboliche']) && $d['tipoboliche'] != ''){ echo 'Boliche'; }
			if(isset($d['tipomuseo']) && $d['tipomuseo'] != ''){ echo 'Museo'; }
			if(isset($d['tipogaleriaarte']) && $d['tipogaleriaarte'] != ''){ echo 'Galeria de Arte'; }
			if(isset($d['tipopatinaje']) && $d['tipopatinaje'] != ''){ echo 'Pista de Patinaje'; }
			if(isset($d['tipogokart']) && $d['tipogokart'] != ''){ echo 'Go Karts'; }
			if(isset($d['tipodiscotecas']) && $d['tipodiscotecas'] != ''){ echo 'Discotecas'; }
		?>
		</td></tr>
        <?php }
        
        if(isset($d['tipoturicentro']) || isset($d['tipozoologico']) || isset($d['tipogotcha']) || isset($d['tipoareadeportiva']) || isset($d['tipoparque'])){ ?>
        <tr><td valign="top"><strong>Tipo :</strong></td><td>
        <?php
			if(isset($d['tipoturicentro']) && $d['tipoturicentro'] != ''){ echo 'Turicentro'; }
			if(isset($d['tipozoologico']) && $d['tipozoologico'] != ''){ echo 'Zoologico'; }
			if(isset($d['tipogotcha']) && $d['tipogotcha'] != ''){ echo 'Gotcha'; }
			if(isset($d['tipoareadeportiva']) && $d['tipoareadeportiva'] != ''){ echo 'Area Deportiva'; }
			if(isset($d['tipoparque']) && $d['tipoparque'] != ''){ echo 'Parque'; }
		?>
		</td></tr>
        <?php }
        
        if(isset($d['tipolineaaerea']) || isset($d['tipobus']) || isset($d['tipotaxi']) || isset($d['tipovehiculo']) || isset($d['tipomototaxi']) || isset($d['tipolancha'])){ ?>
        <tr><td valign="top"><strong>Tipo :</strong></td><td>
        <?php
			if(isset($d['tipolineaaerea']) && $d['tipolineaaerea'] != ''){ echo 'Linea Aerea'; }
			if(isset($d['tipobus']) && $d['tipobus'] != ''){ echo 'Bus'; }
			if(isset($d['tipotaxi']) && $d['tipotaxi'] != ''){ echo 'Taxi'; }
			if(isset($d['tipovehiculo']) && $d['tipovehiculo'] != ''){ echo 'Vehiculo'; }
			if(isset($d['tipomototaxi']) && $d['tipomototaxi'] != ''){ echo 'Moto-Taxi'; }
			if(isset($d['tipolancha']) && $d['tipolancha'] != ''){ echo 'Lancha'; }
		?>
		</td></tr>
        <?php }
        
        if(isset($d['tipovolcan']) || isset($d['tipolago']) || isset($d['tipomar']) || isset($d['tiporio']) || isset($d['tipogruta']) || isset($d['tipocascadas']) || isset($d['tipoarqueologico']) || isset($d['tipobosque']) || isset($d['tiporeservanatural']) || isset($d['tipociudad']) || isset($d['tipoiglesias']) || isset($d['tipohistorico'])){ ?>
        <tr><td valign="top"><strong>Tipo :</strong></td><td>
        <?php
			if(isset($d['tipovolcan']) && $d['tipovolcan'] != ''){ echo 'Volcan'; }
			if(isset($d['tipolago']) && $d['tipolago'] != ''){ echo 'Lago'; }
			if(isset($d['tipomar']) && $d['tipomar'] != ''){ echo 'Mar'; }
			if(isset($d['tiporio']) && $d['tiporio'] != ''){ echo 'Rio'; }
			if(isset($d['tipogruta']) && $d['tipogruta'] != ''){ echo 'Gruta'; }
			if(isset($d['tipocascadas']) && $d['tipocascadas'] != ''){ echo 'Cascada'; }
			if(isset($d['tipoarqueologico']) && $d['tipoarqueologico'] != ''){ echo 'Arqueologico'; }
			if(isset($d['tipobosque']) && $d['tipobosque'] != ''){ echo 'Bosque'; }
			if(isset($d['tiporeservanatural']) && $d['tiporeservanatural'] != ''){ echo 'Reserva Natural'; }
			if(isset($d['tipociudad']) && $d['tipociudad'] != ''){ echo 'Ciudad'; }
			if(isset($d['tipoiglesias']) && $d['tipoiglesias'] != ''){ echo 'Iglesias'; }
			if(isset($d['tipohistorico']) && $d['tipohistorico'] != ''){ echo 'Historico'; }
		?>
		</td></tr>
        <?php }
        
        
        if(isset($d['tipointernacional']) || isset($d['tipoarabe']) || isset($d['tipoitaliana']) || isset($d['tipochina']) || isset($d['tipothai']) || isset($d['tipotipica']) || isset($d['tipomexicana']) || isset($d['tipoperuana']) || isset($d['tipofrancesa']) || isset($d['tipoamericana']) || isset($d['tiposuiza']) || isset($d['tipofusion']) || isset($d['tipoaltacocina']) || isset($d['tipopasteleria']) || isset($d['tipocafeteria']) || isset($d['tipoheladeria']) || isset($d['tipocomidarapida']) || isset($d['tipojaponesa']) || isset($d['tipoespanola']) || isset($d['tipomariscos']) || isset($d['tipohindu'])){ ?>
        <tr><td valign="top"><strong>Tipo :</strong></td><td>
        <?php
			if(isset($d['tipointernacional']) && $d['tipointernacional'] != ''){ echo 'Internacional'; }
			if(isset($d['tipoarabe']) && $d['tipoarabe'] != ''){ echo 'Arabe'; }
			if(isset($d['tipoitaliana']) && $d['tipoitaliana'] != ''){ echo 'Italiana'; }
			if(isset($d['tipochina']) && $d['tipochina'] != ''){ echo 'China'; }
			if(isset($d['tipothai']) && $d['tipothai'] != ''){ echo 'Thai'; }
			if(isset($d['tipotipica']) && $d['tipotipica'] != ''){ echo 'Tipica'; }
			if(isset($d['tipomexicana']) && $d['tipomexicana'] != ''){ echo 'Mexicana'; }
			if(isset($d['tipoperuana']) && $d['tipoperuana'] != ''){ echo 'Peruana'; }
			if(isset($d['tipofrancesa']) && $d['tipofrancesa'] != ''){ echo 'Francesa'; }
			if(isset($d['tipoamericana']) && $d['tipoamericana'] != ''){ echo 'Americana'; }
			if(isset($d['tiposuiza']) && $d['tiposuiza'] != ''){ echo 'Suiza'; }
			if(isset($d['tipofusion']) && $d['tipofusion'] != ''){ echo 'Fusion'; }
			if(isset($d['tipoaltacocina']) && $d['tipoaltacocina'] != ''){ echo 'Alta Cocina'; }
			if(isset($d['tipopasteleria']) && $d['tipopasteleria'] != ''){ echo 'Pasteleria'; }
			if(isset($d['tipocafeteria']) && $d['tipocafeteria'] != ''){ echo 'Cafeteria'; }
			if(isset($d['tipoheladeria']) && $d['tipoheladeria'] != ''){ echo 'Heladeria'; }
			if(isset($d['tipocomidarapida']) && $d['tipocomidarapida'] != ''){ echo 'Comida Rapida'; }
			if(isset($d['tipojaponesa']) && $d['tipojaponesa'] != ''){ echo 'Japonesa'; }
			if(isset($d['tipoespanola']) && $d['tipoespanola'] != ''){ echo 'Espa&ntilde;ola'; }
			if(isset($d['tipomariscos']) && $d['tipomariscos'] != ''){ echo 'Mariscos'; }
			if(isset($d['tipohindu']) && $d['tipohindu'] != ''){ echo 'Hindu'; }
		?>
		</td></tr>
        <?php }
        
        
        if(isset($d['idiomaingles']) || isset($d['idiomafrances']) || isset($d['idiomaportugues']) || isset($d['idiomaitaliano']) || isset($d['idiomajapones']) || isset($d['idiomamandarin']) || isset($d['idiomakoreano']) || isset($d['idiomaespanol']) || isset($d['idiomaaleman']) || isset($d['lenguakiche']) || isset($d['lenguaqueqchi']) || isset($d['lenguakaqchiquel']) || isset($d['lenguamam']) || isset($d['lenguagarifuna'])){ ?>
        <tr><td valign="top"><strong>Lengua :</strong></td><td>
        <?php
			if(isset($d['idiomaingles']) && $d['idiomaingles'] != ''){ echo 'Ingles'; }
			if(isset($d['idiomafrances']) && $d['idiomafrances'] != ''){ echo 'Frances'; }
			if(isset($d['idiomaportugues']) && $d['idiomaportugues'] != ''){ echo 'Portugues'; }
			if(isset($d['idiomaitaliano']) && $d['idiomaitaliano'] != ''){ echo 'Italiano'; }
			if(isset($d['idiomajapones']) && $d['idiomajapones'] != ''){ echo 'Japones'; }
			if(isset($d['idiomamandarin']) && $d['idiomamandarin'] != ''){ echo 'Mandarin'; }
			if(isset($d['idiomakoreano']) && $d['idiomakoreano'] != ''){ echo 'Koreano'; }
			if(isset($d['idiomaespanol']) && $d['idiomaespanol'] != ''){ echo 'Espa&ntilde;ol'; }
			if(isset($d['idiomaaleman']) && $d['idiomaaleman'] != ''){ echo 'Aleman'; }
			if(isset($d['lenguakiche']) && $d['lenguakiche'] != ''){ echo 'Kiche'; }
			if(isset($d['lenguaqueqchi']) && $d['lenguaqueqchi'] != ''){ echo 'Queqchi'; }
			if(isset($d['lenguakaqchiquel']) && $d['lenguakaqchiquel'] != ''){ echo 'Kaqchiquel'; }
			if(isset($d['lenguamam']) && $d['lenguamam'] != ''){ echo 'Mam'; }
			if(isset($d['lenguagarifuna']) && $d['lenguagarifuna'] != ''){ echo 'Garifuna'; }
		?>
		</td></tr>
        <?php }
        
        
		if (isset($d['lugaresturisticos']) && $d['lugaresturisticos'] > '0'){
		?>
        <tr><td valign="top"><strong>Lugares Turisticos:</strong></td><td><?php echo $d['lugaresturisticos']; ?></td></tr>
		<?php } //
		if (isset($d['servicios']) && $d['servicios'] > '0'){
		?>
        <tr><td valign="top"><strong>Servicios que Presta:</strong></td><td><?php echo $d['servicios']; ?></td></tr>
		<?php } 
		// Para entretenimiento
		if (isset($d['costoingreso']) && $d['costoingreso'] > '0'){
		?>
        <tr><td valign="top"><strong>Costo Entrada:</strong></td><td>Q.<?php echo $d['costoingreso']; ?></td></tr>
		<?php } //
		// Para Sitios de interes
		if (isset($d['costoturista']) && $d['costoturista'] > '0'){
		?>
        <tr><td valign="top"><strong>Costo Entrada (Int):</strong></td><td>$.<?php echo $d['costoturista']; ?></td></tr>
		<?php } 
		if (isset($d['costonacional']) && $d['costonacional'] > '0'){
		?>
        <tr><td valign="top"><strong>Costo Entrada (Nac):</strong></td><td>Q.<?php echo $d['costonacional']; ?></td></tr>
		<?php }
		if ((isset($d['accesoliviano']) && $d['accesoliviano'] == 'S') || (isset($d['accesosuv']) && $d['accesosuv'] == 'S') || (isset($d['acceso4x4']) && $d['acceso4x4'] == 'S') || (isset($d['accesocaballo']) && $d['accesocaballo'] == 'S') || (isset($d['accesomoto']) && $d['accesomoto'] == 'S') || (isset($d['accesocaminar']) && $d['accesocaminar'] == 'S')){
		?>
        <tr>
        	<td valign="top"><strong>Formas de acceso:</strong></td>
	        <td>
            	<?php if (isset($d['calledeaccesoterraceria']) && $d['calledeaccesoterraceria'] == 'S'){ echo "Por Terraceria<br />"; } ?>
            	<?php if (isset($d['accesoliviano']) && $d['accesoliviano'] == 'S'){ echo "En Veh&iacute;culo Liviano<br />"; } ?>
            	<?php if (isset($d['accesovehiculoliviano']) && $d['accesovehiculoliviano'] == 'S'){ echo "En Veh&iacute;culo Liviano<br />"; } ?>
                <?php if (isset($d['accesovehiculosuv']) && $d['accesovehiculosuv'] == 'S'){ echo "En Veh&iacute;culo SUV<br />"; } ?>
                <?php if (isset($d['accesovehiculo4x4']) && $d['accesovehiculo4x4'] == 'S'){ echo "En Veh&iacute;culo 4x4<br />"; } ?>
                <?php if (isset($d['accesoenmoto']) && $d['accesoenmoto'] == 'S'){ echo "En Motocicleta<br />"; } ?>
                <?php if (isset($d['accesoacaballo']) && $d['accesoacaballo'] == 'S'){ echo "A Caballo<br />"; } ?>
                <?php if (isset($d['accesoapie']) && $d['accesoapie'] == 'S'){ echo "A Pie<br />"; } ?>
     	   	</td>
		</tr>
   		<?php } //
		if (isset($d['numeroinguat']) && $d['numeroinguat'] != ''){
		?>
        <tr><td valign="top"><strong>Numero Inguat:</strong></td><td><?php echo $d['numeroinguat']; ?> &acirc;</td></tr>
   		<?php }
   		if (isset($d['fechanacimiento']) && $d['fechanacimiento'] != ''){
		?>
        <tr><td valign="top"><strong>Fecha de Nacimiento:</strong></td><td><?php echo $d['fechanacimiento']; ?> &acirc;</td></tr>
   		<?php }
   		
		if (isset($d['edadchequeo']) && $d['edadchequeo'] != '0'){
		?>
        <tr><td valign="top"><strong>Edad M&iacute;nima de Chequeo:</strong></td><td><?php echo $d['edadchequeo']; ?> &acirc;</td></tr>
   		<?php } //
		if (isset($d['nohabitaciones']) && $d['nohabitaciones'] != '0'){
		?>
        <tr><td valign="top"><strong>N&uacute;mero de habitaciones:</strong></td><td><?php echo $d['nohabitaciones']; ?></td></tr>
   		<?php } //
   		if (isset($d['horarioentrada']) && $d['horarioentrada'] != '0'){
		?>
        <tr><td valign="top"><strong>Hora de entrada:</strong></td><td><?php echo $d['horarioentrada']; ?></td></tr>
   		<?php } //
		if (isset($d['horaentrada']) && $d['horaentrada'] != '00:00:00'){
		?>
        <tr><td valign="top"><strong>Hora de entrada:</strong></td><td><?php echo $d['horaentrada']; ?></td></tr>
        <?php } //
		if (isset($d['horasalida']) && $d['horasalida'] != '00:00:00'){
		?>
        <tr><td valign="top"><strong>Hora de salida:</strong></td><td><?php echo $d['horasalida']; ?></td></tr>
        <?php }
        
        // ************************************************************************************************
        // HORARIOS DE ATENCION
        // ************************************************************************************************
        if (isset($d['horarioatencionde']) && $d['horarioatencionde'] != '00:00:00'){
		?>
        <tr><td valign="top"><strong>Hora de atenci&oacute;n:</strong></td><td><?php echo $d['horarioatencionde']; ?> - <?php echo $d['horarioatenciona']; ?></td></tr>
        <?php }
        
        if (isset($d['atientelunes']) && $d['atientelunes'] == 'S'){
		?>
        <tr><td valign="top"><strong>Atiende Lunes:</strong></td><td>Si 
        <?php 
        if ((isset($d['horalunesde']) && $d['horalunesde'] != '00:00:00') && (isset($d['horalunesa']) && $d['horalunesa'] != '00:00:00'))
        	{ ?>
        		[<?php echo $d['horalunesde'] . ' - ' . $d['horalunesa']; ?>]
        <?php } ?>		
        </td></tr>
        <?php }
        
        if (isset($d['atientemartes']) && $d['atientemartes'] == 'S'){
		?>
        <tr><td valign="top"><strong>Atiende Martes:</strong></td><td>Si 
        <?php 
        if ((isset($d['horamartesde']) && $d['horamartesde'] != '00:00:00') && (isset($d['horamartesa']) && $d['horamartesa'] != '00:00:00'))
        	{ ?>
        		[<?php echo $d['horamartesde'] . ' - ' . $d['horamartesa']; ?>]
        <?php } ?>		
        </td></tr>
        <?php }
        
        if (isset($d['atientemiercoles']) && $d['atientemiercoles'] == 'S'){
		?>
        <tr><td valign="top"><strong>Atiende Miercoles:</strong></td><td>Si 
        <?php 
        if ((isset($d['horamiercolesde']) && $d['horamiercolesde'] != '00:00:00') && (isset($d['horamiercolesa']) && $d['horamiercolesa'] != '00:00:00'))
        	{ ?>
        		[<?php echo $d['horamiercolesde'] . ' - ' . $d['horamiercolesa']; ?>]
        <?php } ?>		
        </td></tr>
        <?php }
        
        if (isset($d['atientejueves']) && $d['atientejueves'] == 'S'){
		?>
        <tr><td valign="top"><strong>Atiende Jueves:</strong></td><td>Si 
        <?php 
        if ((isset($d['horajuevesde']) && $d['horajuevesde'] != '00:00:00') && (isset($d['horajuevesa']) && $d['horajuevesa'] != '00:00:00'))
        	{ ?>
        		[<?php echo $d['horajuevesde'] . ' - ' . $d['horajuevesa']; ?>]
        <?php } ?>		
        </td></tr>
        <?php }
        
        if (isset($d['atienteviernes']) && $d['atienteviernes'] == 'S'){
		?>
        <tr><td valign="top"><strong>Atiende Viernes:</strong></td><td>Si 
        <?php 
        if ((isset($d['horaviernesde']) && $d['horaviernesde'] != '00:00:00') && (isset($d['horaviernesa']) && $d['horaviernesa'] != '00:00:00'))
        	{ ?>
        		[<?php echo $d['horaviernesde'] . ' - ' . $d['horaviernesa']; ?>]
        <?php } ?>		
        </td></tr>
        <?php }
        
        if (isset($d['atientesabado']) && $d['atientesabado'] == 'S'){
		?>
        <tr><td valign="top"><strong>Atiende Sabado:</strong></td><td>Si 
        <?php 
        if ((isset($d['horasabadode']) && $d['horasabadode'] != '00:00:00') && (isset($d['horasabadoa']) && $d['horasabadoa'] != '00:00:00'))
        	{ ?>
        		[<?php echo $d['horasabadode'] . ' - ' . $d['horasabadoa']; ?>]
        <?php } ?>		
        </td></tr>
        <?php }
        
        if (isset($d['atientedomingo']) && $d['atientedomingo'] == 'S'){
		?>
        <tr><td valign="top"><strong>Atiende Domingo:</strong></td><td>Si 
        <?php 
        if ((isset($d['horadomingode']) && $d['horadomingode'] != '00:00:00') && (isset($d['horadomingoa']) && $d['horadomingoa'] != '00:00:00'))
        	{ ?>
        		[<?php echo $d['horadomingode'] . ' - ' . $d['horadomingoa']; ?>]
        <?php } ?>		
        </td></tr>
        <?php }
        
        
		// Para Hoteles y Casas
		if (isset($d['de']) && $d['de'] > '0'){
		?>
        <tr><td valign="top"><strong>Precios:</strong></td><td><?php echo '$'.round($d['de'],2).' - $'.round($d['a'],2); ?></td></tr>
        <?php }
        if (isset($d['quetzales']) || isset($d['dolares'])){
		?>
        <tr>
        	<td valign="top"><strong>Tarifas en:</strong></td>
        	<td>
        	<?php if (isset($d['quetzales']) && $d['quetzales'] == 'S'){ echo 'Quetzales'; } ?>
        	<?php if (isset($d['dolares']) && $d['dolares'] == 'S'){ echo 'Dolares'; } ?>
        	</td>
        </tr>
		<?php }
		if (isset($d['tarifaadulto']) && $d['tarifaadulto'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Adultos:</strong></td><td><?php echo $d['tarifaadulto']; ?></td></tr>
		<?php }
		if (isset($d['tarifanino']) && $d['tarifanino'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Ni&ntilde;os:</strong></td><td><?php echo $d['tarifanino']; ?></td></tr>
		<?php }
		if (isset($d['tarifaextranjero']) && $d['tarifaextranjero'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Extranjero:</strong></td><td><?php echo $d['tarifaextranjero']; ?></td></tr>
		<?php }
		
		if (isset($d['tarifapromedio']) && $d['tarifapromedio'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Promedio:</strong></td><td><?php echo $d['tarifapromedio']; ?></td></tr>
		<?php }
		if (isset($d['tarifapromediosimple']) && $d['tarifapromediosimple'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Promedio:</strong></td><td><?php echo $d['tarifapromediosimple']; ?></td></tr>
		<?php }
		if (isset($d['tarifapromediodoble']) && $d['tarifapromediodoble'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Promedio Cuarto Doble:</strong></td><td><?php echo $d['tarifapromediodoble']; ?></td></tr>
		<?php }
		if (isset($d['tarifapromediotriple']) && $d['tarifapromediotriple'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Promedio Cuarto Triple:</strong></td><td><?php echo $d['tarifapromediotriple']; ?></td></tr>
		<?php }
		if (isset($d['tarifapromediocuadruple']) && $d['tarifapromediocuadruple'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Promedio Cuarto Cuadruple:</strong></td><td><?php echo $d['tarifapromediocuadruple']; ?></td></tr>
		<?php }
		if (isset($d['tarifapromediosuite']) && $d['tarifapromediosuite'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Promedio Cuarto Suite:</strong></td><td><?php echo $d['tarifapromediosuite']; ?></td></tr>
		<?php }
		if (isset($d['tarifapromediobungalow']) && $d['tarifapromediobungalow'] > '0'){
		?>
        <tr><td valign="top"><strong>Tarifa Promedio Cuarto Bungalow:</strong></td><td><?php echo $d['tarifapromediobungalow']; ?></td></tr>
		<?php }

        
		if (isset($d['incluyeimpuesto']) && $d['incluyeimpuesto'] == 'S'){
		?>
        <tr>
        <td>&nbsp;</td>
        <td valign="top">
        <strong>Incluye Impuestos</strong>
        </td></tr>
        <?php }
		if (isset($d['incluyedesayuno']) && $d['incluyedesayuno'] == 'S'){
		?>
        <tr>
        <td>&nbsp;</td>
        <td valign="top">
        <strong>Incluye Desayuno</strong>
        </td></tr>
        <?php }        
		if(isset($d['descripcion']) && $d['descripcion'] != ''){  ?>
        <tr><td valign="top"><strong>Descripci&oacute;n:</strong></td><td><?php echo trim($d['descripcion']); ?></td></tr>
		<?php }
		if(isset($d['contacto']) && $d['contacto'] != ''){  ?>
        <tr><td valign="top"><strong>Contacto:</strong></td><td><?php echo trim($d['contacto']); ?></td></tr>
		<?php } ?>
    </table>
</div>
<?php
$colC = 0;
$colCC = 0;
$colN = 1;
$fac = '<ul id="'.$colN.'">';
if (isset($d['parqueo']) && $d['parqueo'] == 'S'){ $fac .= "<li>Parqueo</li>"; $colC++; $colCC++; }
// Para Hoteles ******************************************************************
if (isset($d['serviciocuarto']) && $d['serviciocuarto'] == 'S'){ $fac .= "<li>Servicio a la Habitaci&oacute;n</li>"; $colC++;}
// Para Casas ********************************************************************
if (isset($d['serviciodomestico']) && $d['serviciodomestico'] == 'S'){ $fac .= "<li>Servicio Domestico</li>"; $colC++;}
// *******************************************************************************

if (isset($d['serviciolavanderia']) && $d['serviciolavanderia'] == 'S'){ $fac .= "<li>Servicio de Lavanderia</li>"; $colC++;}

if (isset($d['centronegocios']) && $d['centronegocios'] == 'S'){ $fac .= "<li>Centro de Negocios</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['personalseguridad']) && $d['personalseguridad'] == 'S'){ $fac .= "<li>Personal de Seguridad</li>"; $colC++; $colCC++; }
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['servicioguia']) && $d['servicioguia'] == 'S'){ $fac .= "<li>Servicio de Guia</li>"; $colC++; $colCC++; }
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['tiendasderecuerdos']) && $d['tiendasderecuerdos'] == 'S'){ $fac .= "<li>Tiendas de Recuerdos</li>"; $colC++; $colCC++; }
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['telefonopublico']) && $d['telefonopublico'] == 'S'){ $fac .= "<li>Telefono Publico</li>"; $colC++; $colCC++; }
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['energiaelectricanormal']) && $d['energiaelectricanormal'] == 'S'){ $fac .= "<li>Energia El&eacute;ctrica</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['electricidadnormal']) && $d['electricidadnormal'] == 'S'){ $fac .= "<li>Energia El&eacute;ctrica</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['electricidadplanta']) && $d['electricidadplanta'] == 'S'){ $fac .= "<li>Energia El&eacute;ctrica (Planta)</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['tvhabitacion']) && $d['tvhabitacion'] == 'S'){ $fac .= "<li>Televisi&oacute;n</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['television']) && $d['television'] == 'S'){ $fac .= "<li>Televisi&oacute;n</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['cable']) && $d['cable'] == 'S'){ $fac .= "<li>T.V. Cable</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['directtvsky']) && $d['directtvsky'] == 'S'){ $fac .= "<li>TV Satelital (Direct TV / Sky)</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['tvsatellite']) && $d['tvsatellite'] == 'S'){ $fac .= "<li>TV Satelital</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['internet']) && $d['internet'] == 'S'){ $fac .= "<li>Acceso a Internet</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['internetinalambrico']) && $d['internetinalambrico'] == 'S'){ $fac .= "<li>Acceso a Internet Inal&aacute;mbrico</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }


if (isset($d['cocinahabilitada']) && $d['cocinahabilitada'] == 'S'){ $fac .= "<li>Cocina Habilitada</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['microondas']) && $d['microondas'] == 'S'){ $fac .= "<li>Microondas</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['lavadora']) && $d['lavadora'] == 'S'){ $fac .= "<li>Lavadora</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['secadora']) && $d['secadora'] == 'S'){ $fac .= "<li>Secadora</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['refrigeradora']) && $d['refrigeradora'] == 'S'){ $fac .= "<li>Refrigeradora</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['estufa']) && $d['estufa'] == 'S'){ $fac .= "<li>Estufa</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['aireacondicionado']) && $d['aireacondicionado'] == 'S'){ $fac .= "<li>Aire Acondicionado</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['ventiladores']) && $d['ventiladores'] == 'S'){ $fac .= "<li>Ventiladores</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['cuentaropacama']) && $d['cuentaropacama'] == 'S'){ $fac .= "<li>Ropa de Cama (Incluida)</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['llevarropacama']) && $d['llevarropacama'] == 'S'){ $fac .= "<li>Ropa de Cama (No Incluida)</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['butacasreclinables']) && $d['butacasreclinables'] == 'S'){ $fac .= "<li>Butacas Reclinables</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['toallas']) && $d['toallas'] == 'S'){ $fac .= "<li>Toallas</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['bateriadecocina']) && $d['bateriadecocina'] == 'S'){ $fac .= "<li>Bateria de Cocina</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['churrasquera']) && $d['churrasquera'] == 'S'){ $fac .= "<li>Churrasquera</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['permitidoingresocomida']) && $d['permitidoingresocomida'] == 'S'){ $fac .= "<li>Permitido el Ingreso de Alimentos</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['vajillaycubiertos']) && $d['vajillaycubiertos'] == 'S'){ $fac .= "<li>Vajilla y Cubiertos</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }


if (isset($d['playa']) && $d['playa'] == 'S'){ $fac .= "<li>Acceso a la Playa</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['piscina']) && $d['piscina'] == 'S'){ $fac .= "<li>Piscina</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['jacuzzi']) && $d['jacuzzi'] == 'S'){ $fac .= "<li>Jacuzzi</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['bar']) && $d['bar'] == 'S'){ $fac .= "<li>Bar</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['spa']) && $d['spa'] == 'S'){ $fac .= "<li>Spa</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['gimnasio']) && $d['gimnasio'] == 'S'){ $fac .= "<li>Gimnasio</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['canchasdeportivas']) && $d['canchasdeportivas'] == 'S'){ $fac .= "<li>Canchas Deportivas</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['sauna']) && $d['sauna'] == 'S'){ $fac .= "<li>Sauna</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['saloneventos']) && $d['saloneventos'] == 'S'){ $fac .= "<li>Salon de Eventos</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['eventos']) && $d['eventos'] == 'S'){ $fac .= "<li>Eventos</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['piniata']) && $d['piniata'] == 'S'){ $fac .= "<li>Pi&ntilde;ata</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['areapinatas']) && $d['areapinatas'] == 'S'){ $fac .= "<li>Area de Pi&ntilde;ata</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['saltarines']) && $d['saltarines'] == 'S'){ $fac .= "<li>Saltarines</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['areapicnic']) && $d['areapicnic'] == 'S'){ $fac .= "<li>Area Picnic</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['juegosninios']) && $d['juegosninios'] == 'S'){ $fac .= "<li>Juegos para Ni&ntilde;os</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['peliculas']) && $d['peliculas'] == 'S'){ $fac .= "<li>Peliculas</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['refrigerio']) && $d['refrigerio'] == 'S'){ $fac .= "<li>Refrigerio</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }


if (isset($d['restaurante']) && $d['restaurante'] == 'S'){ $fac .= "<li>Restaurante</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['restaurantes']) && $d['restaurantes'] == 'S'){ $fac .= "<li>Restaurantes</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['restaurantecafeteria']) && $d['restaurantecafeteria'] == 'S'){ $fac .= "<li>Restaurante & Cafeteria</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['cafeteria']) && $d['cafeteria'] == 'S'){ $fac .= "<li>Cafeteria</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['hoteles']) && $d['hoteles'] == 'S'){ $fac .= "<li>Hoteles</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['cruceros']) && $d['cruceros'] == 'S'){ $fac .= "<li>Cruceros</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['rentaautos']) && $d['rentaautos'] == 'S'){ $fac .= "<li>Renta Autos</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['lunasdemiel']) && $d['lunasdemiel'] == 'S'){ $fac .= "<li>Lunas de Miel</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['viajealcaribe']) && $d['viajealcaribe'] == 'S'){ $fac .= "<li>Viajes al Caribe</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['tours']) && $d['tours'] == 'S'){ $fac .= "<li>Tours</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['segurosdeviaje']) && $d['segurosdeviaje'] == 'S'){ $fac .= "<li>Seguros de Viaje</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['aceptaefectivo']) && $d['aceptaefectivo'] == 'S'){ $fac .= "<li>Acepta Efectivo</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['aceptacheques']) && $d['aceptacheques'] == 'S'){ $fac .= "<li>Acepta Cheques</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['aceptatarjetacredito']) && $d['aceptatarjetacredito'] == 'S'){ $fac .= "<li>Acepta Tarjetas de Credito</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['tarjetascredito']) && $d['tarjetascredito'] == 'S'){ $fac .= "<li>Acepta Tarjetas de Credito</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['reservaciones']) && $d['reservaciones'] == 'S'){ $fac .= "<li>Reservaciones</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['necesitareservacion']) && $d['necesitareservacion'] == 'S'){ $fac .= "<li>Necesita Reservacion</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['requierereservacion']) && $d['requierereservacion'] == 'S'){ $fac .= "<li>Requiere Reservacion</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['venceboleto']) && $d['venceboleto'] == 'S'){ $fac .= "<li>Vence Boleto</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['traslados']) && $d['traslados'] == 'S'){ $fac .= "<li>Traslados</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['tramitesmigratorios']) && $d['tramitesmigratorios'] == 'S'){ $fac .= "<li>Tramites Migratorios</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }


if (isset($d['vestidores']) && $d['vestidores'] == 'S'){ $fac .= "<li>Vestidores</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['banios']) && $d['banios'] == 'S'){ $fac .= "<li>Ba&ntilde;os</li>"; $colC++; $colCC++; }
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['banos']) && $d['banos'] == 'S'){ $fac .= "<li>Ba&ntilde;os</li>"; $colC++; $colCC++; }
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['serviciosanitario']) && $d['serviciosanitario'] == 'S'){ $fac .= "<li>Servicio Sanitario</li>"; $colC++; $colCC++; }
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['lineasaereas']) && $d['lineasaereas'] == 'S'){ $fac .= "<li>Lineas Aereas</li>"; $colC++; $colCC++; }
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }


if (isset($d['soloefectivo']) && $d['soloefectivo'] == 'S'){ $fac .= "<li>Solo Efectivo</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['notarjetacredito']) && $d['notarjetacredito'] == 'S'){ $fac .= "<li>No se acepta Tarjeta de Cr&eacute;dito</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['tarjetacredito']) && $d['tarjetacredito'] == 'S'){ $fac .= "<li>Se Acepta Tarjeta de Cr&eacute;dito</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['tarjetacreditorequerido']) && $d['tarjetacreditorequerido'] == 'S'){ $fac .= "<li>Tarjeta de Cr&eacute;dito Requerida</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['tarjetacreditoreserva']) && $d['tarjetacreditoreserva'] == 'S'){ $fac .= "<li>Reservaci&oacute;n con Tarjeta de Cr&eacute;dito</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['depositoreserva']) && $d['depositoreserva'] == 'S'){ $fac .= "<li>Reservaci&oacute;n con Deposito</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['animales'])){ 
	if($d['animales'] == 'S'){
		$fac .= "<li>Se Admiten Mascotas</li>"; $colC++;
	}else{ 
		$fac .= "<li>No Se Admiten Mascotas</li>"; $colC++;
	}
}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['trasladoaereopuerto'])){ 
	if($d['trasladoaereopuerto'] == 'S'){
		$fac .= "<li>Traslado Desde/Para el Aeropuerto</li>"; $colC++;
	}else{ 
		$fac .= "<li>Sin Traslado Desde/Para el Aeropuerto</li>"; $colC++;
	}
}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['playalagomar']) && $d['playalagomar'] == 'S'){ $fac .= "<li>Playa, Lago/Mar</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['biotopoareaprotegida']) && $d['biotopoareaprotegida'] == 'S'){ $fac .= "<li>Biotopo, Area Protegida</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['destinosnacionales']) && $d['destinosnacionales'] == 'S'){ $fac .= "<li>Destinos Nacionales</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
if (isset($d['destinosinternacionales']) && $d['destinosinternacionales'] == 'S'){ $fac .= "<li>Destinos Internacionales</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }

if (isset($d['observaciones']) && $d['observaciones'] != ''){ $fac .= "<li>Observaciones: ".$d['observaciones']."</li>"; $colC++;}
if($colC == 5){ $colC = 0; $colN++; $fac .= '</ul><ul id="'.$colN.'">'; }
$fac .= '</ul>';
$fac .= '<div class="clearfix"></div>';


// Actividades
$colCa = 0;
$colCCa = 0;
$colNa = 1;
$act = '<ul id="'.$colNa.'">';

if (isset($d['actcanopy']) && $d['actcanopy'] == 'S'){ $act .= "<li>Canopy</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actcaminata']) && $d['actcaminata'] == 'S'){ $act .= "<li>Caminata</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actgolf']) && $d['actgolf'] == 'S'){ $act .= "<li>Golf</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['acttenis']) && $d['acttenis'] == 'S'){ $act .= "<li>Tenis</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actbuceo']) && $d['actbuceo'] == 'S'){ $act .= "<li>Buceo</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actwaterski']) && $d['actwaterski'] == 'S'){ $act .= "<li>Esqu&iacute; Acu&aacute;tico</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actmotosdeagua']) && $d['actmotosdeagua'] == 'S'){ $act .= "<li>Moto Acu&aacute;tica</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actmotoscuatrollantas']) && $d['actmotoscuatrollantas'] == 'S'){ $act .= "<li>Moto Cuatro Llantas</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actkayacs']) && $d['actkayacs'] == 'S'){ $act .= "<li>Kayacs</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actrafting']) && $d['actrafting'] == 'S'){ $act .= "<li>Rafting</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actcamping']) && $d['actcamping'] == 'S'){ $act .= "<li>Camping</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actcaballos']) && $d['actcaballos'] == 'S'){ $act .= "<li>Caballos</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actpesca']) && $d['actpesca'] == 'S'){ $act .= "<li>Pesca</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actpaseoenlancha']) && $d['actpaseoenlancha'] == 'S'){ $act .= "<li>Paseso en Lancha</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actalpinismo']) && $d['actalpinismo'] == 'S'){ $act .= "<li>Alpinismo</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actbicicletas']) && $d['actbicicletas'] == 'S'){ $act .= "<li>Bicicleta</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actcortarfrutas']) && $d['actcortarfrutas'] == 'S'){ $act .= "<li>Cortar Frutas</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['acttourcafe']) && $d['acttourcafe'] == 'S'){ $act .= "<li>Tour de Caf&eacute;</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actgotcha']) && $d['actgotcha'] == 'S'){ $act .= "<li>Gotcha</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['acttouraves']) && $d['acttouraves'] == 'S'){ $act .= "<li>Tour de Aves</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
if (isset($d['actbungee']) && $d['actbungee'] == 'S'){ $act .= "<li>Bungee</li>"; $colCa++; $colCCa++; }
if($colCa == 5){ $colCa = 0; $colNa++; $act .= '</ul><ul id="'.$colNa.'">'; }
$act .= '</ul>';
$act .= '<div class="clearfix"></div>';

if($colCC >= 1){
	echo '<div id="facilidadesDisplay">';
	echo '<h2>Facilidades</h2>';
	echo $fac;
	echo '</div>';
}

if($colCCa >= 1){
	echo '<div id="facilidadesDisplay">';
	echo '<h2>Actividades</h2>';
	echo $act;
	echo '</div>';
}
//HOTELES ************************************************************************************************
$dlink = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
mysql_select_db(BDD_NAME,$dlink);

$hotel = mysql_query("SELECT * FROM usr_hoteles WHERE id in (SELECT establecimiento FROM usr_establecimiento_sitiointeres WHERE sitiointeres = $id AND tipo = 'hoteles')");
$afr = mysql_affected_rows($dlink);

if($afr > 0){
?>
<div id="facilidadesDisplay">
<h2>Hoteles</h2>
<ul>
	<?php while($h = mysql_fetch_assoc($hotel)){ ?>
    <li>
	<strong><?php echo $h['nombre'];?></strong><br />
	<?php if(isset($h['telefono1']) || isset($h['telefono2']) || isset($h['telefono3'])){ ?>
    Tel: 
        <?php
        if(isset($h['telefono1']) && $h['telefono1'] != ''){
			echo trim($h['telefono1']);
		}
		if(isset($h['telefono2']) && $h['telefono2'] != ''){
			echo ' / '.$h['telefono2'];
		}
		if(isset($h['telefono3']) && $h['telefono3'] != ''){
			echo ' / '.$h['telefono3'];
		}
		?>
        <?php }?><br />
	Dir: <?php echo utf8_encode($h['direccion']);?><br />
	<?php if (isset($h['email']) && $h['email'] != ''){ ?>
    Eml: <?php echo '<a href="mailto:'.$h['email'].'">'.$h['email'].'</a><br />'; ?>
    <?php } ?>
    <a href="index.php?p=8&seccion=19&id=<?php echo $h["id"];?>">Ver m&aacute;s</a>
    </li>
    
    <?php }?>
</ul>
</div><br /><br />
<?php }
//CASAS ************************************************************************************************
$hotel = mysql_query("SELECT * FROM usr_casas WHERE id in (SELECT establecimiento FROM usr_establecimiento_sitiointeres WHERE sitiointeres = $id AND tipo = 'casas')");
$afr = mysql_affected_rows($dlink);

if($afr > 0){
?>
<div id="facilidadesDisplay">
<h2>Casas En Renta</h2>
<ul>
	<?php while($h = mysql_fetch_assoc($hotel)){ ?>
    <li>
	<strong><?php echo $h['nombre'];?></strong><br />
	<?php if(isset($h['telefono1']) || isset($h['telefono2']) || isset($h['telefono3'])){ ?>
    Tel: 
        <?php
        if(isset($h['telefono1']) && $h['telefono1'] != ''){
			echo trim($h['telefono1']);
		}
		if(isset($h['telefono2']) && $h['telefono2'] != ''){
			echo ' / '.$h['telefono2'];
		}
		if(isset($h['telefono3']) && $h['telefono3'] != ''){
			echo ' / '.$h['telefono3'];
		}
		?>
        <?php }?><br />
	Dir: <?php echo utf8_encode($h['direccion']);?><br />
	<?php if (isset($h['email']) && $h['email'] != ''){ ?>
    Eml: <?php echo '<a href="mailto:'.$h['email'].'">'.$h['email'].'</a><br />'; ?>
    <?php } ?>
    <a href="index.php?p=8&seccion=30&id=<?php echo $h["id"];?>">Ver m&aacute;s</a>
    </li>
    
    <?php }?>
</ul>
</div><br /><br />
<?php } 
//RESTAURANTES ************************************************************************************************
$rests = mysql_query("SELECT * FROM usr_restaurantes WHERE id in (SELECT establecimiento FROM usr_establecimiento_sitiointeres WHERE sitiointeres = $id AND tipo = 'restaurantes')");
$afr = mysql_affected_rows($dlink);

if($afr > 0){
?>
<div id="facilidadesDisplay">
<h2>Restaurantes</h2>
<ul>
	<?php while($res = mysql_fetch_assoc($rests)){ ?>
    <li>
	<strong><?php echo $res['nombre'];?></strong><br />
	<?php if(isset($res['telefono1']) || isset($res['telefono2']) || isset($res['telefono3'])){ ?>
    Tel: 
        <?php
        if(isset($res['telefono1']) && $res['telefono1'] != ''){
			echo trim($res['telefono1']);
		}
		if(isset($res['telefono2']) && $res['telefono2'] != ''){
			echo ' / '.$res['telefono2'];
		}
		if(isset($res['telefono3']) && $res['telefono3'] != ''){
			echo ' / '.$res['telefono3'];
		}
		?>
        <?php }?><br />
	Dir: <?php echo utf8_encode($res['direccion']);?><br />
	<?php if (isset($res['email']) && $res['email'] != ''){ ?>
    Eml: <?php echo '<a href="mailto:'.$res['email'].'">'.$res['email'].'</a><br />'; ?>
    <?php } ?>
    <a href="index.php?p=8&seccion=23&id=<?php echo $res["id"];?>">Ver m&aacute;s</a>
    </li>
    
    <?php }?>
</ul>
</div><br /><br />
<?php } 
//ENTRETENIMIENTO ************************************************************************************************
$hotel = mysql_query("SELECT * FROM usr_entretenimiento WHERE id in (SELECT establecimiento FROM usr_establecimiento_sitiointeres WHERE sitiointeres = $id AND tipo = 'entretenimiento')");
$afr = mysql_affected_rows($dlink);

if($afr > 0){
?>
<div id="facilidadesDisplay">
<h2>Entretenimiento</h2>
<ul>
	<?php while($h = mysql_fetch_assoc($hotel)){ ?>
    <li>
	<strong><?php echo $h['nombre'];?></strong><br />
	<?php if(isset($h['telefono1']) || isset($h['telefono2']) || isset($h['telefono3'])){ ?>
    Tel: 
        <?php
        if(isset($h['telefono1']) && $h['telefono1'] != ''){
			echo trim($h['telefono1']);
		}
		if(isset($h['telefono2']) && $h['telefono2'] != ''){
			echo ' / '.$h['telefono2'];
		}
		if(isset($h['telefono3']) && $h['telefono3'] != ''){
			echo ' / '.$h['telefono3'];
		}
		?>
        <?php }?><br />
	Dir: <?php echo utf8_encode($h['direccion']);?><br />
	<?php if (isset($h['email']) && $h['email'] != ''){ ?>
    Eml: <?php echo '<a href="mailto:'.$h['email'].'">'.$h['email'].'</a><br />'; ?>
    <?php } ?>
    <a href="index.php?p=8&seccion=20&id=<?php echo $h["id"];?>">Ver m&aacute;s</a>
    </li>
    
    <?php }?>
</ul>
</div><br /><br />
<?php } 
//TRANSPORTE ************************************************************************************************
$hotel = mysql_query("SELECT * FROM usr_transporte WHERE id in (SELECT establecimiento FROM usr_establecimiento_sitiointeres WHERE sitiointeres = $id AND tipo = 'transporte')");
$afr = mysql_affected_rows($dlink);

if($afr > 0){
?>
<div id="facilidadesDisplay">
<h2>Transporte</h2>
<ul>
	<?php while($h = mysql_fetch_assoc($hotel)){ ?>
    <li>
	<strong><?php echo $h['nombre'];?></strong><br />
	<?php if(isset($h['telefono1']) || isset($h['telefono2']) || isset($h['telefono3'])){ ?>
    Tel: 
        <?php
        if(isset($h['telefono1']) && $h['telefono1'] != ''){
			echo trim($h['telefono1']);
		}
		if(isset($h['telefono2']) && $h['telefono2'] != ''){
			echo ' / '.$h['telefono2'];
		}
		if(isset($h['telefono3']) && $h['telefono3'] != ''){
			echo ' / '.$h['telefono3'];
		}
		?>
        <?php }?><br />
	Dir: <?php echo utf8_encode($h['direccion']);?><br />
	<?php if (isset($h['email']) && $h['email'] != ''){ ?>
    Eml: <?php echo '<a href="mailto:'.$h['email'].'">'.$h['email'].'</a><br />'; ?>
    <?php } ?>
    <a href="index.php?p=8&seccion=21&id=<?php echo $h["id"];?>">Ver m&aacute;s</a>
    </li>
    
    <?php }?>
</ul>
</div><br /><br />
<?php } ?>
<?php

if(isset($d['gpslongitud']) && $d['gpslongitud'] != ""){
	
	$longitud 	= $d['gpslongitud'];
	$latitud 	= $d['gpslatitud'];
	$altitud 	= $d['gpsaltitud'];
	
?>
<br /><br />
<div id="mapDisplay">
<h2>Mapa</h2>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
  function initialize() {
    var latlng = new google.maps.LatLng(<?php echo $latitud; ?>,<?php echo $longitud; ?>);
    var myOptions = {
      zoom: 14,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	var marker = new google.maps.Marker({
		position: latlng,
		title:"<?php echo $d['nombre']; ?>"
	});
	
	var contentString = '<div><h3><?php echo $d['nombre']; ?></h3><br /></div>';

	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});
	
	// To add the marker to the map, call setMap();
	marker.setMap(map);
	
	infowindow.open(map,marker);
	
  }
	
	window.onload = function(){
		initialize();
		}
</script>
<div id="map_canvas" style="width:510px; height:370px"></div>
</div>
<?php }
} ?>