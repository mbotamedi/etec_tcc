<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/inicio.css">
    <!--FONTS---->
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
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar" style="width: 100%; background-color: rgba(0, 0, 0, 0.791);">
        <div class="container-fluid px-4 px-lg-5">
            <div class="imagem col-2">
                <img src="imgs/logo_copia01.png" alt="" width="100px">
            </div>

            <div class="items col-5">
                <a href="index.html">INICIO</a>
                <a href="#">PEÇA AGORA</a>
                <a href="#">UNIDADES</a>
                <a href="#">SOBRE</a>
            </div>

            <div class="buy-actions">
                <a href="#" id="abrirModal">
                    <img src="imgs/User.png" alt="Usuário" width="30px">
                </a>

                <a href="#">
                    <img src="imgs/Shopping cart.png" alt="Carrinho" width="30px">
                </a>
            </div>
        </div>


    </nav>

    <!-- Modal -->
    <div id="meuModal" class="modal-container">
        <!--CONTAINER DE FORA---->
        <div class="modal-content col-3">
            <!--CONTAINER DO NOME---->
            <div class="user-info" style="display: flex;">
                <div class="image-user">
                    <img src="imgs/usuario-de-perfil.png" alt="" width="50px">
                </div>
                <div class=" user-name">
                    <!--PUXAR O NOME DA CONTA VIA (JAVA-SCRIPT)-->
                    <h4 id="nomeUsuario">Rafael Contieri</h4>
                    <!-------------------------------------------->
                    <a href="#" style="outline: none; color: red;">Sair</a>
                </div>
            </div>

            <div class="action-buttons text-start">
                <a href="#" class="btn btn-primary">Home</a>
                <a href="#" class="btn btn-primary">Minha conta</a>
                <a href="#" class="btn btn-primary">Pedidos/Compras</a>
                <a href="./admin/admin.php" class="btn btn-primary">Administrador</a>
                <a href="#" class="btn btn-primary">Suporte</a>
            </div>

        </div>
    </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; WebSolution 2025</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>



    <!--------------SCRIPTS-------------->

    <script src="js/scripts.js"></script>
    <script src="js/dropDown-menu.js"></script>

    <!--------------SCRIPTS/-------------->

    <style>

        .user-name{
            margin-left: 10px;
        }

        .user-info{
            background-color: #63636361;
            border-radius: 10px;
            padding: 10px;
        }


        .action-buttons {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 10px;
        }

        .modal-container {
            display: none;
            /* Oculto por padrão */
            position: absolute;
            right: 0;
            /* Encosta no canto direito */
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            padding: 10px;
            z-index: 1000;
            width: 300px;
            /* Tamanho pequeno */
            /* Configuração da animação inicial */
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out, opacity 0.3s ease-in-out;
        }

        /* Classe para exibir o modal com animação */
        .modal-container.show {
            max-height: 500px;
            /* Ajuste conforme o conteúdo */
            opacity: 1;

        }
    </style>

</body>

</html>