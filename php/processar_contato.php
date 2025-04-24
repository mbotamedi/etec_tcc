<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $assunto = filter_input(INPUT_POST, 'assunto', FILTER_SANITIZE_STRING);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

    // Email de destino (substitua pelo email desejado)
    $para = "tailabol036@gmail.com";

    // Monta o corpo do email
    $corpo_email = "Nome: " . $nome . "\n";
    $corpo_email .= "Email: " . $email . "\n";
    $corpo_email .= "Assunto: " . $assunto . "\n\n";
    $corpo_email .= "Mensagem:\n" . $mensagem;

    // Cabeçalhos do email
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Tenta enviar o email
    if(mail($para, "Contato do Site: " . $assunto, $corpo_email, $headers)) {
        echo "<script>
                alert('Mensagem enviada com sucesso!');
                window.location.href = 'faleConosco.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao enviar mensagem. Por favor, tente novamente.');
                window.location.href = 'faleConosco.php';
              </script>";
    }
} else {
    // Se alguém tentar acessar diretamente este arquivo
    header("Location: faleConosco.php");
    exit;
}
?>