<?php
session_start();

// Verifica se o usuário está logado como cliente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
include("../../includes/conexao.php");

// Obtém o ID do cliente da sessão
$id_cliente = $_SESSION['usuario']['id'];

// Recebe os dados do formulário
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
$cnpj_cpf = mysqli_real_escape_string($conexao, $_POST['cnpj_cpf']);
$email = mysqli_real_escape_string($conexao, $_POST['email']);
$telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);

// Validação básica
if (empty($nome) || empty($cnpj_cpf) || empty($email) || empty($telefone)) {
    die("Todos os campos são obrigatórios.");
}

// Atualiza os dados no banco
$query_update = "UPDATE tb_clientes SET 
                nome = '$nome', 
                cnpj_cpf = '$cnpj_cpf', 
                email = '$email', 
                telefone = '$telefone' 
                WHERE id = '$id_cliente'";

if (mysqli_query($conexao, $query_update)) {
    // Atualiza os dados na sessão
    $_SESSION['usuario']['nome'] = $nome;
    // Redireciona para a página de pedidos do cliente
    
    header("Location:../../carrinho/pedidos/pedidos_cliente.php");
} else {
    die("Erro ao atualizar os dados: " . mysqli_error($conexao));
}
?>