<?php
// verifcar_status.php
header('Content-Type: application/json');
require_once '../includes/conexao.php';

// 1. Pega o ID do pedido da URL e valida
$id_pedido = isset($_GET['id_pedido']) ? (int)$_GET['id_pedido'] : 0;

if ($id_pedido <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID do pedido inválido']);
    exit;
}

// 2. Consulta o banco para pegar o status mais recente do pagamento para este pedido
// Usamos LEFT JOIN para funcionar mesmo que a linha em tb_payments ainda não exista
// Usamos ORDER BY e LIMIT 1 para pegar a tentativa de pagamento mais recente, caso haja mais de uma.
$sql = "SELECT status FROM tb_payments WHERE id_pedidos = ? ORDER BY id DESC LIMIT 1";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_pedido);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$payment = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// 3. Determina o status a ser retornado
$status_final = 'PENDING'; // Status padrão se nada for encontrado

if ($payment) {
    $status_final = $payment['status'];
}

// 4. Retorna o status como um JSON
echo json_encode(['status' => $status_final]);
?>