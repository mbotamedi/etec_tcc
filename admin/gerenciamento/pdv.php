<?php
// Verifica se a sessão não foi iniciada antes de chamar session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../includes/conexao.php'); // Inclui a conexão com o banco de dados

// Verifica se o usuário está logado (simples)
if (!isset($_SESSION['usuario'])) {
    header("Location: ../php/login.php");
    exit;
}

// Inicializa o carrinho na sessão
if (!isset($_SESSION['carrinho_pdv'])) {
    $_SESSION['carrinho_pdv'] = [];
}

// Adiciona produto ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
    error_log("POST recebido: " . print_r($_POST, true)); // Adiciona log para depuração
    $id_produto = $_POST['id_produto'];
    $quantidade = (int)$_POST['quantidade'];

    // Busca o produto
    $query = "SELECT * FROM tb_produtos WHERE id = '$id_produto'";
    $result = mysqli_query($conexao, $query);
    $produto = mysqli_fetch_assoc($result);

    if ($produto && $quantidade > 0 && $produto['estoque'] >= $quantidade) {
        $item = [
            'id' => $produto['id'],
            'descricao' => $produto['descricao'],
            'quantidade' => $quantidade,
            'valor_unitario' => $produto['valor']
        ];
        $_SESSION['carrinho_pdv'][] = $item;

        // Atualiza o estoque (simulação)
        $novo_estoque = $produto['estoque'] - $quantidade;
        $update_query = "UPDATE tb_produtos SET estoque = '$novo_estoque' WHERE id = '$id_produto'";
        mysqli_query($conexao, $update_query);
    }
}

// Exclui produto do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])) {
    $descricao = $_POST['descricao'];

    foreach ($_SESSION['carrinho_pdv'] as $index => $item) {
        if ($item['descricao'] === $descricao) {
            // Restaura o estoque
            $query = "SELECT estoque FROM tb_produtos WHERE id = '{$item['id']}'";
            $result = mysqli_query($conexao, $query);
            $produto = mysqli_fetch_assoc($result);
            $novo_estoque = $produto['estoque'] + $item['quantidade'];
            $update_query = "UPDATE tb_produtos SET estoque = '$novo_estoque' WHERE id = '{$item['id']}'";
            mysqli_query($conexao, $update_query);

            // Remove o item do carrinho
            unset($_SESSION['carrinho_pdv'][$index]);
            $_SESSION['carrinho_pdv'] = array_values($_SESSION['carrinho_pdv']); // Reindexa o array
            break;
        }
    }
}

// Filtra produtos por quantidade mínima (se aplicável)
$min_quantidade = isset($_POST['min_quantidade']) ? (int)$_POST['min_quantidade'] : 0;
$query_produtos = "SELECT id, descricao, valor, estoque FROM tb_produtos WHERE estoque > 0";
if ($min_quantidade > 0) {
    $query_produtos .= " AND estoque >= $min_quantidade";
}
$result_produtos = mysqli_query($conexao, $query_produtos);

// Calcula o total
$total = 0;
foreach ($_SESSION['carrinho_pdv'] as $item) {
    $total += $item['quantidade'] * $item['valor_unitario'];
}

// Finaliza a venda
if (isset($_POST['finalizar'])) {
    //$id_cliente = $_SESSION['usuario']['id'];

    $emissao = date('Y-m-d H:i:s');
    $tipo_entrega = 'retirada';
    $tipo = 'pdv';

    // Insere o pedido
    $query_pedido = "INSERT INTO tb_pedidos (emissao, valor_total, tipo_entrega, tipo_user) VALUES ( '$emissao', '$total', '$tipo_entrega','$tipo')";
    mysqli_query($conexao, $query_pedido);
    $id_pedido = mysqli_insert_id($conexao);

    // Insere os itens
    foreach ($_SESSION['carrinho_pdv'] as $item) {
        $query_item = "INSERT INTO tb_pedidos_itens (id_pedidos, id_produtos, qtd, valor_untiario) VALUES ('$id_pedido', '{$item['id']}', '{$item['quantidade']}', '{$item['valor_unitario']}')";
        mysqli_query($conexao, $query_item);
    }

    // Limpa o carrinho
    $_SESSION['carrinho_pdv'] = [];
    // Exibe mensagem e recarrega
    echo "<script>alert('Venda cancelada com sucesso!'); window.location.href = 'admin.php';</script>";
    exit;
}

// Cancela a venda
if (isset($_POST['cancelar'])) {
    if (!empty($_SESSION['carrinho_pdv'])) {
        foreach ($_SESSION['carrinho_pdv'] as $item) {
            // Sanitiza o ID do produto para evitar injeção SQL
            $id_produto = mysqli_real_escape_string($conexao, $item['id']);
            $quantidade = (int)$item['quantidade'];

            // Busca o estoque atual
            $query = "SELECT estoque FROM tb_produtos WHERE id = '$id_produto'";
            $result = mysqli_query($conexao, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $produto = mysqli_fetch_assoc($result);
                $novo_estoque = $produto['estoque'] + $quantidade;

                // Atualiza o estoque
                $update_query = "UPDATE tb_produtos SET estoque = '$novo_estoque' WHERE id = '$id_produto'";
                if (!mysqli_query($conexao, $update_query)) {
                    error_log("Erro ao atualizar estoque do produto ID $id_produto: " . mysqli_error($conexao));
                }
            } else {
                error_log("Produto ID $id_produto não encontrado no banco de dados.");
            }
        }
    }

    // Limpa o carrinho
    // Limpa o carrinho
    $_SESSION['carrinho_pdv'] = [];
    // Exibe mensagem e redireciona para admin.php
    echo "<script>alert('Venda cancelada com sucesso!'); window.location.href = 'admin.php';</script>";
    // Alternativa: recarregar pdv.php
    // echo "<script>alert('Venda cancelada com sucesso!'); window.location.reload();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDV Simples - Cantina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cupom {
            border: 1px solid #000;
            padding: 15px;
            font-family: monospace;
            height: 100%;
        }

        .cupom h3 {
            text-align: center;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .cupom-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            align-items: center;
        }

        .total {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 10px;
        }

        .btn-excluir {
            font-size: 0.5rem;
            padding: 3px 5px;
        }

        .cantina-label {
            font-weight: bold;
            margin-left: 10px;
        }

        .form-section {
            padding-right: 20px;
            border-right: 1px solid #dee2e6;
        }

        @media (max-width: 768px) {
            .form-section {
                border-right: none;
                padding-right: 0;
                border-bottom: 1px solid #dee2e6;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Ponto de Venda</h2>

        <div class="row">
            <!-- Formulário no lado esquerdo -->
            <div class="col-md-6 form-section">
                <?php include('prod_pdv.php'); ?>
            </div>

            <!-- Cupom no lado direito -->
            <div class="col-md-6">
                <?php if (!empty($_SESSION['carrinho_pdv'])): ?>
                    <div class="cupom">
                        <h3>Cantina Três Irmãos</h3>
                        <div class="cupom-item">
                            <span>Descrição</span>
                            <span>Qtde</span>
                            <span>Preço R$/Un</span>
                            <span>Valor R$</span>
                            <span>Ação</span>
                        </div>
                        <?php foreach ($_SESSION['carrinho_pdv'] as $item): ?>
                            <div class="cupom-item">
                                <span><?= substr(htmlspecialchars($item['descricao']), 0, 15) ?></span>
                                <span><?= $item['quantidade'] ?> UN</span>
                                <span>R$ <?= number_format($item['valor_unitario'], 2, ',', '.') ?></span>
                                <span>R$ <?= number_format($item['quantidade'] * $item['valor_unitario'], 2, ',', '.') ?></span>
                                <span>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="descricao" value="<?= htmlspecialchars($item['descricao']) ?>">
                                        <button type="submit" name="excluir" class="btn btn-secondary btn-excluir bi-trash "></button>

                                    </form>
                                </span>
                            </div>
                        <?php endforeach; ?>
                        <div class=" cupom-item total">
                            <span>Total Cupom R$</span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                        </div>
                    </div>

                    <!-- Botões de ação -->
                    <div class="text-center mt-3">
                        <form method="POST" action="" class="d-inline">
                            <button type="submit" name="finalizar" class="btn btn-success">Finalizar</button>
                        </form>
                        <form method="POST" action="" class="d-inline">
                            <button type="submit" name="cancelar" class="btn btn-danger">Cancelar</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Nenhum item adicionado ao carrinho.</div>
                <?php endif; ?>

                <?php if (isset($_GET['sucesso'])): ?>
                    <div class="alert alert-success mt-3">Venda finalizada com sucesso!</div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
mysqli_close($conexao);
?>