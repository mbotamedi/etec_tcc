<?php
session_start();
include("conexao.php");

// Garante que o Content-Type seja application/json
header('Content-Type: application/json');

// Desativa exibição de erros para evitar saída HTML
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Verifica se o usuário está logado como cliente
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

    // Verificar se o endereço está associado a pedidos
    $query_pedidos = "SELECT COUNT(*) as total FROM tb_pedidos WHERE id_endereco = '$id_endereco'";
    $result_pedidos = mysqli_query($conexao, $query_pedidos);
    $row = mysqli_fetch_assoc($result_pedidos);

    if ($row['total'] > 0) {
        echo json_encode(['error' => 'Este endereço não pode ser excluído, pois está associado a um ou mais pedidos.']);
        exit;
    }

    // Excluir o endereço
    $query_delete = "DELETE FROM tb_cliente_endereco WHERE id = '$id_endereco'";
    if (mysqli_query($conexao, $query_delete)) {
        echo json_encode(['success' => 'Endereço excluído com sucesso']);
    } else {
        // Evita exibir erro detalhado do MySQL
        echo json_encode(['error' => 'Ocorreu um erro ao excluir o endereço. Tente novamente mais tarde.']);
    }
} else {
    echo json_encode(['error' => 'Método inválido']);
}

mysqli_close($conexao);
?>