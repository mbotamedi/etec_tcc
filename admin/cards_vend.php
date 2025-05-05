<?php
include('../includes/conexao.php');

// Query para contar o número de pedidos e somar o valor total

$query = "SELECT Count(Distinct  id_cliente) as cliente, COUNT(id) as total_pedidos, SUM(valor_total) as valor_total FROM tb_pedidos";

$resultado = mysqli_query($conexao, $query);

// Verifica se a consulta foi executada com sucesso
if ($resultado) {
    $dados = mysqli_fetch_assoc($resultado);
    // Retorna os valores como um array para uso posterior
    $total_pedidos = $dados['total_pedidos'];
    $valor_total = $dados['valor_total'];
    $cliente = $dados ['cliente'];
} else {
    // Em caso de erro, define valores padrão
    $total_pedidos = 0;
    $valor_total = 0;
    $cliente = 0;
}

// Query para somar a quantidade de itens vendidos
$query_itens = "SELECT SUM(qtd) AS qtd FROM tb_pedidos_itens";
$resultado_itens = mysqli_query($conexao, $query_itens);

// Verifica se a consulta de itens foi executada com sucesso
if ($resultado_itens) {
    $dados_itens = mysqli_fetch_assoc($resultado_itens);
    $qtd = $dados_itens['qtd'] ?: 0; // Usa 0 se o resultado for NULL
} else {
    $qtd = 0;
}

// Fecha a conexão (opcional, dependendo da sua implementação)
mysqli_close($conexao);
?>