<?php
session_start();

// Verifica se o usuário está logado como cliente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado como cliente
    exit();
}

// Conexão com o banco de dados
include("../includes/conexao.php");

// Obtém o ID do cliente da sessão
$id_cliente = $_SESSION['usuario']['id'];

// Consulta os dados do cliente
$query = "SELECT * FROM tb_clientes WHERE id = '$id_cliente'";
$resultado = mysqli_query($conexao, $query);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("Erro ao carregar dados do cliente.");
}

$cliente = mysqli_fetch_assoc($resultado);
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

    <!-- Favicon-->
    <link rel="icon" type="../image/x-icon" href="../assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!--FONTS-------->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <!---Carrinho--->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #f6d365;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
        }

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

        .btn-change-photo {
            background-color: white;
            color: #333;
            border: none;
            font-weight: 500;
        }

        .btn-change-photo:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <!-- Navigation-->
    <?php include("navbar.php"); ?>
    <!-- Navigation End-->

    <section class="user-profile-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card profile-card mb-4">
                        <div class="profile-header gradient-custom">
                            <img src="../imgs/fotoPerfil.jpg" alt="Foto do usuário" class="profile-pic">
                            <h2 class="profile-name"><?php echo htmlspecialchars($cliente['nome']); ?></h2>
                            <button id="carregarFoto" class="btn btn-change-photo btn-sm">
                                <i class="bi bi-camera-fill"></i> Alterar foto
                            </button>
                        </div>

                        <div class="profile-content">
                            <div class="info-section">
                                <h4 class="info-title">Informações da Conta</h4>
                                <div class="info-item">
                                    <span class="info-label">Email</span>
                                    <span class="info-value"><?php echo htmlspecialchars($cliente['email']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Telefone</span>
                                    <span class="info-value"><?php echo htmlspecialchars($cliente['telefone']); ?></span>
                                </div>
                            </div>

                            

                            <div class="info-section">
                                <div class="info-item">
                                    <span class="info-label">CPF/CNPJ</span>
                                    <span class="info-value"><?php echo htmlspecialchars($cliente['cnpj_cpf']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!---Footer--->
    <?php include("footer.php"); ?>

    <!--------------SCRIPTS-------------->
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/funcao.js"></script>
</body>

</html>