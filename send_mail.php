<?php
include_once('init.php');

if(isset($_POST['Enviar']) && $_POST['Enviar'] == 'Enviar'){
	
	$from = fRequest::get("from");
	
	if($from == "3" || $from == "4" || $from == "5"){
	
	$key = fRequest::get("key");
	$date = fRequest::get("date");
		if(fCryptography::checkPasswordHash($date, $key)){
			
			$correo = fRequest::get("tbemail");
			$telefono = fRequest::get("tbtelefono");
			$celular = fRequest::get("tbcelular");
			$comentarios = fRequest::get("tbcomentarios");
			$nombre  = fRequest::get("tbnombre");

			$email = new fEmail();
			$email->addRecipient('info@turismoenlinea.org', 'Informacion');
			$email->setFromEmail('info@turismoenlinea.org');
			$email->setSubject('Correo desde turismoenlinea.org');
			$body = 'El siguiente correo fue enviado como ';
			if($from == 3){
				$body .= 'una solicitud de soporte<br />';
			}
			if($from == 4){
				$body .= 'una petición de anuncio<br />';
			}
			if($from == 5){
				$body .= 'un contacto<br />';
			}
			$body .= 'Nombre: '.$nombre.'<br />';
			$body .= 'Telefono: '.$telefono.'<br />';
			$body .= 'Celular: '.$celular.'<br />';
			$body .= 'Correo Electronico: '.$correo.'<br />';
			$body .= 'Comentario: '.$comentarios.'<br />';
			$email->setBody("Visto en HTML");
			$email->setHTMLBody($body);
			//$smtp = new fSMTP('smtp.gmail.com', 465, TRUE, 5);
			//$smtp = new fSMTP('mail.turismoenlinea.org');
			$smtp = new fSMTP('mail.richam.com');
			$smtp->authenticate('info@turismoenlinea.org', '425724');
			//$smtp->authenticate('f0vela@gmail.com', 'thisismanolo');
			$message_id = $email->send($smtp);
			$smtp->close();
			echo "<script>window.location = 'index.php?p=$from&msg=Mensaje enviado con exito'</script>";
		}else{
			echo "<script>window.location = 'index.php?p=$from&msg=Error de Procedencia'</script>";

		}
	}else{
		echo "<script>window.location = 'index.php?p=$from&msg=Error de Procedencia'</script>";
	}
	//Envio de correos
	
	
	
	//Redirect porque los headers ya han sido enviados por index.php
	
}

?>