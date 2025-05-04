<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    echo json_encode(['error' => 'Acesso negado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_endereco = isset($_POST['id_endereco']) ? (int)$_POST['id_endereco'] : 0;
    $id_cliente = $_SESSION['usuario']['id'];

    if ($id_endereco <= 0) {
        echo json_encode(['error' => 'ID de endereço inválido']);
        exit;
    }

    // Verificar se o endereço pertence ao cliente
    $query_check = "SELECT id FROM tb_cliente_endereco WHERE id = '$id_endereco' AND id_cliente = '$id_cliente'";
    $result_check = mysqli_query($conexao, $query_check);

    if (mysqli_num_rows($result_check) === 0) {
        echo json_encode(['error' => 'Endereço não encontrado ou não pertence ao cliente']);
        exit;
    }

    // Excluir o endereço
    $query_delete = "DELETE FROM tb_cliente_endereco WHERE id = '$id_endereco'";
    if (mysqli_query($conexao, $query_delete)) {
        echo json_encode(['success' => 'Endereço excluído com sucesso']);
    } else {
        echo json_encode(['error' => 'Erro ao excluir endereço: ' . mysqli_error($conexao)]);
    }
} else {
    echo json_encode(['error' => 'Método inválido']);
}

mysqli_close($conexao);
?>