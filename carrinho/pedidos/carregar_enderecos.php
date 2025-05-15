<?php
session_start();
include("../../includes/conexao.php");

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    echo json_encode(['error' => 'Acesso negado']);
    exit;
}

$id_cliente = $_SESSION['usuario']['id'];

$query = "SELECT e.*, c.nome_cidade, c.sigla_estado 
          FROM tb_cliente_endereco e 
          LEFT JOIN tb_cidades c ON e.id_cidade = c.codigo_cidade 
          WHERE e.id_cliente = '$id_cliente'";
$result = mysqli_query($conexao, $query);

$enderecos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $enderecos[] = $row;
}

echo json_encode($enderecos);
mysqli_close($conexao);
?>