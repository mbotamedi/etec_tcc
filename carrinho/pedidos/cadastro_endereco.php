<?php
@session_start();
include("../../includes/conexao.php");

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    $_SESSION['url_retorno'] = 'finalizar_pedido.php';
    header("Location: ../../php/login.php");
    exit;
}

$id_cliente = $_SESSION['usuario']['id'];

// Processa o cadastro de novo endereço
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento'] ?? '');
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $id_cidade = mysqli_real_escape_string($conexao, $_POST['id_cidade']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    $query_insert = "INSERT INTO tb_cliente_endereco (id_cliente, endereco, numero, complemento, bairro, cep, id_cidade, descricao) 
                     VALUES ('$id_cliente', '$endereco', '$numero', '$complemento', '$bairro', '$cep', '$id_cidade', '$descricao')";
    if (mysqli_query($conexao, $query_insert)) {
        $novo_id_endereco = mysqli_insert_id($conexao);
        // Redireciona de volta para finalizar_pedido.php com o novo endereço
        $retorno = $_GET['retorno'] ?? 'finalizar_pedido.php';
        header("Location: $retorno?id_endereco=$novo_id_endereco&tipo_entrega=entrega");
        exit;
    } else {
        $erro = "Erro ao cadastrar o endereço: " . mysqli_error($conexao);
    }
}

// Obtém cidades para o select
$query_estado = "SELECT DISTINCT codigo_estado, sigla_estado FROM tb_cidades";
$result_estado = mysqli_query($conexao, $query_estado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Endereço - Cantina Três Irmãos</title>
    <link rel="stylesheet" href="../../css/styles.css" />
    <link rel="stylesheet" href="../../css/inicio.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../../css/canvaLogado.css">
    <link rel="icon" type="image/x-icon" href="../../assets/favicon.ico" />
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

        .form-group select,
        .form-group input {
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

        .erro {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php include("../../php/navbar.php"); ?>

    <section class="py-5">
        <div class="container-finalizar">
            <h2>Cadastrar Novo Endereço</h2>
            <?php if (isset($erro)): ?>
                <p class="erro"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>
            <form method="POST" action="cadastro_endereco.php">
                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" required>
                </div>
                <div class="form-group">
                    <label for="numero">Número:</label>
                    <input type="text" id="numero" name="numero" required>
                </div>
                <div class="form-group">
                    <label for="complemento">Complemento (opcional):</label>
                    <input type="text" id="complemento" name="complemento">
                </div>
                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" required>
                </div>
                <div class="form-group">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" required>
                </div>
                <div class="form-group">
                    <label for="id_estado">Estado:</label>
                    <select id="id_estado" name="id_estado" required onchange="carregarCidades()">
                        <?php while ($estado = mysqli_fetch_assoc($result_estado)): ?>
                            <option value="<?= $estado['codigo_estado'] ?>">
                                <?= htmlspecialchars($estado['sigla_estado']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_cidade">Cidade:</label>
                    <select id="id_cidade" name="id_cidade" required>
                        <option value="0">Selecione a Cidade</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição do Endereço (ex.: Casa, Trabalho):</label>
                    <input type="text" id="descricao" name="descricao" required>
                </div>
                <button type="submit" class="btn-finalizar">Cadastrar Endereço</button>
            </form>
        </div>
    </section>

    <?php include("../../php/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function carregarCidades() {
            const estadoSelect = document.getElementById('id_estado');
            const cidadeSelect = document.getElementById('id_cidade');
            const codigoEstado = estadoSelect.value;

            // Limpa o select de cidades
            cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

            if (codigoEstado) {
                // Faz uma requisição AJAX para buscar as cidades
                fetch(`buscar_cidades.php?codigo_estado=${codigoEstado}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(cidade => {
                            const option = document.createElement('option');
                            option.value = cidade.codigo_cidade;
                            option.textContent = cidade.nome_cidade;
                            cidadeSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Erro ao carregar cidades:', error));
            }
        }
    </script>
</body>

</html>