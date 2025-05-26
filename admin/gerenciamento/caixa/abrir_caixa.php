<?php
// abrir_caixa.php
include '../../../includes/conexao.php'; // Inclui o arquivo com a conexão ao banco de dados

// Recebe o valor de abertura do formulário
$valor = mysqli_real_escape_string($conexao, $_POST['valor_abertura']);

// Define a data e hora atuais
$data = date('Y-m-d H:i:s');

// Insere o registro de abertura de caixa no banco
$sql = "INSERT INTO tb_caixa (data_abertura, valor_abertura) VALUES ('$data', '$valor')";

// Executa a query e retorna JSON
header('Content-Type: application/json');
if ($conexao->query($sql) === TRUE) {
    echo json_encode([
        'status' => 'success',
        'message' => '✅ Caixa aberto com sucesso.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Erro ao abrir caixa: ' . $conexao->error
    ]);
}

// Fecha a conexão
$conexao->close();
?>