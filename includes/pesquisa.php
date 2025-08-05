<?php
// Inclui o arquivo de conexão com o banco de dados
include("conexao.php");

$itens_por_pagina = 8;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_atual < 1) {
    $pagina_atual = 1;
}
$offset = ($pagina_atual - 1) * $itens_por_pagina;

// ===================================================================

$clausula_where = "";
$where_params = [];
$types = "";

// Verifica se há uma busca por texto
if (!empty($_GET["consulta"])) {
    $consulta = $_GET["consulta"];
    $termo_busca = "%" . strtoupper($consulta) . "%";
    $clausula_where = "WHERE pr.descricao LIKE ?";
    $where_params[] = $termo_busca;
    $types .= "s";
}
// Senão, verifica se há um filtro por subcategoria
else if (!empty($_GET["subCategoria"])) {
    $subCategoria = (int)$_GET["subCategoria"];
    $clausula_where = "WHERE pr.id_subcategoria = ?";
    $where_params[] = $subCategoria;
    $types .= "i";
}

// ===================================================================

$clausula_having = ""; // Inicia a cláusula HAVING vazia
$having_conditions = []; // Array para as condições do HAVING
$having_params = []; // Array para os parâmetros do HAVING
$having_types = ""; // String para os tipos do HAVING

// Verifica filtro de valor mínimo
if (!empty($_GET["valor_min"]) && is_numeric($_GET["valor_min"])) {
    $valor_min = (float)$_GET["valor_min"];
    $having_conditions[] = "valor_final >= ?";
    $having_params[] = $valor_min;
    $having_types .= "d";
}

// Verifica filtro de valor máximo
if (!empty($_GET["valor_max"]) && is_numeric($_GET["valor_max"])) {
    $valor_max = (float)$_GET["valor_max"];
    $having_conditions[] = "valor_final <= ?";
    $having_params[] = $valor_max;
    $having_types .= "d";
}

// Monta a cláusula HAVING se houver condições
if (!empty($having_conditions)) {
    $clausula_having = "HAVING " . implode(" AND ", $having_conditions);
}

// ===================================================================
// Consulta para contar o TOTAL de produtos (respeitando todos os filtros)

// LINHA CORRIGIDA: Troca de COUNT(pr.id) por COUNT(*)
$sql_total = "SELECT COUNT(*) as total FROM (
                SELECT 
                    pr.id, 
                    COALESCE((pr.valor - (pr.valor * pro.desconto)), pr.valor) AS valor_final
                FROM 
                    tb_produtos pr
                LEFT JOIN 
                    tb_produto_pro pro ON pr.id = pro.id_produto
                {$clausula_where}
                {$clausula_having}
              ) AS subquery";

$stmt_total = mysqli_prepare($conexao, $sql_total);
$all_params = array_merge($where_params, $having_params);
$all_types = $types . $having_types;

if (!empty($all_params)) {
    mysqli_stmt_bind_param($stmt_total, $all_types, ...$all_params);
}


mysqli_stmt_execute($stmt_total);
$resultado_total = mysqli_stmt_get_result($stmt_total);
$total_produtos = mysqli_fetch_assoc($resultado_total)['total'];
$total_paginas = ceil($total_produtos / $itens_por_pagina);

// ===================================================================
// Consulta para buscar os produtos da PÁGINA ATUAL
$sql_pagina = "SELECT 
                    pr.id, 
                    pr.descricao, 
                    pr.valor AS valor_original, 
                    pr.estoque,
                    (pr.valor - (pr.valor * pro.desconto)) as valor_promocional,
                    pro.desconto,
                    COALESCE((pr.valor - (pr.valor * pro.desconto)), pr.valor) AS valor_final
                FROM 
                    tb_produtos pr
                LEFT JOIN 
                    tb_produto_pro pro ON pr.id = pro.id_produto
                {$clausula_where}
                {$clausula_having}
                ORDER BY 
                    pr.descricao
                LIMIT ? OFFSET ?";

$stmt_pagina = mysqli_prepare($conexao, $sql_pagina);

// Adiciona os parâmetros de paginação (LIMIT e OFFSET)
$pagination_params = [$itens_por_pagina, $offset];
$pagination_types = "ii";
$final_params = array_merge($all_params, $pagination_params);
$final_types = $all_types . $pagination_types;

mysqli_stmt_bind_param($stmt_pagina, $final_types, ...$final_params);
mysqli_stmt_execute($stmt_pagina);
$pesquisa = mysqli_stmt_get_result($stmt_pagina);

if (!$pesquisa) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

// Busca todos os produtos da página atual
$produtos = mysqli_fetch_all($pesquisa, MYSQLI_ASSOC);

// Ao final, as variáveis $produtos, $total_paginas, e $pagina_atual estão prontas.
?>