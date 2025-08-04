<?php
// Inclui o arquivo de conexão com o banco de dados
include("conexao.php");

// ===================================================================
// PASSO 1: DEFINIR VARIÁVEIS DE PAGINAÇÃO
// ===================================================================
$itens_por_pagina = 8;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_atual < 1) {
    $pagina_atual = 1;
}
$offset = ($pagina_atual - 1) * $itens_por_pagina;

// ===================================================================
// PASSO 2: PROCESSAR A CONSULTA DE BUSCA E FILTROS
// ===================================================================
$clausula_where = ""; // Inicia a cláusula WHERE vazia
$params = []; // Array para guardar os parâmetros para o bind
$types = "";  // String para os tipos de dados dos parâmetros ('s' para string, 'i' para integer)

// Verifica se há uma busca por texto
if (!empty($_GET["consulta"])) {
    $consulta = $_GET["consulta"];
    $termo_busca = "%" . strtoupper($consulta) . "%";
    $clausula_where = "WHERE pr.descricao LIKE ?";

    // Adiciona o parâmetro e seu tipo
    $params[] = $termo_busca;
    $types .= "s";

    // Senão, verifica se há um filtro por subcategoria
} else if (!empty($_GET["subCategoria"])) {
    $subCategoria = (int)$_GET["subCategoria"]; // Converte para inteiro por segurança
    $clausula_where = "WHERE pr.id_subcategoria = ?";

    // Adiciona o parâmetro e seu tipo
    $params[] = $subCategoria;
    $types .= "i";
}

// ===================================================================
// PASSO 3: CONTAR O TOTAL DE ITENS PARA CALCULAR AS PÁGINAS
// ===================================================================
$sql_total = "SELECT COUNT(pr.id) as total FROM tb_produtos pr {$clausula_where}";
$stmt_total = mysqli_prepare($conexao, $sql_total);

// Se houver parâmetros (busca ou filtro), faz o bind
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt_total, $types, ...$params);
}

mysqli_stmt_execute($stmt_total);
$resultado_total = mysqli_stmt_get_result($stmt_total);
$total_produtos = mysqli_fetch_assoc($resultado_total)['total'];
$total_paginas = ceil($total_produtos / $itens_por_pagina);

// ===================================================================
// PASSO 4: BUSCAR OS PRODUTOS PARA A PÁGINA ATUAL
// ===================================================================
$sql_pagina = "SELECT 
                    pr.id, 
                    pr.descricao, 
                    pr.valor AS valor_original, 
                    pr.estoque,
                    (pr.valor - (pr.valor * pro.desconto)) as valor_promocional,
                    pro.desconto
                FROM 
                    tb_produtos pr
                LEFT JOIN 
                    tb_produto_pro pro ON pr.id = pro.id_produto
                {$clausula_where}
                ORDER BY 
                    pr.descricao
                LIMIT ? OFFSET ?"; // Adiciona LIMIT e OFFSET

// Adiciona os parâmetros de paginação (LIMIT e OFFSET) ao array de parâmetros
$params[] = $itens_por_pagina;
$params[] = $offset;
$types .= "ii"; // Adiciona os tipos para LIMIT e OFFSET (ambos inteiros)

$stmt_pagina = mysqli_prepare($conexao, $sql_pagina);

// Faz o bind de TODOS os parâmetros de uma só vez (busca/filtro + paginação)
// O operador '...' (splat) desempacota o array $params nos argumentos da função
mysqli_stmt_bind_param($stmt_pagina, $types, ...$params);

// Executa a consulta
mysqli_stmt_execute($stmt_pagina);
$pesquisa = mysqli_stmt_get_result($stmt_pagina);

if (!$pesquisa) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

// Busca todos os produtos da página atual
$produtos = mysqli_fetch_all($pesquisa, MYSQLI_ASSOC);

// Ao final, as variáveis $produtos, $total_paginas, e $pagina_atual estão prontas.
?>