<?php
// verificar_status_caixa.php
include '../../../includes/conexao.php';

// Verifica se existe um caixa aberto (sem data_fechamento)
$sql = "SELECT id_caixa, data_abertura, valor_abertura FROM tb_caixa WHERE data_fechamento IS NULL ORDER BY id_caixa DESC LIMIT 1";
$result = $conexao->query($sql);

header('Content-Type: application/json');

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        'caixa_aberto' => true,
        'id_caixa' => $row['id_caixa'],
        'data_abertura' => $row['data_abertura'],
        'valor_abertura' => $row['valor_abertura']
    ]);
} else {
    echo json_encode([
        'caixa_aberto' => false
    ]);
}

$conexao->close();
?>