<?php
    include("conexao.php");


$id_cliente = $_SESSION['usuario']['id'];

// Consulta os dados do cliente
$query_cliente = "SELECT * FROM tb_clientes WHERE id = '$id_cliente'";
$resultado_cliente = mysqli_query($conexao, $query_cliente);

if (!$resultado_cliente || mysqli_num_rows($resultado_cliente) == 0) {
    die("Erro ao carregar dados do cliente.");
}

$cliente = mysqli_fetch_assoc($resultado_cliente);

// Consulta os pedidos do cliente
$query_pedidos = "SELECT 
                    p.id, 
                    p.emissao, 
                    p.valor_total, 
                    p.tipo_entrega,
                    COUNT(pi.id) as total_itens
                  FROM 
                    tb_pedidos p
                  LEFT JOIN 
                    tb_pedidos_itens pi ON p.id = pi.id_pedidos
                  WHERE 
                    p.id_cliente = '$id_cliente'
                  GROUP BY 
                    p.id
                  ORDER BY 
                    p.emissao DESC";

$resultado_pedidos = mysqli_query($conexao, $query_pedidos);

// Consulta os endereços do cliente
$query_enderecos = "SELECT 
                      e.descricao,
                      e.numero,
                      e.bairro, 
                      c.nome_cidade, 
                      c.sigla_estado,
                      e.cep
                    FROM 
                      tb_cliente_endereco e
                    JOIN 
                      tb_cidades c ON e.id_cidade = c.codigo_cidade
                    WHERE 
                      e.id_cliente = '$id_cliente'";
$resultado_enderecos = mysqli_query($conexao, $query_enderecos);
$enderecos = mysqli_fetch_all($resultado_enderecos, MYSQLI_ASSOC);
?>