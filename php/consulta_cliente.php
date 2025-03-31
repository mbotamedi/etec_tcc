<?php
include("../includes/conexao.php");

$email = $_POST["email"];
$senha = $_POST["senha"];

$listar = mysqli_query($conexao, "select * from tb_usuarios where email = '$email' and senha= '$senha'");

// Verifica se o e-mail existe no banco
if ($listar->num_rows > 0) {
    // Se o e-mail existir, verifica a senha
    $row = $result->fetch_assoc();
    if ($senha === $row['senha']) {
        echo "Logado";  // Se a senha for correta
    } else {
        header("Location:/cadadtro.php");  // Se a senha estiver incorreta
    }
} else {
    echo "negativo";  // Se o e-mail não existir no banco
}
