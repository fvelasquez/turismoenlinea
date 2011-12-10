<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/turismo/init.php');
include_once("includes/conexion.php");
include_once("includes/funciones.php");
fSession::open();
$spot = new spot();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="Lo mejor de turismo en Guatemala,  hoteles Guatemala, restaurantes Guatemala, transporte Guatemala,  entretenimiento Guatemala, agencias de viaje Guatemala, Guatemala,  Antigua, Atitlan, Flores Peten, Alta Verapaz, baja Verapaz, Chimaltenango, Chiquimula , el progreso, Escuintla, Huehuetenango, Izabal, jalapa, Jutiapa, peten, Quetzaltenango, quiche, Retalhuleu, Sacatepéquez, san marcos, santa rosa, Sololá, Suchitepéquez, Totonicapán, Zacapa, La isla de flores peten, rio dulce, Cuevas de B’omb’il Pek y Jul Iq’ , Cuevas del Rey Marcos , Eco Centro Sataña , Hun Nal Ye , Parque Nacional Candelaria Camposanto , Parque Nacional Laguna de Lachuá , Reserva Natural Privada Chajbaoc , Saquijá , Semuc Champey, Antigua Guatemala , Basílica de Esquipulas , Castillo de San Felipe , Chichicastenango , Comalapa , Lago de Atitlán , Panajachel , Parque Ecológico del Sur , Parque Ecoturístico Cascadas de Tatasirire , Parque Nacional Tikal , Quetzaltenango , Quiriguá , Río Dulce , Todos Santos Cuchumatán , Volcán de Pacaya, Aguateca , Ceibal , Cooperativa Nuevo Horizonte , Parque Nacional Tikal , Puerta al Mundo Maya , Río Azul , Sitio Arqueológico Cancuén Chicacnab , Cuevas de B’omb’il Pek y Jul Iq’ , Cuevas del Rey Marcos , Eco Centro Sataña , Hun Nal Ye , Parque Nacional Candelaria Camposanto , Parque Nacional Laguna de Lachuá , Reserva Natural Privada Chajbaoc , Saquijá , Semuc Champey, Río Escondido , Salto de Chilascó,  Iximché, Basílica de Esquipulas , San Francisco Quetzaltepeque , San Juan Camotán , San Juan Ermita , Santiago de Esquipulas , Santiago Jocotán , Santísima Trinidad (Iglesia Vieja) , Volcán de Ipala , San Agustín Acasaguastlán , San Cristóbal Acasaguastlán , Sanarate, Parque Natural Calderas , Volcán de Pacaya, Amatitlán , Palacio Nacional de la Cultura, Biotopo Chocón Machacas , Bocas del Polochic , Castillo de San Felipe , Livingston , Quiriguá , Reserva Protectora de Manantiales Cerro San Gil , Río Dulce , Río Las Escobas , Río Quehueche , Siete Altares, Monterrico , Parque Ecológico del Sur, Aventura Maya K´iche´, Museo de Estanzuela , Valle Escondido" />
  <meta name="description" content="Lo mejor de turismo en Guatemala,  hoteles Guatemala, restaurantes Guatemala, transporte Guatemala,  entretenimiento Guatemala, agencias de viaje Guatemala, Guatemala,  Antigua, Atitlan, Flores Peten, Alta Verapaz, baja Verapaz, Chimaltenango, Chiquimula , el progreso, Escuintla, Huehuetenango, Izabal, jalapa, Jutiapa, peten, Quetzaltenango, quiche, Retalhuleu, Sacatepéquez, san marcos, santa rosa, Sololá, Suchitepéquez, Totonicapán, Zacapa, La isla de flores peten, rio dulce, Cuevas de B’omb’il Pek y Jul Iq’ , Cuevas del Rey Marcos , Eco Centro Sataña , Hun Nal Ye , Parque Nacional Candelaria Camposanto , Parque Nacional Laguna de Lachuá , Reserva Natural Privada Chajbaoc , Saquijá , Semuc Champey, Antigua Guatemala , Basílica de Esquipulas , Castillo de San Felipe , Chichicastenango , Comalapa , Lago de Atitlán , Panajachel , Parque Ecológico del Sur , Parque Ecoturístico Cascadas de Tatasirire , Parque Nacional Tikal , Quetzaltenango , Quiriguá , Río Dulce , Todos Santos Cuchumatán , Volcán de Pacaya, Aguateca , Ceibal , Cooperativa Nuevo Horizonte , Parque Nacional Tikal , Puerta al Mundo Maya , Río Azul , Sitio Arqueológico Cancuén Chicacnab , Cuevas de B’omb’il Pek y Jul Iq’ , Cuevas del Rey Marcos , Eco Centro Sataña , Hun Nal Ye , Parque Nacional Candelaria Camposanto , Parque Nacional Laguna de Lachuá , Reserva Natural Privada Chajbaoc , Saquijá , Semuc Champey, Río Escondido , Salto de Chilascó,  Iximché, Basílica de Esquipulas , San Francisco Quetzaltepeque , San Juan Camotán , San Juan Ermita , Santiago de Esquipulas , Santiago Jocotán , Santísima Trinidad (Iglesia Vieja) , Volcán de Ipala , San Agustín Acasaguastlán , San Cristóbal Acasaguastlán , Sanarate, Parque Natural Calderas , Volcán de Pacaya, Amatitlán , Palacio Nacional de la Cultura, Biotopo Chocón Machacas , Bocas del Polochic , Castillo de San Felipe , Livingston , Quiriguá , Reserva Protectora de Manantiales Cerro San Gil , Río Dulce , Río Las Escobas , Río Quehueche , Siete Altares, Monterrico , Parque Ecológico del Sur, Aventura Maya K´iche´, Museo de Estanzuela , Valle Escondido" />  
<title>Turismo En Linea</title>
<link href="css/Style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/south-street/jquery-ui-1.8.custom.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery.rating.css"/>
<script type="text/javascript" language="javascript" src="js/jquery-1.4.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.pngFix.pack.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.MetaData.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.rating.pack.js"></script>
<script type="text/javascript" language="javascript" src="menuJs/stmenu.js"></script>
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
<div id="container">
            <table width="771" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2">
                        <table width="771" border="0" cellspacing="0" cellpadding="0">
                            <tr class="fondouser" >
                                <td>
                                    <?php $spot->GeneraBanner(false,8); ?>
                                </td>
                                <td>
								<!-- form name="search" action="" id="search">
                                <input type="text" style="font-size:0.8em" />
                                <input type="submit" style="color:White; border:#507CD1 solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:0.8em; background-color:#284E98" />
                                </form-->
                                <div style="float:right; margin-right:10px; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold">
                                <?php 
								$usuario = fSession::get("username");
								if(isset($usuario) && $usuario != ""){ ?>
                                <img src="admin/images/user.png" border="0" /> <?php echo $usuario; ?>
                                <img src="admin/images/door_out.png" border="0" /> <a href="logout.php">cerrar sesi&oacute;n</a>
                                <?php }else{ ?>
                                <form name="login" action="login.php" id="login" method="post">
                                <table border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td>
                                            &nbsp;<label ID="UserNameLabel">Usuario:</label>
                                            <input type="text" id="usuario" name="usuario" size="10" class="validate[required]"/>
                                            <label ID="PasswordLabel">Password:</label>
                                            <input type="password" id="password" name="password" size="10" class="validate[required]"/>
                                            <input type="submit" ID="Entrar" name="Entrar" class="botoncito" value="Entrar" />
										</td>
                                    </tr>
                                </table>
                                </form>
                                <?php } ?>
                                </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr><!-- Termina el Header -->
                <tr bgcolor="#FFFFFF"><!-- inicio del banner medio -->
                    <td colspan="2">
                        <table width="771" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td rowspan="2">
                                    <?php $spot->GeneraBanner(false,10); ?>
                                </td>
                                <td><img src="Images/sitio-Turismo-final_06.jpg" width="57" height="22" alt="" /></td>
                                <td><a href="index.php?p=1"><img border="0px" src="Images/inicio.jpg" alt="Inicio"/></a></td>
                                <td><a href="index.php?p=2"><img border="0px" src="Images/registro.jpg" alt="Inicio"/></a></td>
                                <td><a href="index.php?p=3"><img border="0px" src="Images/soporte.jpg" alt="Inicio"/></a></td>
                                <td><a href="index.php?p=4"><img border="0px" src="Images/anunciese.jpg" alt="Inicio"/></a></td>
                                <td><a href="index.php?p=5"><img border="0px" src="Images/contactenos.jpg" alt="Inicio"/></a></td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <?php
                                    $spot->GeneraBanner(false,9);
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="fondomenu" style="height:10px; width:212px" align="center" valign="bottom" >                        
                    <?php echo date("M, d/Y"); ?>    
                    </td>
                    <td rowspan="2" align="left" valign="top" style="background-color:White">
                        <table border="0" cellspacing="0" cellpadding="0" class="text">
                            <tr>
                                <td align="left">&nbsp;</td>
                                <td valign="top">
                                    <br />
                                    <?php
									$p = fRequest::get('p');
                                    switch($p){
										case '1':
											include('main.php');
										break;
										case '2':
											include('registro.php');
										break;
										case '20':
											include('confirma.php');
										break;
										case '22':
											include('agregarregistro.php');
										break;
										case '3':
											include('contactenos.php');
										break;
										case '4':
											include('contactenos.php');
										break;
										case '5':
											include('contactenos.php');
										break;
										case '6':
											include('busqueda.php');
										break;
										case '7':
											include('resultado.php');
										break;
										case '8':
											include('detalle.php');
										break;
										case '9':
											include('mapas.php');
										break;
										default:
											include('main.php');
										break;
									}
									?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="fondomenu">
                    <td valign="top" align="center" style="height: 208px;">
                        <img src="images/spacer.gif" width="25" height="15" alt="" /><br />
                        <!--<div id="dMenu" runat="server"></div>-->
                        <table style=" vertical-align:middle" cellpadding="0" cellspacing="0" border="0">
                            <tr valign="middle">
                                <td align="center" valign="middle">
                                    <?php 
									$menuDinamico = new menuDinamico();
									echo $menuDinamico->generaMenuSecciones(""); 
									?>
                                </td>
                            </tr>
                        </table>
                        <br />
                        <img src="images/spacer.gif" width="25" height="15" alt="" /><br />
                    </td>
                </tr>
                <tr align="left" style="background-color:Transparent; width:771px" valign="top">
                    <td colspan="2" style="height:30px; width: 771px">
                        <table  class="fondofooter" border="0" cellspacing="0" cellpadding="8" style="height:30px; width:771px" >
                            <tr>
                                <td align="center" style="height: 30px">
                                    <span style="font-family:Verdana; background-color:Transparent; font-size:small; color:White">
                                        &copy; 2009 | www.turismoenlinea.org - Todos los derechos reservados
                                    </span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

    <!--script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3695948-2");
pageTracker._trackPageview();
    </script-->

</body>
</html>