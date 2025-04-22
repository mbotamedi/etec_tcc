<?php
@session_start();
include("../includes/conexao.php");

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    $_SESSION['url_retorno'] = 'finalizar_pedido.php';
    header("Location: login.php");
    exit;
}

$id_cliente = $_SESSION['usuario']['id'];

// Obtém os endereços do cliente
$query_enderecos = "SELECT * FROM tb_cliente_endereco WHERE id_cliente = '$id_cliente'";
$result_enderecos = mysqli_query($conexao, $query_enderecos);

// Processa o formulário de finalização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_entrega = $_POST['tipo_entrega'];
    $id_endereco = isset($_POST['id_endereco']) ? $_POST['id_endereco'] : null;

    // Validação
    if ($tipo_entrega === 'entrega' && empty($id_endereco)) {
        $erro = "Por favor, selecione um endereço para entrega.";
    } else {
        // Insere o pedido no banco (exemplo)
        $query_pedido = "INSERT INTO tb_pedidos (id_cliente, tipo_entrega, id_endereco, data_pedido, status) 
                         VALUES ('$id_cliente', '$tipo_entrega', " . ($id_endereco ? "'$id_endereco'" : "NULL") . ", NOW(), 'pendente')";
        mysqli_query($conexao, $query_pedido);

        // Redireciona para a página de confirmação
        header("Location: confirmacao_pedido.php");
        exit;
    }
}
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
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:wght@100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:wght@300..900&display=swap" rel="stylesheet">
    <style>
        .container-finalizar {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select, .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
        .endereco-group {
            display: none;
        }
        .erro {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php include("../php/navbar.php"); ?>

    <section class="py-5">
        <div class="container-finalizar">
            <h2>Finalizar Pedido</h2>
            <?php if (isset($erro)): ?>
                <p class="erro"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>
            <form method="POST" action="finalizar_pedido.php">
                <div class="form-group">
                    <label for="tipo_entrega">Tipo de Entrega:</label>
                    <select id="tipo_entrega" name="tipo_entrega" required onchange="toggleEndereco()">
                        <option value="retirada">Retirar na Cantina</option>
                        <option value="entrega">Entrega no Endereço</option>
                    </select>
                </div>
                <div class="form-group endereco-group" id="endereco-group">
                    <label for="id_endereco">Selecione o Endereço:</label>
                    <select id="id_endereco" name="id_endereco">
                        <?php while ($endereco = mysqli_fetch_assoc($result_enderecos)): ?>
                            <option value="<?= $endereco['id_endereco'] ?>">
                                <?= htmlspecialchars($endereco['descricao'] . " - " . $endereco['endereco'] . ", " . $endereco['numero'] . ", " . $endereco['bairro']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <p><a href="cadastro_endereco.php">Cadastrar novo endereço</a></p>
                </div>
                <button type="submit" class="btn-finalizar">Finalizar Pedido</button>
            </form>
        </div>
    </section>

    <?php include("../php/footer.php"); ?>

    <script>
        function toggleEndereco() {
            const tipoEntrega = document.getElementById('tipo_entrega').value;
            const enderecoGroup = document.getElementById('endereco-group');
            enderecoGroup.style.display = tipoEntrega === 'entrega' ? 'block' : 'none';
        }
        // Chama a função ao carregar a página para garantir o estado inicial
        toggleEndereco();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>
</html>