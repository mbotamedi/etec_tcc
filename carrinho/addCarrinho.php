<?php
session_start();
include("../includes/conexao.php");

// 1. Validar se o ID do produto foi recebido.
if (!isset($_GET['id_produto'])) {
    header("Location: ../php/index.php");
    exit;
}

$id_produto = intval($_GET['id_produto']);
$qtd = isset($_GET["qtd"]) && intval($_GET["qtd"]) > 0 ? intval($_GET["qtd"]) : 1;

// 2. Determina a página de origem para decidir se aplica o desconto.
$pagina_origem = isset($_SERVER['HTTP_REFERER']) ? basename($_SERVER['HTTP_REFERER']) : '';
$aplicar_desconto = ($pagina_origem == 'index.php');

// 3. Monta a consulta SQL baseada na página de origem.
if ($aplicar_desconto) {
    // Se veio da index.php, verifica se há promoção individual.
    $query = "
        SELECT 
            p.id, p.descricao, p.estoque, p.imagem,
            IF(pro.desconto IS NOT NULL, p.valor - (p.valor * pro.desconto), p.valor) AS valor_final
        FROM 
            tb_produtos p
        LEFT JOIN 
            tb_produto_pro pro ON p.id = pro.id_produto
        WHERE 
            p.id = $id_produto
    ";
} else {
    // Se veio de qualquer outra página (como produtos.php), pega o preço normal.
    $query = "SELECT id, descricao, valor AS valor_final, estoque, imagem FROM tb_produtos WHERE id = $id_produto";
}

$result_produto = mysqli_query($conexao, $query);

// 4. Procede apenas se o produto foi encontrado.
if ($result_produto && mysqli_num_rows($result_produto) > 0) {
    $produto_data = mysqli_fetch_assoc($result_produto);
    
    // Define o valor do produto que vai para o carrinho.
    $produto_data['valor'] = $produto_data['valor_final'];
    unset($produto_data['valor_final']);

    if (!isset($_SESSION["carrinho"])) {
        $_SESSION["carrinho"] = array();
    }

    $produto_existe_key = null;
    // Verifica se um item idêntico (mesmo ID e mesmo PREÇO) já está no carrinho.
    foreach ($_SESSION["carrinho"] as $key => $item) {
        if ($item['id'] == $id_produto && $item['valor'] == $produto_data['valor'] && !isset($item['id_promocao_origem'])) {
            $produto_existe_key = $key;
            break;
        }
    }

    // Adiciona como novo item ou soma a quantidade.
    if ($produto_existe_key !== null) {
        $_SESSION["carrinho"][$produto_existe_key]['qtd'] += $qtd;
    } else {
        $produto_data['qtd'] = $qtd;
        $_SESSION["carrinho"][] = $produto_data;
    }
}

// 5. Redireciona de volta para a página de origem.
$url_retorno = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../php/index.php';
header("Location: $url_retorno?openCart=true");
exit;
?>