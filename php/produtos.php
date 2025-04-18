<?php
@session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
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


</head>

<body>
    <!-- Navigation-->
    <nav class="navbar">
        <div class="nav-top">
            <div class="logo">
                <img src="../imgs/logo_copia01.png" alt="Logo Cantina" width="100px">
            </div>
            <div class="menu">
                <ul>
                    <li><a href="../index.php">INICIO</a></li>
                    <li><a href="produtos.php">PEÇA AGORA</a></li>
                    <li><a href="unidades.php">UNIDADES</a></li>
                </ul>
            </div>
            <div class="user-cart">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" style="background-color: transparent; border: none;">
                    <img src="../imgs/user.png" alt="Carrinho" width="30px">
                </button>
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart" style="background-color: transparent; border: none;">
                    <img src="../imgs/Shopping cart.png" alt="Carrinho" width="30px">
                    <?php
                    // Contar itens no carrinho, com verificação para evitar erros
                    $quantidadeItens = isset($_SESSION["carrinho"]) && is_array($_SESSION["carrinho"]) ? count($_SESSION["carrinho"]) : 0;
                    if ($quantidadeItens > 0) {
                        echo '<span class="cart-badge">' . $quantidadeItens . '</span>';
                    }
                    ?>
                </button>
            </div>
        </div>

        <div class="search-bar" style="gap: 20px;">
            <form method="post" class="barra-pesquisa" style="display: flex; gap: 20px; align-items: center;">
                <input type="text" name="consulta" id="consulta" class="pesquisa-input" placeholder="Digite o Nome do Produto" style="padding-left: 10px; height: 40px; width: 800px;">
                <button type="submit" class="botao-pesquisa" style="background: none; border: none; cursor: pointer; padding: 0; height: 30px; display: flex; align-items: center;">
                    <img src="../imgs/lupa (3).png" style="width: 25px;" alt="">
                </button>
            </form>
        </div>
    </nav>

    <!-- OFF CANVAS PARA LOGIN E CADASTRO-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Não possui uma conta?</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="modal-content01">
                <p class="modal-text">
                    <a href="php/login.php" class="modal-link">Acesse sua conta ou cadastre-se</a>
                </p>
            </div>
        </div>

    </div>

    <!-- OFF CANVAS PARA USUARIO LOGADO-->
    <div class="offcanvas logado offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="items-group">
            <div class="header-offcanvasLogado">
                <div class="group-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bem vindo, Rafael</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="botao-sair">
                    <a href="php/logout.php" class="btn-logout">Sair</a>
                </div>

            </div>

        </div>
        <div class="line">

        </div>
        <div class="items-group-2">
            <div class="items-menu">
                <ul class="ul-items">
                    <li class="li-items"><a href="index.php">Home</a></li>
                    <li class="li-items"><a href="admin/admin.php">Administrador</a></li>
                    <li class="li-items"><a href="php/produtos.php">Produtos</a></li>
                    <li class="li-items"><a href="php/unidades.php">Unidades</a></li>
                    <li class="li-items"><a href="#">Minha conta</a></li>
                    <li class="li-items"><a href="#">Pedidos/Compras</a></li>

                </ul>
            </div>
        </div>
    </div>


    <!-- Navigation End-->
    <!-- Section-->
    <section class="py-5">

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                include("../includes/pesquisa.php");
                foreach ($produtos as $produto):
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-img-container">
                                <img src="<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['descricao']) ?>" style="max-height: 100%; max-width: 100%;">
                            </div>
                            <div class="card-body p-4">
                                <h5 class="card-title"><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></h5>
                                <!---<p class="card-text"><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></p>--->
                                <p class="card-text">Preço: R$ <?= number_format($produto['valor'], 2, ',', '.') ?> cada</p>
                                <p class="card-text">Estoque: <?= $produto['estoque'] ?> unidades</p>
                            </div>
                            <div class="quantity-controls">
                                <label class="qtd-label">Quantidade:</label>
                                <div>
                                    <input type="button" id="minus_<?= $produto['id'] ?>" value="-" onclick="process(-1, 'quant_<?= $produto['id'] ?>')" class="campo" />
                                    <input id="quant_<?= $produto['id'] ?>" name="quant" class="text" size="1" type="text" value="0" maxlength="5" />
                                    <input type="button" id="plus_<?= $produto['id'] ?>" value="+" onclick="process(1, 'quant_<?= $produto['id'] ?>')" class="campo" />
                                </div>

                            </div>
                            <div class="text-center">
                                <a href="javascript:void(0)" onclick="addToCart(<?= $produto['id'] ?>, document.getElementById('quant_<?= $produto['id'] ?>').value)" class="btn btn-outline-primary mt-auto buy-button">Comprar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </section>
    <!-- Section End-->
    <!-- Offcanvas para o Carrinho de Compras -->
    <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasCartLabel">Carrinho de Compras</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php
            @session_start();
            include("../carrinho/carrinho.php"); // Inclui a lógica do carrinho diretamente
            ?>
        </div>
    </div>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Cantina Três Irmãos</p>
        </div>
    </footer>
    <!-- Footer End-->

    <!-- Modal de confirmação de logout -->
    <div id="modalLogout" class="modal-logout">
        <div class="modal-logout-content">
            <h3>Tem certeza que deseja sair?</h3>
            <div class="modal-logout-buttons">
                <button id="btnConfirmarLogout" class="btn-confirmar">Sim, sair</button>
                <button id="btnCancelarLogout" class="btn-cancelar">Cancelar</button>
            </div>
        </div>
    </div>

    <!--------------SCRIPTS-------------->
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/funcao.js"></script>
    <script src="../js/carrinho.js"></script>
    <script src="../js/controlaModal.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get("openCart") === "true") {
                var offcanvasElement = document.getElementById("offcanvasCart");
                var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                offcanvas.show();
            }
        });
    </script>

    <!--------------SCRIPTS/-------------->
</body>

</html>