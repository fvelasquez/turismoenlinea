<?php
//include_once($_SERVER['DOCUMENT_ROOT'] . '/turismoenlinea/init.php');
//include_once($_SERVER['DOCUMENT_ROOT'] . '/turismoenlinea/includes/conexion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/init.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/conexion.php');

class Utils{

	public function add_column_if_not_exist($db, $column, $column_attr = "VARCHAR( 255 ) NULL" ){
	    $exists = false;
	
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		$columns = mysql_query("show columns from $db");
	    
		while($c = mysql_fetch_assoc($columns)){
	        if($c['Field'] == $column){
	            $exists = true;
	            break;
	        }
	    }      
	    if(!$exists){
			mysql_query("ALTER TABLE `$db` ADD `$column`  $column_attr");
			return true;
	    }else{
			return false;
		}
	}
	
	public function ncolor($nu = 1, $c1 = '#ffffff', $c2 = '#f0f0f0'){
		
		$n = $nu%2;
		$ret = ($n == 0)?$c1:$c2;
		return $ret;
		
	}
	
	public function GeneraGrid($gArr = mysql_result,$op = array()){
	
		$t = 0;
		$i = 0;
		$ii = 0;
		$gBody = "";
		$header = array();
		$gArr2 = array();
		$s = new SeccionClass();
		
		if($gArr){
		while($val = mysql_fetch_assoc($gArr)){
			$gArr2[] = $val;
			foreach($val as $key => $v){
				if($t == 0){
					$header[$i] = $key;
				}else{
					break;
				}
				$i++;
			}
			$t++;
		}
		
		//Si vienen datos en el querystring que no sea el orden aqui se reconstruye para que no se pierdan los filtros o
		//lo enviado
		if(isset($_REQUEST)){
			$qrs = "";
			foreach($_REQUEST as $key=>$val){
				$qrs .= $key.'='.$val.'&';
			}	
		}
		
		//Proceso de las opciones para saber que mostrar y que no
		$link = $op["link"];
		$target = ($op["target"]=="")?"_self":$op["target"];
		$or = $op["order"];
		$orCols = $op["ordercols"];
		$even = $op["even"];
		$paginate = $op["paginate"];
		$paginate_table = $op["paginate_table"];
		$paginate_page = $op["paginate_page"];
		$max = $op["paginate_max"];
		$filter = $op["filter"];
		$orderbycombo = $op["orderbycombo"];
		$alltables = $op["alltables"];
		if($alltables){
			$atables = " (
					SELECT id, nombre,'agenciaviaje' as tipo FROM usr_agenciasviaje
					UNION
					SELECT id, nombre,'artesanias' as tipo FROM usr_artesanias
					UNION
					SELECT id, nombre,'casas' as tipo FROM usr_casas
					UNION
					SELECT id, nombre,'entretenimiento' as tipo FROM usr_entretenimiento
					UNION
					SELECT id, nombre,'entretenimiento_fuera' as tipo FROM usr_entretenimiento_fuera
					UNION
					SELECT id, nombre,'guiaturismo' as tipo FROM usr_guiaturismo
					UNION
					SELECT id, nombre,'hoteles' as tipo FROM usr_hoteles
					UNION
					SELECT id, nombre,'restaurantes' as tipo FROM usr_restaurantes
					UNION
					SELECT id, nombre,'sitiosinteres' as tipo FROM usr_sitiosinteres
					UNION
					SELECT id, nombre,'transporte' as tipo FROM usr_transporte
				) AS alltables ";
		}
		
		$gBody = '';
		if($orderbycombo){
		$gBody .= '<form name="orderbycombo" method="get" action="index.php">';
		$gBody .= '<table width="100%" border="0" cellpadding="3" cellspacing="0">';
			$gBody .= '<tr>';
			$gBody .= '<td>';
				$gBody .= '<select>';
					$gBody .= '<option></option>';
				$gBody .= '</select>';
			$gBody .= '</td>';
			$gBody .= '</tr>';
		$gBody .= '</table>';
		$gBody .= '</form>';
		
		}
		
		$gBody .= '<table width="100%" border="0" cellpadding="3" cellspacing="0">';
		//Headers del Grid
		$gBody .= '<tr class="searchHeader">';
		$hh = 0;
		foreach($header as $h){
			if($hh > 0){
			$gBody .= '<td>';
			if (isset($_GET['orden']) && $_GET['orden'] == strtoupper($h).' ASC'){
				$gBody .= '<a href="?'.$qrs.'orden='.strtoupper($h).' DESC">'.strtoupper($h).'</a>';
				$gBody .= '<img src="images/sort_up.png" border="0" />';
			}else{
				if (isset($_GET['orden']) && $_GET['orden'] == strtoupper($h).' DESC'){
					$gBody .= '<a href="?'.$qrs.'orden='.strtoupper($h).' ASC">'.strtoupper($h).'</a>';
					$gBody .= '<img src="images/sort_down.png" border="0" /></a>';
				}else{
					$gBody .= '<a href="?'.$qrs.'orden='.strtoupper($h).' ASC">'.strtoupper($h).'</a>';;
				}
			}
			$gBody .= '</td>';
			}
			$hh++;
		}
		$gBody .= '</tr>';
		//Cuerpo del Grid
		$c = 0;
		foreach($gArr2 as $val){
			$ca = $this->ncolor($c,"searchEven","searchUneven");
			$gBody .= '<tr class="'.$ca.'">';
			for($ii=1;$ii < $i; $ii++){
				$gBody .= '<td>';
				if($link != "" && $ii == 1){
					if($alltables){
						$link = str_replace("seccion=&","seccion=".$s->IdSeccion($val[$header[2]])."&",$link);
						$gBody .= '<a href="'.$link.$val[$header[0]].'">'.utf8_encode($val[$header[$ii]]).'</a>';
					}else{
						$gBody .= '<a href="'.$link.$val[$header[0]].'">'.utf8_encode($val[$header[$ii]]).'</a>';
					}
				}else{
					$gBody .= utf8_encode($val[$header[$ii]]);
				}
				$gBody .= '</td>';
			}
			$gBody .= '</tr>';
			$c++;
		}
		if($paginate){
			$qr = $s->generateQSArray($filter);
			
			$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
			mysql_select_db(BDD_NAME,$link);
			if($alltables){
				$tablessel = "SELECT count(*) from ".$atables." WHERE NOT id IS NULL ".$qr;
			}else{
				$tablessel = "SELECT count(*) from ".strtolower($paginate_table)." WHERE NOT id IS NULL ".$qr;
			}
			$dat = mysql_query($tablessel);
			
			$raf = mysql_fetch_array($dat);
			$rowsAffected = $raf[0];
			
			$pages = round($rowsAffected / $max);
			$qr1 = $_SERVER['QUERY_STRING'];
			$qr = str_replace("page=".$paginate_page."&","",$qr1);
			$gBody .= '<tr><td colspan="'.($ii-1).'" align="center">';
			
			for($i=1;$i <= $pages; $i++){
				if ($paginate_page == ($i-1)){ $cssclass = "paginate_pagenumber_selected";}else{ $cssclass = "paginate_pagenumber"; }
				$gBody .= '<div class="'.$cssclass.'"><a href="index.php?page='.($i-1).'&'.$qr.'">'.$i.'</a></div>';
			}
		}
		$gBody .= '</td></tr></table>';
		}else{
			$gBody .= '<table><tr><td>';
			$gBody .= 'No se encontraron resultados para su busqueda<br />';
			$gBody .= '<input type="button" value="Regresar" onclick="javascript: history.back(-1);">';
			$gBody .= '</td></tr></table>';
		}
		return $gBody;
	}
	
	public function GeneraPassword($pass = ""){
		
		$hash = fCryptography::hashPassword($pass);
		return $hash;
	}
	
	public function arrayTabla($name){
		$name = trim($name);
		$lnk = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$lnk);
		
			if($name == "pais"){ $tabla = "pais"; $campos = "Codigo, Nombre"; $orden = "Codigo"; }
			if($name == "departamento"){ $tabla = "usr_departamentos";  $campos = "distinct departamento as Nombre"; $orden = "departamento"; }
			if($name == "municipio"){ $tabla = "usr_departamentos"; $campos = "distinct destino as Nombre"; $orden = "destino"; }
			if($name == "tipo"){ $tabla = "usr_entretenimiento"; $campos = "distinct tipo as Nombre"; $orden = "tipo"; }
			if($name == "ciudad"){ $tabla = "usr_hoteles"; $campos = "distinct ciudad as Nombre"; $orden = "ciudad"; }
		$dat = mysql_query("SELECT ".$campos." FROM ".$tabla." ORDER BY ".$orden."");
		
		//mysql_close($link);
		return $dat;

		
	}
	
	public function generateInput($data,$tipoF,$tamanio,$name,$tipoD,$seccion){
		$data =(isset($data) && $data != "")?utf8_encode($data):'';
		if($tipoD == 6){ $tipoF = 4; }
		if($tipoD == 7){ $tipoF = $tipoD; }
		if($tipoD == 8){ $tipoF = $tipoD; }
		$size = 20;
		if($tamanio > 40){ $size = 30; }
		switch($tipoF){
			// 1 = textbox, 2 = combobox, 3 = datebox, 4 = checkbox, 5 = radiobutton, 6 = textarea, 7 = timeboxes
			// 8 = ratingInput
			// default = textbox
			case 1:
				$sal = '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$data.'" size="'.$size.'" maxlength="'.$tamanio.'"/>';
				break;
			case 2:
				
				$sal = '<select name="'.$name.'" id="'.$name.'" >';
				
				$d = $this->arrayTabla($name);
				
				$sal .= '<option value="">Seleccione...</option>';
				while($r = mysql_fetch_assoc($d)){
					$sal .= '<option value="'.$r['Nombre'].'"';
					if(trim($r['Nombre']) == trim($data)){
						$sal .= ' selected="selected"';
					}
					$sal .= '>'.utf8_encode($r['Nombre']).'</option>';
				}
				$sal .= '</select>';
				break;
			case 3:
				$sal = '
				<script>
				$(function(){
				$(\'#'.$name.'\').datepicker(Options);
				});
				</script>
				<input type="text" name="'.$name.'" id="'.$name.'" value="'.$data.'" size="10"/>';
				break;
			case 4:
				$checked = "";
				if($data == "S"){ $checked = 'checked="checked"'; }
				$sal = '<input type="checkbox" name="'.$name.'" id="'.$name.'" value="S" '.$checked.'/>';
				break;
			case 5:
				$checked = "";
				if($data == ""){ $checked = 'checked="checked"'; }
				$sal = '<input type="radio" name="'.$name.'" id="'.$name.'" value="'.$data.'" '.$checked.'/>';
				break;
			case 6:
				$sal = '<textarea name="'.$name.'" id="'.$name.'" cols="20">'.$data.'</textarea>';
				break;
			case 7:
				if($data != ""){ $ex = explode(":",$data); }else{ $ex = array(0,0); }
				$sal = '<input type="text" name="'.$name.'_h" id="'.$name.'_h" value="'.$ex[0].'" size="2"/> : <input type="text" name="'.$name.'_m" id="'.$name.'_m" value="'.$ex[1].'" size="2"/>';
				break;
			case 8:
				$checked1 = "";
				$checked2 = "";
				$checked3 = "";
				$checked4 = "";
				$checked5 = "";
				if($data == "1"){ $checked1 = 'checked="checked"'; }
				if($data == "2"){ $checked2 = 'checked="checked"'; }
				if($data == "3"){ $checked3 = 'checked="checked"'; }
				if($data == "4"){ $checked4 = 'checked="checked"'; }
				if($data == "5"){ $checked5 = 'checked="checked"'; }
				$sal = '
				<script>
				$(function(){
				$(\'input.'.$name.'\').rating();
				});
				</script>
				<input name="'.$name.'" id="'.$name.'" type="radio" value="1" class="star" '.$checked1.'/>
				<input name="'.$name.'" id="'.$name.'" type="radio" value="2" class="star" '.$checked2.'/>
				<input name="'.$name.'" id="'.$name.'" type="radio" value="3" class="star" '.$checked3.'/>
				<input name="'.$name.'" id="'.$name.'" type="radio" value="4" class="star" '.$checked4.'/>
				<input name="'.$name.'" id="'.$name.'" type="radio" value="5" class="star" '.$checked5.'/>';
				break;
			default:
				$sal = '<input type="text" name="'.$name.'" id="'.$name.'"  size="'.$size.'" maxlength="'.$tamanio.'" value="'.$data.'" />';
				break;
		}
		
		return $sal;
	}
}

class SeccionClass{
	
	//Trae el nombre de la seccion, Largo o Corto dependiendo del parametro que le envie
	public function NombreSeccion($numero = 1,$lc = 'NombreLargo'){
		
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		$nombre = '';
		$res = mysql_query("SELECT Nombre, NombreLargo FROM seccion  WHERE seccion = '$numero' AND Estado = 1");
		while($row = mysql_fetch_assoc($res)){
			$nombre = $row[$lc];
		}
		return $nombre;
	}
	
	public function IdSeccion($nombre = 'hoteles',$lc='seccion'){
		
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		
		$res = mysql_query("SELECT seccion FROM seccion  WHERE Nombre = '$nombre' AND Estado = 1");
		while($row = mysql_fetch_assoc($res)){
			$seccion = $row[$lc];
		}
		return $seccion;
	}
	
	public function getColumnatabla($t = 'columna',$lc = 'NombreLargo',$w = 'seccion = 19'){
		
		$gct = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$gct);
		//echo "SELECT $lc FROM $t WHERE $w";
		$res = mysql_query("SELECT $lc FROM $t WHERE $w");
		while($row = mysql_fetch_assoc($res)){
			$nombre = $row[$lc];
		}
		return $nombre;
	}
	
	public function NombreSitio($numero = 1){
		
		$lnk = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$lnk);
		
		$res = mysql_query("SELECT Nombre FROM sitio WHERE Sitio = '$numero'");
		while($row = mysql_fetch_assoc($res)){
			$nombre = $row["Nombre"];
		}
		return $nombre;
	}
	
	public function getShowcaseAds($seccion = 1){
	
		$lnk = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$lnk);
		
		$res = mysql_query("SELECT pdd.Asignacion, pdd.Campana, pdd.Seccion, pdd.Spot, pd.Banner, pd.Contador, pd.Estado, pd.Fecha_ini, pd.Fecha_fin, pd.Frecuencia, pd.Impresiones, pd.NoHistorial, pd.Nombre, pd.Novence, pd.Preferencia,	pb.Estado as BannerEstado, pb.Filename, pb.Link, pb.Nombre as BannerNombre, pb.Tipo FROM pubdisplaydetail pdd inner join pubdisplay pd on pdd.Campana = pd.Campana inner join pubbanner pb on pd.Banner = pb.Banner WHERE pdd.seccion = '$seccion' AND pdd.spot = 15");
		return $res;
	
	}
	
	private function ObtieneColumnaDatos($seccion = 1, $campo = null, $tamanio, $tipo=0){

		$obtienecdsql = new fDatabase('mysql', BDD_NAME, BDD_USER, BDD_PASSWORD, BDD_HOST);
		$nombreSeccion = $this->NombreSeccion($seccion,"Nombre");
		
		if($campo == 'pais'){$tabla = 'pais'; $campo = 'Nombre'; $namecampo = 'pais'; }else{$tabla = "usr_".$campo; $namecampo = $campo; }
		$qry = 'select distinct '.$campo.' from '.$tabla.' order by '.$campo.'';
		// Se obtienen las columnas de esta seccion
		$res = $obtienecdsql->query($qry);
		if ($res != ''){
			$overhead = false;
			$sal = '';
			$saltemp = '<option></option>';
			foreach ($res as $row)
			{
				if (strlen($row[$campo]) > $tamanio){ $overhead = true; }
				$saltemp .= '<option>'.$row[$campo].'</option>';
			}
			
			if ($overhead){
				$sal = '<select style="width:350px" name="'.$tipo.'|'.$namecampo.'" id="'.$namecampo.'">';
			}else{
				$sal = '<select name="'.$tipo.'|'.$namecampo.'" id="'.$namecampo.'">';
			}
			$sal .= $saltemp;
			$sal .= '</select>';
		}else{
			$sal = 'Error: '.$res;
		}
		return $sal;
	}
	
	//Agrega 1 al contador de visitas por pagina mostrada
	private function AumentaContador($seccion = 1){
		
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		$res = mysql_query("UPDATE seccion SET Visitas = (Visitas + 1) WHERE seccion = '$seccion'");

	}
	
	//Genera el formulario de busqueda dependiendo de que seccion sea.
	public function BuscadorSeccion($seccion = 1){
		
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		
		$this->AumentaContador($seccion);
		$nombreSeccion = $this->NombreSeccion($seccion,'NombreLargo');
		$_SESSION['Seccion'] = $seccion;
		$_SESSION['NombreSeccion'] = $nombreSeccion;
		
		// Se obtienen las columnas de esta seccion
		$res = mysql_query("select nombre, nombre_largo, IFNULL(display_busqueda,0) as display_busqueda, display_listado, display_detalle, tipo, orden from columna where seccion=$seccion and estado = 1 order by orden");
		$sal = '<table width="100%" border="0" cellspacing="3" cellpadding="0" >';
		$i = 0;
		while($row = mysql_fetch_assoc($res)){
			if($row["display_busqueda"] != '0'){
			$i++;
			
			$nombre = utf8_encode($row["nombre"]);
			$tipo = utf8_encode($row["tipo"]);
			
            $sal .= '<tr>';
            $sal .= '<td ><nobr><strong>'.utf8_encode($row["nombre_largo"]).':</strong> </nobr></td>';
            $sal .= '<td style="width:350px">';
                    switch ($row["display_busqueda"])
                    {
						// 1 = textbox, 2 = combobox, 3 = datebox, 4 = checkbox, default = textbox
                        case 1:
                            $sal .= '<input type="text" name="'.$tipo.'|'.$nombre.'" id="'.$nombre.'"/>';
                            break;
                        case 2:
                            $sal .= $this->ObtieneColumnaDatos($seccion,$nombre,70,$tipo);
                            break;
						case 3:
							$sal .= '
							<script>
							$(function(){
							$(\'#'.$nombre.'\').datepicker(Options);
							});
							</script>
							<input type="text" name="'.$tipo.'|'.$nombre.'" id="'.$nombre.'">';
							break;
						case 4:
							$sal .= '<input type="checkbox" name"'.$tipo.'|'.$nombre.'" id="'.$nombre.'" value="S"/>';
							break;
						default:
                            $sal .= '<input type="text" name="'.$tipo.'|'.$nombre.'" id="'.$nombre.'"/>';
                            break;
                    }
                    $sal .= '</td></tr>';
			}
		}
	
			if($i == 0){ $sal .= '"<tr><td>No hay criterios de busqueda definidos</td></tr>"'; }
			$sal .= '</table>';
			
			return $sal;
			
	}// Fin de BuscadorSeccion
	
	public function generateQSArray($qs = array()){
		// Se sacan los filtros a aplicar
		$qs = explode("&",$qs);
		$arF = array();
		$fil = "";
		foreach($qs as $val){
			$campo = key($qs);
			
//			$carr = explode("|",$val);
			$carr = explode("%7C",$val);
			if(count($carr) > 1){
				$cTipo = $carr[0];
				$cNa = $carr[1];
			}else{
				$cTipo = $carr[0];				
			}
			
			if(is_numeric($cTipo)){
				$vall = explode("=",$cNa);
				$cName = $vall[0];
				$vale = $vall[1];
			}else{
				$vall = explode("=",$cTipo);
				$cName = $vall[0];
				$vale = $vall[1];				
			}
			
			if($cName != 'p' && $cName != 'seccion' && $cName != 'orden' && $vale != '' && $cName != 'page'){
				/* 	1 entero
					2 cadena
					3 imagen
					4 moneda
					5 fecha
				*/
				switch($cTipo){
					case 1:
						$fil .= " AND $cName = ".urldecode($vale)."";
					break;
					case 2:
						$fil .= " AND $cName like '%".urldecode($vale)."%'";
					break;
					case 3:
						//$qry .= " AND $cName = '$val'";
					break;
					case 4:
						$fil .= " AND $cName = '".urldecode($vale)."'";
					break;
					case 5:
						$fil .= " AND $cName = '".urldecode($vale)."'";
					break;
					case 6:
						$fil .= " AND $cName = '".urldecode($vale)."'";
					break;
					default:
						$fil .= " AND $cName = '".urldecode($vale)."'";
					break;
					
				}
			}
			next($qs);
		}
		return $fil;
		
	}
	
	//Generador de Arreglo de Resultados de busqueda
	public function generaResultados($qs = array(),$max=10,$page=0,$order="",$all=false){
		
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		$fil = "";
		if($all == TRUE){
			
			$qry = "SELECT id, nombre,tipo from (
				SELECT id, nombre,'agenciaviaje' as tipo FROM usr_agenciasviaje
				UNION
				SELECT id, nombre,'artesanias' as tipo FROM usr_artesanias
				UNION
				SELECT id, nombre,'casas' as tipo FROM usr_casas
				UNION
				SELECT id, nombre,'entretenimiento' as tipo FROM usr_entretenimiento
				UNION
				SELECT id, nombre,'entretenimiento_fuera' as tipo FROM usr_entretenimiento_fuera
				UNION
				SELECT id, nombre,'guiaturismo' as tipo FROM usr_guiaturismo
				UNION
				SELECT id, nombre,'hoteles' as tipo FROM usr_hoteles
				UNION
				SELECT id, nombre,'restaurantes' as tipo FROM usr_restaurantes
				UNION
				SELECT id, nombre,'sitiosinteres' as tipo FROM usr_sitiosinteres
				UNION
				SELECT id, nombre,'transporte' as tipo FROM usr_transporte				
				)as alltables WHERE NOT id is NULL ";
			
		}else{
			$seccion = '';
			if(isset($_SESSION['Seccion']) && $_SESSION['Seccion'] != ''){ 
			$qseccion = $_SESSION['Seccion'];
			$seccion = 'seccion='.$_SESSION['Seccion'].' AND'; 
			}
			if(isset($_GET['seccion']) && $_GET['seccion'] != ''){ 
			$qseccion = $_GET['seccion'];
			$seccion = 'seccion='.$_GET['seccion'].' AND'; 
			}
			
			$nombreSeccion = $this->NombreSeccion($qseccion,'Nombre');
			
			$campos = mysql_query("select nombre from columna where ".$seccion." display_busqueda > 0 AND display_listado = 1 and estado = 1 order by orden");
			$qry = 'Select id,';
			$i = 0;
			// Se sacan los campos a mostrar
			while($c = mysql_fetch_assoc($campos)){
				if($i > 0){ $qry .= ', '.$c['nombre']; }else{$qry .= $c['nombre'];}
				$i++;
			}
			$qry .= ' FROM usr_'.$nombreSeccion.' WHERE NOT id IS NULL ';
		
		}
		// Se sacan los filtros a aplicar
		//$qs = explode("&",$qs);
		$qr = $this->generateQSArray($qs);			
		//echo $qr;
		$qry .= $qr;
		if(isset($order) && $order != ''){ $qry .= " ORDER BY $order"; }
		$plimit = ($page*$max);
		$qry .= " LIMIT $plimit,$max ";
		$res = mysql_query($qry);
		return $res;
	}
	
	public function getInformacionItem($item = '',$seccion = 1)
	{
		$item =($item == "")?"":" AND id =".$item;
		$whr  =($item == "")?" AND id in (SELECT id_padre FROM usr_fotos WHERE seccion = ".$seccion.")":""; 
		$max = ($item == "")?" LIMIT 0,10":"";
		$gresult = new fDatabase('mysql', BDD_NAME, BDD_USER, BDD_PASSWORD, BDD_HOST);
		$seccion = $seccion;
		$nombreSeccion = $this->NombreSeccion($seccion,'Nombre');
		$campos = $gresult->query("select nombre from columna where seccion= ".$seccion." AND display_detalle > 0 and estado = 1 order by orden");
		$qry = 'Select id,';
		$i = 0;
		// Se sacan los campos a mostrar
		foreach($campos as $c){
			if($i > 0){ $qry .= ', '.$c['nombre']; }else{$qry .= $c['nombre'];}
			$i++;
		}
		$qry .= ' FROM usr_'.$nombreSeccion.' WHERE NOT id IS NULL '.$item.' '.$whr.' '.$max;
		$res = $gresult->query($qry);
		return $res;
	}
	
	public function getGallery($item = 1,$seccion = 1)
	{
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		$seccion = $seccion;
		$nombreSeccion = $this->NombreSeccion($seccion,'Nombre');
		$fotos = mysql_query("select * from usr_fotos where id_padre = ".$item." AND seccion = ".$seccion." order by orden");
		return $fotos;
	}
	
	public function GeneraMapas($cue = array())
	{
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);

		if(isset($cue['sint'])){
			$qry = "select * from usr_mapas WHERE activo = 'A' and sitio_interes = '".$cue['sint']."' order by sitio_interes";
		}else{
			$qry = "select distinct sitio_interes from usr_mapas order by sitio_interes";
		}
		$mapas = mysql_query($qry);
		$txtf = '<div id="sitiosInteres"><h2>Mapas de Sitios de Interes</h2></div>';
		$txtf .= '<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">';
		$cc = 0;
		if(isset($cue['sint'])){
			$txtf .= '<tr>';
			$txtf .= '<td colspan="2"><strong>Sitio: '.$cue['sint'].'</strong></td>';
			$txtf .= '</tr>';
			while($m = mysql_fetch_assoc($mapas)){
				$mid			= $m["id"];
				$dir 			= "Mapas";
				$pdf			= $m["pdf"];
				$img			= $m["imagen"];
				$thumb			= $m["imagen_thumb"];
				$downloadable 	= $m["descargable"];
				$sinteres 		= $m["sitio_interes"];
				$titulo			= $m["titulo"];
				$nombre			= $m["nombre"];
				$ut 			= new Utils();
				$color 			= $ut->ncolor($cc,'#f0f0f0','#ffffff');
				$txtf .= '<tr bgcolor="'.$color.'">';
				$txtf .= '<td>'.$nombre.'</td>';
//				$txtf .= '<td><img src="'.$dir.'/'.$thumb.'"/></td>';
				$txtf .= '<td><a href="admin/'.strtolower($dir).'/'.$img.'" target="_blank">Ver Mapa</a>';
				if($pdf != ''){
					$txtf .= ' | <a href="admin/'.strtolower($dir).'/'.$pdf.'" target="_blank">Imprimir en PDF</a></td>';
				}
				$txtf .= '</tr>';
				$cc++;
			}
		}else{
			while($m = mysql_fetch_assoc($mapas)){
				$sinteres 	= $m["sitio_interes"];
				$ut = new Utils();
				$color = $ut->ncolor($cc,'#f0f0f0','#ffffff');
				$txtf .= '<tr bgcolor="'.$color.'">';
				$txtf .= '<td><a href="index.php?p='.$cue["p"].'&seccion='.$cue["seccion"].'&sint='.$sinteres.'">'.$sinteres.'</a></td>';
				$txtf .= '</tr>';
				$cc++;
			}
		}
		$txtf .= '</table>';
		return $txtf;
	}
	
	public function GeneraMapasEditable($cue = array())
	{
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);

		if(isset($cue['sint'])){
			$qry = "select * from usr_mapas WHERE activo = 'A' and sitio_interes = '".$cue['sint']."' order by sitio_interes";
		}else{
			$qry = "select distinct sitio_interes from usr_mapas order by sitio_interes";
		}
		$mapas = mysql_query($qry);
		$txtf = '<div id="sitiosInteres"><h2>Mapas de Sitios de Interes</h2></div>';
		$txtf .= '<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">';
		$cc = 0;
		if(isset($cue['sint'])){
			$txtf .= '<tr>';
			$txtf .= '<td colspan="2"><strong>Sitio: '.$cue['sint'].'</strong></td>';
			$txtf .= '</tr>';
			while($m = mysql_fetch_assoc($mapas)){
				$mid			= $m["id"];
				$dir 			= "Mapas";
				$pdf			= $m["pdf"];
				$img			= $m["imagen"];
				$thumb			= $m["imagen_thumb"];
				$downloadable 	= $m["descargable"];
				$sinteres 		= $m["sitio_interes"];
				$titulo			= $m["titulo"];
				$nombre			= $m["nombre"];
				$ut 			= new Utils();
				$color 			= $ut->ncolor($cc,'#f0f0f0','#ffffff');
				$txtf .= '<tr bgcolor="'.$color.'">';
				$txtf .= '<td>'.$nombre.'</td>';
//				$txtf .= '<td><img src="'.$dir.'/'.$thumb.'"/></td>';
				$txtf .= '<td><a href="'.$dir.'/'.$img.'" target="_blank">Ver Mapa</a>';
				$txtf .= '<a href="index.php?p=881&seccion='.$cue["seccion"].'&sitio='.$sinteres.'&id='.$mid.'"><img src="images/pencil.png" border="0" /></a>';
				$txtf .= '<a href="index.php?p=882&seccion='.$cue["seccion"].'&sitio='.$sinteres.'&id='.$mid.'"><img src="images/delete.png" border="0" /></a></td>';
				$txtf .= '</tr>';
				$cc++;
			}
		}else{
			while($m = mysql_fetch_assoc($mapas)){
				$sinteres 	= $m["sitio_interes"];
				$ut = new Utils();
				$color = $ut->ncolor($cc,'#f0f0f0','#ffffff');
				$txtf .= '<tr bgcolor="'.$color.'">';
				$txtf .= '<td><a href="index.php?p='.$cue["p"].'&seccion='.$cue["seccion"].'&sint='.$sinteres.'">'.$sinteres.'</a></td>';
				$txtf .= '<td>';
				$txtf .= '<a href="index.php?p=89&seccion='.$cue["seccion"].'&sitio='.$sinteres.'&id='.$m['id'].'"><img src="images/pencil.png" border="0" /></a>';
				$txtf .= '<a href="index.php?p=891&seccion='.$cue["seccion"].'&sitio='.$sinteres.'&id='.$m['id'].'"><img src="images/delete.png" border="0" /></a>';
				$txtf .= '</td>';
				$txtf .= '</tr>';
				$cc++;
			}
		}
		$txtf .= '</table>';
		return $txtf;
	}
	
}

class spot{
  
    public function GeneraBanner($spot = null,$seccion=0){

    
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);

		$qry = "SELECT ps.Width, ps.Height, ps.Strech, pdd.Spot, pdd.Seccion, pdd.Campana, pd.Banner, pd.Fecha_ini as Fecha, pb.Nombre, pb.Filename, pb.Link, pb.Estado FROM pubdisplay pd INNER JOIN pubdisplaydetail pdd ON pdd.Campana = pd.Campana INNER JOIN pubbanner pb ON pb.Banner = pd.Banner INNER JOIN pubspot ps ON ps.Spot = pdd.Spot WHERE pdd.Spot = ".$spot." AND pb.Estado = 1 ";
		if($seccion != '' && $seccion != 0){ $qry .= " AND pdd.Seccion = '".$seccion."' "; }
		$qry .= "ORDER By Fecha DESC";
//		echo $qry;
		$res = mysql_query($qry);
		
	  $tot = mysql_affected_rows($link);
	  $nBanner = rand(1,$tot);
	  $c = 0;
	  if($tot > 0){
		  while($row = mysql_fetch_assoc($res)){
			 $c++;
			if($c == $nBanner){
				if(($row['Link'] != '') && ($row['Link'] != NULL)){ 
					echo '<a href="'.$row['Link'].'"><img src="images/'.$row['Filename'].'" border="0"/></a>';
				}else{
					echo '<img src="images/'.$row['Filename'].'" border="0" />';
				}
			}
		  }
	  }else{
		  echo '<img src="images/spacer.gif" />';
	  }
    
  }


}

class menuDinamico{
	
	private $ar = array();
	public $generado = '';

	public function filter_by_value ($array, $index, $value){ 
        if(is_array($array) && count($array)>0)  
        { 
            foreach(array_keys($array) as $key){ 
                $temp[$key] = $array[$key][$index]; 
                 
                if ($temp[$key] == $value){ 
                    $newarray[$key] = $array[$key]; 
                } 
            } 
          } 
      return $newarray; 
    } 

	public function generaMenuSecciones($carpeta = '',$class = 'menuPrincipal'){
		$link = mysql_connect(BDD_HOST,BDD_USER, BDD_PASSWORD);
		mysql_select_db(BDD_NAME,$link);
		// Obtiene secciones
		$res = mysql_query("SELECT seccion, nombrelargo AS nombre, IFNULL(padre,0) AS padre, tipo, '' as forma FROM seccion WHERE sitio = 2 and estado = 1  ORDER BY orden");
		$i = 0;
		while ($row = mysql_fetch_assoc($res))
		{
			$ar[$i]['estructura'] 	= $row['seccion'];
			$ar[$i]['nombre'] 		= $row['nombre'];
			$ar[$i]['padre'] 		= $row['padre'];
			$ar[$i]['tipo'] 		= $row['tipo'];
			if($row['seccion'] == "27"){
				$ar[$i]["forma"] 		= $carpeta."index.php?p=9&seccion=".$row["seccion"];
			}else{
				$ar[$i]["forma"] 		= $carpeta."index.php?p=10&seccion=".$row["seccion"];
			}
			$i++;
		}

		return $this->generaMenuS(0,$carpeta,$ar,$class);
	}
	
	public function generaMenuS($root,$carpeta,$ar,$class) 
    {
        $salida ='<div id="'.$class.'"><ul>';
		$salida .= '<li><a href="index.php?p=1">Inicio</a></li>';
        $salida .= $this->CreateMenuS($root,$carpeta,$ar);
//		$salida .= '<li><a href="index.php?p=5">Contactenos</a></li>';
		$salida .= "<ul>";
        return $salida;
    }

	private function CreateMenuS($str, $carpeta,$ar)
    {
        $generado = '';
		$drClass = "padre='$str'";
		$Count = count($ar);
		$i = 0;
        foreach ($ar as $r)
        {
            $generado .= '<li><a href="'.$r["forma"].'" >'.$r["nombre"].'</a></li>';
            $i++;
        }
        return $generado;
    }
}
?>