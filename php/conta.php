<?php
@session_start();

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
$query_cliente = "SELECT * FROM tb_clientes WHERE id = '$id_cliente'";
$resultado_cliente = mysqli_query($conexao, $query_cliente);

if (!$resultado_cliente || mysqli_num_rows($resultado_cliente) == 0) {
    die("Erro ao carregar dados do cliente.");
}

$cliente = mysqli_fetch_assoc($resultado_cliente);

// Consulta os endereços do cliente
$query_enderecos = "SELECT ce.*, c.nome_cidade, c.sigla_estado 
                    FROM tb_cliente_endereco ce 
                    LEFT JOIN tb_cidades c ON ce.id_cidade = c.codigo_cidade 
                    WHERE ce.id_cliente = '$id_cliente'";
$resultado_enderecos = mysqli_query($conexao, $query_enderecos);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina Três Irmãos - Minha Conta</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/mediaQuery.css">
    <link rel="stylesheet" href="../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">
    <link rel="stylesheet" href="../css/conta.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:wght@100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:wght@300..900&display=swap" rel="stylesheet">
    <style>
        .user-profile-section {
            background-color: #f4f5f7;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .profile-card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            padding: 2rem;
            text-align: center;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            margin-bottom: 1rem;
        }

        .profile-name {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .profile-content {
            padding: 2rem;
            background-color: white;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .info-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .info-item {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .info-item:before {
            content: "";
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 0.75rem;
            height: 0.75rem;
            border: 2px solid #f6d365;
            border-radius: 50%;
            background-color: #f3c747;
        }

        .info-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #6c757d;
            padding: 0.5rem 0;
            display: block;
        }

        .btn-save {
            background-color: #f6d365;
            border: none;
            color: #333;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 0.25rem;
        }

        .btn-save:hover {
            background-color: #f3c747;
            color: #333;
        }

        .btn-edit {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
        }

        .btn-edit:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card profile-card mb-4">
                    <div class="profile-header">
                        <img src="../../imgs/fotoPerfil.jpg" alt="Foto do usuário" class="profile-pic">
                        <h2 class="profile-name"><?php echo htmlspecialchars($cliente['nome']); ?></h2>
                        <button id="carregarFoto" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-camera-fill"></i> Alterar foto
                        </button>
                    </div>
                    <div class="profile-content">
                        <div class="info-section">
                            <h4 class="info-title">Informações da Conta</h4>
                            <div class="info-item">
                                <span class="info-label">Nome</span>
                                <span class="info-value"><?php echo htmlspecialchars($cliente['nome']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email</span>
                                <span class="info-value"><?php echo htmlspecialchars($cliente['email']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Telefone</span>
                                <span class="info-value"><?php echo htmlspecialchars($cliente['telefone']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">CPF/CNPJ</span>
                                <span class="info-value"><?php echo htmlspecialchars($cliente['cnpj_cpf']); ?></span>
                            </div>
                            <button class="btn btn-edit" onclick="window.location.href='../../php/dados_Cliente/alterar_dados.php'">Editar Dados</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/funcao.js"></script>
</body>

</html>