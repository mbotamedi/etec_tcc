<?php
// fechar_caixa.php
include '../../../includes/conexao.php';

// Configurar exibição de erros para depuração (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Recebe os dados do formulário
$valor_fechamento = $_POST['valor_fechamento'] ?? null;
$obs = $_POST['observacoes'] ?? '';
$data = date('Y-m-d H:i:s');

header('Content-Type: application/json');

// Log dos dados recebidos
error_log("POST Data Recebido: " . print_r($_POST, true));

// Valida o valor de fechamento
if (!isset($valor_fechamento) || $valor_fechamento === '') {
    error_log("Erro: valor_fechamento não fornecido.");
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Valor de fechamento não fornecido.'
    ]);
    exit;
}

// Remove apenas caracteres não numéricos e o separador de milhar, mantendo o decimal
$valor_fechamento = preg_replace('/[^0-9.]/', '', $valor_fechamento); // Remove tudo exceto números e ponto
if (!is_numeric($valor_fechamento) || $valor_fechamento <= 0) {
    error_log("Erro: valor_fechamento inválido - valor recebido: " . var_export($valor_fechamento, true));
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Valor de fechamento inválido. Use um número positivo.'
    ]);
    exit;
}

$valor_fechamento = mysqli_real_escape_string($conexao, $valor_fechamento);
$obs = mysqli_real_escape_string($conexao, $obs);

// Log após sanitização
error_log("Valor_fechamento após sanitização: " . $valor_fechamento);

// Verifica a conexão
if ($conexao->connect_error) {
    error_log("Erro de conexão: " . $conexao->connect_error);
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Erro de conexão com o banco de dados: ' . $conexao->connect_error
    ]);
    exit;
}

// Busca o último caixa aberto
$sql_caixa = "SELECT id_caixa, valor_abertura FROM tb_caixa WHERE data_fechamento IS NULL ORDER BY id_caixa DESC LIMIT 1";
$result_caixa = $conexao->query($sql_caixa);

if (!$result_caixa) {
    error_log("Erro na query de caixa: " . $conexao->error);
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Erro ao buscar caixa aberto: ' . $conexao->error
    ]);
    exit;
}

if ($result_caixa->num_rows > 0) {
    $caixa = $result_caixa->fetch_assoc();
    $id_caixa = $caixa['id_caixa'];
    $valor_abertura = floatval($caixa['valor_abertura']);

    // Busca movimentações do caixa atual
    $sql_mov = "SELECT 
                    SUM(CASE WHEN tipo = 'ENTRADA' THEN valor ELSE 0 END) AS total_entradas,
                    SUM(CASE WHEN tipo = 'SAIDA' THEN valor ELSE 0 END) AS total_saidas
                FROM tb_movimentacoes_caixa 
                WHERE id_caixa = $id_caixa";
    $result_mov = $conexao->query($sql_mov);
    if (!$result_mov) {
        error_log("Erro na query de movimentações: " . $conexao->error);
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Erro ao buscar movimentações: ' . $conexao->error
        ]);
        exit;
    }
    $movimentacoes = $result_mov->fetch_assoc();

    // Busca total de vendas PDV (comentar se não for necessário)
    $total_pdv = 0; // Temporariamente desativado
    /*
    $sql_pdv = "SELECT COALESCE(SUM(valor_total), 0) AS total_pdv
                FROM tb_pedidos
                WHERE DATE(data_venda) = CURDATE()";
    $result_pdv = $conexao->query($sql_pdv);
    if (!$result_pdv) {
        error_log("Erro na query de PDV: " . $conexao->error);
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Erro ao buscar vendas PDV: ' . $conexao->error
        ]);
        exit;
    }
    $total_pdv = $result_pdv->num_rows > 0 ? floatval($result_pdv->fetch_assoc()['total_pdv']) : 0;
    */

    // Calcula o subTotal
    $total_entradas = floatval($movimentacoes['total_entradas'] ?? 0);
    $total_saidas = floatval($movimentacoes['total_saidas'] ?? 0);
    $subTotal = $valor_abertura + $total_entradas - $total_saidas;

    // Calcula a diferença
    $diferenca = floatval($valor_fechamento) - $subTotal;

    // Log dos cálculos
    error_log("Calculado: id_caixa=$id_caixa, valor_abertura=$valor_abertura, total_entradas=$total_entradas, total_pdv=$total_pdv, total_saidas=$total_saidas, subTotal=$subTotal, diferenca=$diferenca");

    // Atualiza o registro do caixa
    $sql = "UPDATE tb_caixa SET 
                data_fechamento = '$data', 
                valor_fechamento = '$valor_fechamento', 
                observacoes = '$obs',
                diferenca = '$diferenca'
            WHERE id_caixa = $id_caixa";

    if ($conexao->query($sql) === TRUE) {
        error_log("Caixa fechado com sucesso: id_caixa=$id_caixa");
        echo json_encode([
            'status' => 'success',
            'message' => '✅ Caixa fechado com sucesso.',
            'diferenca' => $diferenca
        ]);
    } else {
        error_log("Erro na query de atualização: " . $conexao->error);
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Erro ao fechar caixa: ' . $conexao->error
        ]);
    }
} else {
    error_log("Nenhum caixa aberto encontrado.");
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Nenhum caixa aberto encontrado.'
    ]);
}

$conexao->close();
?>