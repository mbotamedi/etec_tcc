<?php
session_start();

// Verifica se o usuário está logado como cliente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
include("../../includes/conexao.php");

// Obtém o ID do cliente da sessão
$id_cliente = $_SESSION['usuario']['id'];

// Consulta os dados do cliente
$query_cliente = "SELECT nome, cnpj_cpf, email, telefone FROM tb_clientes WHERE id = '$id_cliente'";
$resultado_cliente = mysqli_query($conexao, $query_cliente);

if (!$resultado_cliente || mysqli_num_rows($resultado_cliente) == 0) {
    die("Erro ao carregar dados do cliente.");
}

$cliente = mysqli_fetch_assoc($resultado_cliente);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina Três Irmãos - Editar Conta</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .btn-save {
            background-color: #f6d365;
            border: none;
            color: #333;
            font-weight: 600;
        }

        .btn-save:hover {
            background-color: #f3c747;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Alteração de dados Pessoais</h2>
            <form action="../../php/dados_Cliente/altera_cadastro.php" method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cnpj_cpf" class="form-label">CPF/CNPJ</label>
                    <input type="text" class="form-control" id="cnpj_cpf" name="cnpj_cpf" value="<?php echo htmlspecialchars($cliente['cnpj_cpf']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone']); ?>" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-save">Salvar Alterações</button>
                    <a href="../../carrinho/pedidos/pedidos_cliente.php" class="btn btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>