<?php
// registrar_movimento.php
include '../../../includes/conexao.php';

$tipo = mysqli_real_escape_string($conexao, $_POST['tipo']);
$valor = mysqli_real_escape_string($conexao, $_POST['valor']);
$descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
$data = date('Y-m-d H:i:s');

header('Content-Type: application/json');

// Pega o último caixa aberto (sem data_fechamento)
$result = $conexao->query("SELECT id_caixa FROM tb_caixa WHERE data_fechamento IS NULL ORDER BY id_caixa DESC LIMIT 1");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_caixa = $row['id_caixa'];

    $sql = "INSERT INTO tb_movimentacoes_caixa (id_caixa, tipo, descricao, valor, data_movimento)
            VALUES ($id_caixa, '$tipo', '$descricao', $valor, '$data')";

    if ($conexao->query($sql) === TRUE) {
        echo json_encode([
            'status' => 'success',
            'message' => '✅ Movimento registrado com sucesso.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Erro ao registrar movimento: ' . $conexao->error
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Nenhum caixa aberto encontrado.'
    ]);
}

$conexao->close();
?>