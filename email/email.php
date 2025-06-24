<?php

    $nome     = $_POST["txtnome"];
    $email    = $_POST["txtemail"];
    $mensagem = $_POST["txtmensagem"];
                
        
    

require '../includes/conexao.php';   
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

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
	$mail->Username   = 'seu email';
	$mail->Password   = 'seu password';

	$mail->setFrom('botamedi@gmail.com', 'Nome do Remente');
	$mail->addAddress($email); //Eamil para onde você vai enviar

	$mail->isHTML(true);
	$mail->Subject = 'Mensagem Recebida'; //Assunto do email
	$mail->Body    = 'Olá <b>' .$nome.'</b><br> Nós recebemos o sua Mensagem <br> Em breve entraremos em contato.'; //Mensagem do Email

	$mail->send();
	echo 'Mensagem enviada com sucesso.';
	header("Location: ../php/faleConosco.php");
	

} catch (Exception $e) {

	echo "A mensagem não pôde ser enviada. Erro do PHPMailer: {$mail->ErrorInfo}";

}

$query = "INSERT INTO tb_contato (nome, email, mensagem) VALUES ('$nome', '$email', '$mensagem')";
$mensagem = mysqli_query($conexao, $query);



?>