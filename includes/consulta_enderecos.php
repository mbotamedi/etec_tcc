<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include("conexao.php");

// Verificar se a conexão foi estabelecida
if (!$conexao) {
    echo json_encode(['error' => 'Erro de conexão com o banco de dados']);
    exit();
}

// Verificar se o usuário está logado e é cliente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    echo json_encode(['error' => 'Acesso negado']);
    exit();
}

$id_cliente = mysqli_real_escape_string($conexao, $_SESSION['usuario']['id']);

$query = "SELECT 
            e.id, e.descricao, e.endereco, e.numero, e.complemento, e.bairro, e.cep,
            c.nome_cidade, c.sigla_estado
          FROM 
            tb_cliente_endereco e
          LEFT JOIN 
            tb_cidades c ON e.id_cidade = c.codigo_cidade
          WHERE 
            e.id_cliente = '$id_cliente'";

$stmt = mysqli_query($conexao, $query);

// Verificar se a consulta foi bem-sucedida
if (!$stmt) {
    echo json_encode(['error' => 'Erro na consulta: ' . mysqli_error($conexao)]);
    exit();
}

$enderecos = [];
while ($row = mysqli_fetch_assoc($stmt)) {
    $enderecos[] = $row;
}

echo json_encode(['enderecos' => $enderecos], JSON_UNESCAPED_UNICODE);
mysqli_close($conexao);
?>