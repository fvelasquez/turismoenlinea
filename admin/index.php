<?php
include_once('../init.php');
include_once("../includes/conexion.php");
if(fSession::get("username") == "" && $_GET['p'] != 'login'){
	header("Location: index.php?p=login&url=".urlencode($_SERVER["QUERY_STRING"]));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Administraci&oacute;n</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
<link rel="stylesheet" type="text/css" href="../css/south-street/jquery-ui-1.8.custom.css"/>
<link rel="stylesheet" type="text/css" href="../css/jquery.rating.css"/>
<script type="text/javascript" language="javascript" src="../js/jquery-1.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.pngFix.pack.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.MetaData.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.rating.pack.js"></script>
<script>
var Options = {
	monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Augosto','Septiembre','Octubre','Noviembre','Diciembre'],
	dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
	dateFormat: 'yy-mm-dd'
}
$(document).pngFix();
</script>
</head>

<body>
<div id="contenedor">
    <div id="header">Administrador de Sitios</div>
    <div id="cuerpo">
        <div id="barra_i">
        	<div id="menu">
            	<?php if(fSession::get("username") != ""){ ?>
            	<h4>
					<?php echo fSession::get("username"); ?>
        	        <a href="index.php?p=91"><img src="images/cross.png" border="0" alt="Cerrar Sesi&oacute;n" /></a>
    	            <a href="index.php?p=9"><img src="images/pencil.png" border="0" /></a>
                </h4>
                    <ul>
	                    <li><a href="index.php?p=8">Catalogos</a>
	                        <ul>
		                    	<li><a href="index.php?p=81"><img src="images/add.png" border="0" /> Ingresar Registro</a></li>
                            </ul>
                        </li>
                        <li> <a href="">Banners</a>
                            <ul>
                                <li><a href="index.php?p=2">Banners</a></li>
                                <li><a href="index.php?p=21">Spots</a></li>
                                <li><a href="index.php?p=22">Campa&ntilde;as</a></li>
                            </ul>
                        </li>
                        <!--li><a href="index.php?p=3">Secciones</a></li-->
                        <li><a href="index.php?p=4">Usuarios</a></li>
                        <li><a href="index.php?p=5">Autorizar</a></li>
						<li><a href="index.php?p=11">Secciones</a></li>
                        <li> <a href="">Reportes</a>
                            <ul>
                            	<!--li><a href="index.php?p=61">Registros Ingresados</a></li-->
                            	<li><a href="index.php?p=62">Registros Duplicados</a></li>
                            	<li><a href="index.php?p=63">Registros Ingresados</a></li>
                                <!--li><a href="index.php?p=61">Usuarios Registrados</a></li>
                                <li><a href="index.php?p=62">Secciones</a></li>
                                <li><a href="index.php?p=63">Historial Banners</a></li-->
                            </ul>
                        </li>
                    </ul>
                    
                    <!--ul>
                        <li><a href="index.php?p=7">Relaciones</a></li>
                        <li><a href="index.php?p=8">Catalogos</a></li>
                    </ul-->
				<?php } ?>
            </div>
        </div>
        <div id="barra_l">
            <div id="contenido">
             <?php
				$p = fRequest::get('p');
				switch($p){
					case '1':
						include('main.php');
					break;
					case 'login':
						include('login.php');
					break;
					case '11':
						include('secciones.php');
					break;
					case '2':
						include('banners.php');
					break;
					case '21':
						include('spots.php');
					break;
					case '22':
						include('campanias.php');
					break;
					case '3':
						include('secciones.php');
					break;
					case '4':
						include('usuarios.php');
					break;
					case '41':
						include('usuarios_crea.php');
					break;
					case '5':
						include('autorizar.php');
					break;
					case '51':
						include('autorizar_2.php');
					break;
					case '6':
						include('reportes.php');
					break;
					case '61':
						//include('rpt_usuarios_registrados.php');
						include('rpt_registros_ingresados.php');
					break;
					case '62':
						//include('rpt_secciones.php');
						include('rpt_duplicados.php');
					break;
					case '63':
						//include('rpt_historial_banners.php');
						include('rpt_tablas.php');
					break;
					case '7':
						include('relaciones.php');
					break;
					case '8':
						include('catalogos.php');
					break;
					case '81':
						include('registro_add.php');
					break;
					case '82':
						include('registro_add_pictures.php');
					break;
					case '83':
						include('mensajes.php');
					break;
					case '84':
						include("registro_add_sitios.php");
					break;
					case '85':
						include('catalogos_ver.php');
					break;
					case '86':
						include('registro_edita.php');
					break;
					case '87':
						include('registro_elimina.php');
					break;
					case '88':
						include('catalogos_ver_mapas.php');
					break;
					case '881':
						include('catalogos_edita_mapas.php');
					break;
					case '881':
						include('catalogos_elimina_mapas.php');
					break;
					case '9':
						include('perfil.php');
					break;
					case '91':
						include('../logout.php');
					break;
					default:
						include('login.php');
					break;
				}
				?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>