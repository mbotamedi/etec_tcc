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
    </style>
</head>

<body>
    <!-- Navigation-->
    <?php include("navbar.php"); ?>
    <!-- Navigation End-->

    <section class="vh-100" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-120">
                <div class="col col-lg-10 mb-4 mb-lg-2">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white"
                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="https://cdn-icons-png.flaticon.com/128/848/848006.png"
                                    alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                <h5><?php echo htmlspecialchars($cliente['nome']); ?></h5>
                                <p>Cliente</p>
                                <!---<a href="editar_perfil.php"><i class="far fa-edit mb-5"></i></a>--->
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Informação sobre sua Conta</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted"><?php echo htmlspecialchars($cliente['email']); ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Telefone</h6>
                                            <p class="text-muted"><?php echo htmlspecialchars($cliente['telefone']); ?></p>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>CPF/CNPJ</h6>
                                            <p class="text-muted"><?php echo htmlspecialchars($cliente['cnpj_cpf']); ?></p>
                                        </div>
                                    </div>
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