<?php
// buscar_resumo_caixa.php
include '../../../includes/conexao.php';

header('Content-Type: application/json');

// Pega o último caixa aberto (sem data_fechamento)
$sql = "SELECT id_caixa, data_abertura, valor_abertura FROM tb_caixa WHERE data_fechamento IS NULL ORDER BY id_caixa DESC LIMIT 1";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    $caixa = $result->fetch_assoc();
    $id_caixa = $caixa['id_caixa'];
    
    // Busca movimentações do caixa atual
    $sql_mov = "SELECT 
                    SUM(CASE WHEN tipo = 'ENTRADA' THEN valor ELSE 0 END) AS total_entradas,
                    SUM(CASE WHEN tipo = 'SAIDA' THEN valor ELSE 0 END) AS total_saidas
                FROM tb_movimentacoes_caixa 
                WHERE id_caixa = $id_caixa";
    
    $result_mov = $conexao->query($sql_mov);
    $movimentacoes = $result_mov->fetch_assoc();
    
    // Busca total de vendas PDV
    /*$sql_pdv = "SELECT COALESCE(SUM(valor_total), 0) AS total_pdv
                FROM tb_pedidos 
                WHERE DATE(emissao) = CURDATE() 
                AND tipo_pedido = 'PDV'";
    
    $result_pdv = $conexao->query($sql_pdv);
    
    if ($result_pdv && $result_pdv->num_rows > 0) {
        $pdv = $result_pdv->fetch_assoc();
        $total_pdv = $pdv['total_pdv'];
    } else {
        $total_pdv = 0;
    }*/
    
    $valor_abertura = floatval($caixa['valor_abertura']);
    $total_entradas = floatval($movimentacoes['total_entradas'] ?? 0);
    $total_saidas = floatval($movimentacoes['total_saidas'] ?? 0);
    
    // Calcula o saldo teórico (valor que deveria ter no caixa)
    $subTotal = $valor_abertura + $total_entradas - $total_saidas;
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'id_caixa' => $caixa['id_caixa'],
            'data_abertura' => $caixa['data_abertura'],
            'valor_abertura' => $valor_abertura,
            /*'total_pdv' => $total_pdv,*/
            'total_entradas' => $total_entradas,
            'total_saidas' => $total_saidas,
            'subTotal' => $subTotal
        ]
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Nenhum caixa aberto encontrado.'
    ]);
}

$conexao->close();
?>