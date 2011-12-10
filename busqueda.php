<?php 
$sec = new SeccionClass(); 
$seccion = $_GET['seccion'];
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="5" align="left" valign="top">
                 <?php $spot->GeneraBanner(14); ?></td>
        </tr>
        <!--tr>
            <td colspan="5" align="left" valign="top" class="lineamenu" style="height: 17px">
                <label ID="Label1" class="neostyletitle">Desea Agregar un Nuevo Registro  !!Debe Registrarse !!!</label>
                <input type="button" id="Button2" value="Agregar" class="botoncito" /></td>
        </tr-->
    </table>
<div id="search_2">
<img src="images/instrucciones_busqueda.jpg" border="0" />
</div>
    <div class="title_image" style="width:480px;">Busqueda de <?php echo $sec->NombreSeccion($seccion); ?></div>
        <div id="formaBusqueda" style="width: 530px;">
        <form id="formularioBusqueda" name="formularioBusqueda" action="index.php" method="get">
        <?php 
			echo $sec->BuscadorSeccion($seccion);
		?>
        		<input type="hidden" value="7" name="p" />
                <input type="hidden" value="<?php echo $_GET['seccion']; ?>" name="seccion" />
        		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" id="Button1" value="Buscar" class="botoncito" />
        </form>
        </div>