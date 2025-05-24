<?php

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

try {

	$mail->isSMTP();
	$mail->Host       = 'smtp.gmail.com';
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	$mail->Port       = 465;

	$mail->SMTPAuth   = true;
	$mail->Username   = 'tailabol036@gmail.com';
	$mail->Password   = 'swez xazd hwrs ooqn';

	$mail->setFrom($email, $nome);
	$mail->addAddress("tailabol036@gmail.com"); //Email para onde você vai enviar

	$mail->isHTML(true);
	$mail->Subject = 'Contato Efetuado Atraves da Loja ETEC'; //Assunto do Email
	$mail->Body    = "Nome do Remetente: $nome <br>Email: $email <br> Mensagem: $mensagem"; //MEnsagem do Email

	$mail->send();

	if ($mail->send()) {
		if($mail->send()) {
    echo '
    <div id="mensagem-sucesso" style="...">
        Mensagem enviada com sucesso!
    </div>
    <script>
        // Limpa os dados do sessionStorage
        sessionStorage.removeItem("email");
        sessionStorage.removeItem("senha");
        
        // Esconde a mensagem após 3 segundos
        setTimeout(function() {
            document.getElementById("mensagem-sucesso").style.display = "none";
        }, 3000);
    </script>
    ';
}
	}
} catch (Exception $e) {

	echo "A mensagem não pôde ser enviada. Erro do PHPMailer: {$mail->ErrorInfo}";
}
