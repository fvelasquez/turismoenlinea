<?php 
$sec = new SeccionClass(); 
$seccion = $_GET['seccion'];
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
        <tr>
            <td colspan="5" align="left" valign="top">
                 <?php $spot->GeneraBanner(14); ?></td>
        </tr>
    </table>
    <?php 
	echo $sec->GeneraMapas($_REQUEST);
	?>