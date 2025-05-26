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
    $id_produto = mysqli_real_escape_string($conexao, $_POST['id_produto']);
    $quantidade = (int)$_POST['quantidade'];

    // Busca o produto
    $query = "SELECT * FROM tb_produtos WHERE id = '$id_produto'";
    $result = mysqli_query($conexao, $query);
    $produto = mysqli_fetch_assoc($result);

    if ($produto && $quantidade > 0) {
        $item = [
            'id' => $produto['id'],
            'descricao' => $produto['descricao'],
            'quantidade' => $quantidade,
            'valor_unitario' => $produto['valor']
        ];
        $_SESSION['carrinho_pdv'][] = $item;
    } else {
        echo "<script>alert('Produto inválido ou quantidade insuficiente.');</script>";
    }
}

// Exclui produto do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])) {
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    foreach ($_SESSION['carrinho_pdv'] as $index => $item) {
        if ($item['descricao'] === $descricao) {
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
    $metodo_pagamento = mysqli_real_escape_string($conexao, $_POST['metodo_pagamento'] ?? 'dinheiro');
    $emissao = date('Y-m-d H:i:s');
    $tipo_entrega = 'retirada';
    $tipo = 'PDV';

    // Validação
    if (empty($_SESSION['carrinho_pdv'])) {
        echo "<script>alert('Carrinho vazio. Adicione produtos antes de finalizar.');</script>";
    } elseif (!in_array($metodo_pagamento, ['DINHEIRO', 'CARTAO'])) {
        echo "<script>alert('Método de pagamento inválido.');</script>";
    } else {
        // Verifica se há caixa aberto para pagamentos
        $id_caixa = null;
        $query_caixa = "SELECT id_caixa FROM tb_caixa WHERE data_fechamento IS NULL ORDER BY id_caixa DESC LIMIT 1";
        $result_caixa = mysqli_query($conexao, $query_caixa);
        if (mysqli_num_rows($result_caixa) == 0) {
            echo "<script>alert('Nenhum caixa aberto para registrar o pagamento.');</script>";
        } else {
            $id_caixa = mysqli_fetch_assoc($result_caixa)['id_caixa'];

            // Validação de estoque
            $estoque_valido = true;
            foreach ($_SESSION['carrinho_pdv'] as $item) {
                $id_produto = mysqli_real_escape_string($conexao, $item['id']);
                $qtd = mysqli_real_escape_string($conexao, $item['quantidade']);
                $descricao = mysqli_real_escape_string($conexao, $item['descricao']);
                $query_estoque = "SELECT estoque FROM tb_produtos WHERE id = '$id_produto'";
                $result_estoque = mysqli_query($conexao, $query_estoque);
                if ($result_estoque && mysqli_num_rows($result_estoque) > 0) {
                    $estoque = mysqli_fetch_assoc($result_estoque)['estoque'];
                    if ($estoque < $qtd) {
                        echo "<script>alert('Produto $descricao com estoque insuficiente.');</script>";
                        $estoque_valido = false;
                        break;
                    }
                } else {
                    echo "<script>alert('Erro ao verificar estoque do produto $descricao.');</script>";
                    $estoque_valido = false;
                    break;
                }
            }

            if ($estoque_valido) {
                // Insere o pedido
                $query_pedido = "INSERT INTO tb_pedidos (emissao, valor_total, tipo_entrega, tipo_pedido, metodo_pagamento) 
                                 VALUES ('$emissao', '$total', '$tipo_entrega', '$tipo', '$metodo_pagamento')";
                mysqli_query($conexao, $query_pedido);
                $id_pedido = mysqli_insert_id($conexao);

                // Insere os itens e atualiza o estoque
                foreach ($_SESSION['carrinho_pdv'] as $item) {
                    $id_produto = mysqli_real_escape_string($conexao, $item['id']);
                    $qtd = mysqli_real_escape_string($conexao, $item['quantidade']);
                    $valor_unitario = mysqli_real_escape_string($conexao, $item['valor_unitario']);
                    $query_item = "INSERT INTO tb_pedidos_itens (id_pedidos, id_produtos, qtd, valor_untiario) 
                                   VALUES ('$id_pedido', '$id_produto', '$qtd', '$valor_unitario')";
                    mysqli_query($conexao, $query_item);

                    // Atualiza o estoque
                    $query_estoque = "UPDATE tb_produtos SET estoque = estoque - $qtd WHERE id = '$id_produto'";
                    mysqli_query($conexao, $query_estoque);
                }

                // Registra no caixa
                $descricao = "Pedido PDV #$id_pedido";
                $query_mov = "INSERT INTO tb_movimentacoes_caixa (id_caixa, tipo, descricao, valor, data_movimento) 
                              VALUES ('$id_caixa', 'ENTRADA', '$descricao', '$total', '$emissao')";
                mysqli_query($conexao, $query_mov);

                // Limpa o carrinho
                $_SESSION['carrinho_pdv'] = [];
                echo "<script>alert('Venda finalizada com sucesso!'); window.location.href = 'admin.php';</script>";
                exit;
            }
        }
    }
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
    $_SESSION['carrinho_pdv'] = [];
    echo "<script>alert('Venda cancelada com sucesso!'); window.location.href = 'admin.php';</script>";
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

        .tipo-entrega-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }

        .tipo-entrega-option input {
            margin-right: 10px;
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
                                        <button type="submit" name="excluir" class="btn btn-secondary btn-excluir bi-trash"></button>
                                    </form>
                                </span>
                            </div>
                        <?php endforeach; ?>
                        <div class="cupom-item total">
                            <span>Total Cupom R$</span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                        </div>
                    </div>

                    <!-- Seleção de Método de Pagamento -->
                    <div class="mt-3">
                        <h5>Selecione o Método de Pagamento</h5>
                        <form method="POST" action="">
                            <div class="tipo-entrega-option">
                                <input type="radio" name="metodo_pagamento" value="DINHEIRO" required checked>
                                <div>
                                    <strong>Dinheiro</strong>
                                    <p>Pagamento em dinheiro</p>
                                </div>
                            </div>
                            <div class="tipo-entrega-option">
                                <input type="radio" name="metodo_pagamento" value="CARTAO">
                                <div>
                                    <strong>Cartão</strong>
                                    <p>Pagamento com cartão</p>
                                </div>
                            </div>
                            <!-- Botões de ação -->
                            <div class="text-center mt-3">
                                <button type="submit" name="finalizar" class="btn btn-success">Finalizar</button>
                                <button type="submit" name="cancelar" class="btn btn-danger">Cancelar</button>
                            </div>
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