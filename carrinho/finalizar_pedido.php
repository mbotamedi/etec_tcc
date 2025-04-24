<?php
include("../includes/conexao.php");
include("../php/verificar_login.php");


// Verifica se o usuário está logado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    $_SESSION['url_retorno'] = 'finalizar_pedido.php';
    header("Location: ../php/login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$id_cliente = $usuario['id'];

// Verifica se há itens no carrinho
if (!isset($_SESSION["carrinho"]) || count($_SESSION["carrinho"]) <= 0) {
    header("Location: ../php/produtos.php?erro=carrinho_vazio");
    exit;
}

// Processa a finalização do pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_entrega = $_POST['tipo_entrega']; // 'entrega' ou 'retirada'
    $id_endereco = $_POST["id_endereco"];
    $id_endereco_value = ($tipo_entrega == 'entrega') ? $_POST['id_endereco'] : "NULL";

    // Insere o pedido na tabela tb_pedidos
    $emissao = date('Y-m-d');
    $valor_total = 0;

    foreach ($_SESSION["carrinho"] as $item) {
        $valor_total += $item['valor'] * $item['qtd'];
    }

    // Se for retirada, pode adicionar um valor fixo ou desconto (opcional)
    if ($tipo_entrega == 'retirada') {
        //$valor_total -= 5.00; // Exemplo de desconto para retirada
    }

    $query_pedido = "INSERT INTO tb_pedidos (id_cliente, id_endereco, emissao, valor_total, tipo_entrega) 
                 VALUES ('$id_cliente', $id_endereco_value, '$emissao', '$valor_total', '$tipo_entrega')";
    mysqli_query($conexao, $query_pedido);
    $id_pedido = mysqli_insert_id($conexao);

    // Insere os itens do pedido
    foreach ($_SESSION["carrinho"] as $item) {
        $id_produto = $item['id'];
        $qtd = $item['qtd'];
        $valor_unitario = $item['valor'];

        $query_item = "INSERT INTO tb_pedidos_itens (id_pedidos, id_produtos, qtd, valor_untiario) 
                       VALUES ('$id_pedido', '$id_produto', '$qtd', '$valor_unitario')";
        mysqli_query($conexao, $query_item);

        // Atualiza o estoque
        $query_estoque = "UPDATE tb_produtos SET estoque = estoque - $qtd WHERE id = '$id_produto'";
        mysqli_query($conexao, $query_estoque);
    }

    unset($_SESSION['carrinho']);
    header("Location: confirmacao_pedido.php?id_pedido=$id_pedido");
    exit;
}

// Obtém os endereços do cliente
$query_enderecos = "SELECT en.id, en.endereco, en.numero, en.descricao, en.bairro, en.cep, ci.nome_cidade , ci.sigla_estado FROM tb_cliente_endereco as en inner join tb_cidades as ci on en.id_cidade = ci.codigo_cidade WHERE en.id_cliente = '$id_cliente'";
$result_enderecos = mysqli_query($conexao, $query_enderecos);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido - Cantina Três Irmãos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <style>
        .container-finalizar {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .endereco-list,
        .tipo-entrega-options {
            margin-bottom: 20px;
        }

        .endereco-item {
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }



        .btn-finalizar {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-finalizar:hover {
            background-color: #218838;
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

        .tipo-entrega-option.active {
            border-color: #28a745;
            background-color: #f8f9fa;
        }

        #endereco-section {
            display: none;
        }
    </style>
</head>

<body>
    <?php include("../php/navbar.php"); ?>

    <section class="py-5">
        <div class="container-finalizar">
            <h2>Finalizando Pedido</h2>
            <h3>Resumo do Carrinho</h3>
            <?php include("../carrinho/carrinho.php"); ?>

            <h3>Escolha a Forma de Recebimento</h3>
            <form method="POST" action="finalizar_pedido.php">
                <div class="tipo-entrega-options">
                    <label class="tipo-entrega-option">
                        <input type="radio" name="tipo_entrega" value="retirada" checked onclick="toggleEndereco(false)">
                        <div>
                            <strong>Retirar na Cantina</strong>
                            <p>Você pode retirar seu pedido no balcão da cantina</p>
                        </div>
                    </label>

                    <label class="tipo-entrega-option">
                        <input type="radio" name="tipo_entrega" value="entrega" onclick="toggleEndereco(true)">
                        <div>
                            <strong>Entrega</strong>
                            <p>Entregamos no endereço cadastrado</p>
                        </div>
                    </label>
                </div>

                <div id="endereco-section">
                    <h3>Selecione o Endereço de Entrega</h3>
                    <div class="endereco-list">
                        <?php if (mysqli_num_rows($result_enderecos) > 0): ?>
                            <?php while ($endereco = mysqli_fetch_assoc($result_enderecos)): ?>
                                <div class="endereco-item">
                                    <input type="radio" name="id_endereco" value="<?= $endereco['id'] ?>" required>
                                    <label>
                                        Tipo: <strong><?= htmlspecialchars($endereco['descricao']) ?><br></strong>
                                        <?= htmlspecialchars($endereco['endereco']) ?>, <?= htmlspecialchars($endereco['numero']) ?><br>
                                        Bairro: <?= htmlspecialchars($endereco['bairro']) ?><br>
                                        CEP: <?= htmlspecialchars($endereco['cep']) ?><br>
                                        Cidade: <?= htmlspecialchars($endereco['nome_cidade']) ?> - <?= htmlspecialchars($endereco['sigla_estado']) ?>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Nenhum endereço cadastrado. <a href="../carrinho/cadastro_endereco.php">Cadastrar Endereço</a></p>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn-finalizar">Finalizar Pedido</button>
            </form>
        </div>
    </section>

    <?php include("../php/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/funcao.js"></script>
    <script src="../js/controlaModal.js"></script>
    <script src="../js/carrinho.js"></script>
    <script>
        function toggleEndereco(show) {
            const enderecoSection = document.getElementById('endereco-section');
            const enderecoInputs = enderecoSection.querySelectorAll('input[type="radio"]');

            enderecoSection.style.display = show ? 'block' : 'none';

            // Remove a obrigatoriedade se estiver oculto
            enderecoInputs.forEach(input => {
                input.required = show;
            });
        }
    </script>
</body>

</html>