<?php
session_start();
include("../includes/conexao.php");

$email = $_POST["email"];
$senha = $_POST["senha"];

// Verifica na tabela tb_usuarios
$listar_usuarios = mysqli_query($conexao, "SELECT id, nome, email, senha, 'usuario' as tipo FROM tb_usuarios WHERE email = '$email'");

// Verifica na tabela tb_clientes
$listar_clientes = mysqli_query($conexao, "SELECT id, nome, email, senha, 'cliente' as tipo FROM tb_clientes WHERE email = '$email'");

// Verifica se o e-mail existe em tb_usuarios
if (mysqli_num_rows($listar_usuarios) > 0) {
    $row = mysqli_fetch_assoc($listar_usuarios);
    if ($senha == $row['senha']) {
        // Armazena os dados do usuário na sessão
        $_SESSION['usuario'] = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'email' => $row['email'],
            'tipo' => $row['tipo']
        );
        // Verifica se há uma URL de retorno
        $url_retorno = isset($_SESSION['url_retorno']) ? $_SESSION['url_retorno'] : '../index.php';
        unset($_SESSION['url_retorno']); // Limpa a URL de retorno
        
        // Redireciona para uma página intermediária que configura o sessionStorage
        header("Location: set_session_storage.php?id=" . $row['id'] . "&nome=" . urlencode($row['nome']) . "&email=" . urlencode($row['email']) . "&tipo=" . $row['tipo']);
        exit;
    } else {
        header("Location: ../php/cadastro.php"); // Senha incorreta
        exit;
    }
}
// Verifica se o e-mail existe em tb_clientes
elseif (mysqli_num_rows($listar_clientes) > 0) {
    $row = mysqli_fetch_assoc($listar_clientes);
    if ($senha == $row['senha']) {
        // Armazena os dados do cliente na sessão
        $_SESSION['usuario'] = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'email' => $row['email'],
            'tipo' => $row['tipo']
        );
        // Verifica se há uma URL de retorno
        $url_retorno = isset($_SESSION['url_retorno']) ? $_SESSION['url_retorno'] : '../index.php';
        unset($_SESSION['url_retorno']); // Limpa a URL de retorno
        
        // Redireciona para uma página intermediária que configura o sessionStorage
        header("Location: set_session_storage.php?id=" . $row['id'] . "&nome=" . urlencode($row['nome']) . "&email=" . urlencode($row['email']) . "&tipo=" . $row['tipo']);
        exit;
    } else {
        header("Location: ../php/cadastro.php"); // Senha incorreta
        exit;
    }
} else {
    header("Location: ../php/cadastro.php"); // E-mail não encontrado
    exit;
}
?>