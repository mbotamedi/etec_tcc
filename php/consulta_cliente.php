<?php
session_start();
include("../includes/conexao.php");

$email = $_POST["email"];
$senha = $_POST["senha"];

$listar = mysqli_query($conexao, "SELECT * FROM tb_usuarios WHERE email = '$email'");

// Verifica se o e-mail existe no banco
if (mysqli_num_rows($listar) > 0) {
    // Se o e-mail existir, verifica a senha
    $row = mysqli_fetch_assoc($listar);
    if ($senha == $row['senha']) {
        // Armazena os dados do usuário na sessão
        $_SESSION['usuario'] = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'email' => $row['email']
        );
        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../php/cadastro.php");  // Se a senha estiver incorreta
        exit; // Important to prevent further execution
    }
} else {
    //echo "negativo";  // Se o e-mail não existir no banco
    header("Location: ../php/cadastro.php");
    exit;
}
