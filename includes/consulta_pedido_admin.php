<?php
include('conexao.php');

// Verifica se está na página de detalhes
$mostrar_detalhes = isset($_GET['pg']) && $_GET['pg'] === 'detalhes' && isset($_GET['id_pedido']);

if (!$mostrar_detalhes) {
    // Consulta para todos os pedidos do sistema com detalhes agregados por pedido
    $query = "
        SELECT 
            p.id AS id_pedido,
            c.nome AS cliente,
            p.emissao,
            p.valor_total,
            p.tipo_entrega,
            e.endereco,
            e.numero,
            e.bairro,
            e.cep,
            cid.nome_cidade,
            cid.sigla_estado,
            SUM(pi.qtd) AS quantidade_total
        FROM tb_pedidos p
        LEFT JOIN tb_clientes c ON p.id_cliente = c.id
        LEFT JOIN tb_cliente_endereco e ON p.id_endereco = e.id
        LEFT JOIN tb_cidades cid ON e.id_cidade = cid.codigo_cidade
        LEFT JOIN tb_pedidos_itens pi ON p.id = pi.id_pedidos
        GROUP BY p.id, c.nome, p.emissao, p.valor_total, p.tipo_entrega, e.endereco, e.numero, e.bairro, e.cep, cid.nome_cidade, cid.sigla_estado
        ORDER BY p.emissao DESC
    ";
    $resultado = mysqli_query($conexao, $query);

    // Verifica se a consulta foi bem-sucedida
    if (!$resultado) {
        $erro = "Erro na consulta: " . mysqli_error($conexao);
    } else {
        // Array para armazenar detalhes dos pedidos para os modais
        $pedidos_detalhes = [];
        while ($row = mysqli_fetch_assoc($resultado)) {
            $pedidos_detalhes[$row['id_pedido']] = $row;

            // Consulta para os itens do pedido
            $id_pedido = mysqli_real_escape_string($conexao, $row['id_pedido']);
            $query_itens = "
                SELECT 
                    pi.*, 
                    pr.descricao, pr.imagem1
                FROM 
                    tb_pedidos_itens pi
                JOIN 
                    tb_produtos pr ON pi.id_produtos = pr.id
                WHERE 
                    pi.id_pedidos = '$id_pedido'";
            $resultado_itens = mysqli_query($conexao, $query_itens);

            $itens = [];
            if ($resultado_itens) {
                while ($item = mysqli_fetch_assoc($resultado_itens)) {
                    $itens[] = $item;
                }
            }
            $pedidos_detalhes[$row['id_pedido']]['itens'] = $itens;
        }
        mysqli_data_seek($resultado, 0); // Resetar o ponteiro do resultado
    }
} else {
    // Lógica para exibir detalhes do pedido (mantida para compatibilidade)
    $id_pedido = mysqli_real_escape_string($conexao, $_GET['id_pedido']);

    // Consulta para o pedido específico
    $query_pedido = "
        SELECT 
            p.*, 
            e.endereco, e.numero, e.descricao, e.complemento,
            e.bairro, e.cep,
            c.nome_cidade, c.sigla_estado,
            cl.nome AS cliente
        FROM 
            tb_pedidos p
        LEFT JOIN 
            tb_cliente_endereco e ON p.id_endereco = e.id
        LEFT JOIN 
            tb_cidades c ON e.id_cidade = c.codigo_cidade
        LEFT JOIN 
            tb_clientes cl ON p.id_cliente = cl.id
        WHERE 
            p.id = '$id_pedido'";
    $resultado_pedido = mysqli_query($conexao, $query_pedido);

    if (!$resultado_pedido || mysqli_num_rows($resultado_pedido) == 0) {
        $erro = "Pedido não encontrado.";
    } else {
        $pedido = mysqli_fetch_assoc($resultado_pedido);

        // Consulta para os itens do pedido
        $query_itens = "
            SELECT 
                pi.*, 
                pr.descricao, pr.imagem1
            FROM 
                tb_pedidos_itens pi
            JOIN 
                tb_produtos pr ON pi.id_produtos = pr.id
            WHERE 
                pi.id_pedidos = '$id_pedido'";
        $resultado_itens = mysqli_query($conexao, $query_itens);

        if (!$resultado_itens) {
            $erro = "Erro na consulta dos itens: " . mysqli_error($conexao);
        } else {
            $itens = [];
            while ($row = mysqli_fetch_assoc($resultado_itens)) {
                $itens[] = $row;
            }
        }
    }
}
?>
