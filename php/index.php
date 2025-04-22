<?php
// Inclui o arquivo de verificação de login
include 'verificar_login.php';
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Configurações básicas da página -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cantina Três Irmãos</title>

    <!-- Favicon e ícones -->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">

    <!-- Importação de fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>
    <!-- Barra de navegação -->
    <nav class="navbar">
        <div class="nav-top">
            <!-- Logo da empresa -->
            <div class="logo">
                <img src="../imgs/logo_copia01.png" alt="Logo Cantina" width="100px">
            </div>

            <!-- Menu principal -->
            <div class="menu">
                <ul>
                    <li><a href="index.php">INICIO</a></li>
                    <li><a href="produtos.php">PEÇA AGORA</a></li>
                    <li><a href="unidades.php">UNIDADES</a></li>
                </ul>
            </div>

            <!-- Botões de usuário e carrinho -->
            <div class="user-cart">
                <!-- Botão do usuário -->
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#canvas-deslogado" aria-controls="canvas-deslogado" style="background-color: transparent; border: none;">
                    <img src="../imgs/user.png" alt="Usuário" width="30px">
                </button>

                <!-- Botão do carrinho com contador de itens -->
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart" style="background-color: transparent; border: none;">
                    <img src="../imgs/Shopping cart.png" alt="Carrinho" width="30px">
                    <?php
                    // Exibe a quantidade de itens no carrinho
                    $quantidadeItens = isset($_SESSION["carrinho"]) && is_array($_SESSION["carrinho"]) ? count($_SESSION["carrinho"]) : 0;
                    if ($quantidadeItens > 0) {
                        echo '<span class="cart-badge">' . $quantidadeItens . '</span>';
                    }
                    ?>
                </button>
            </div>
        </div>
    </nav>

    <!-- Carrossel de promoções -->
    <div class="carrosel" style="display: flex; justify-content: center;">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Imagens do carrossel -->
                <div class="carousel-item active">
                    <img src="../imgs/promocoes_notebook/promo01.jpg" alt="Promoção 1" class="d-block w-100">
                </div>
                <div class="carousel-item active">
                    <img src="../imgs/promocoes_notebook/promo02.jpg" class="d-block w-100">
                </div>
            </div>
            <!-- Controles do carrossel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Offcanvas para usuário deslogado -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="canvas-deslogado" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Não possui uma conta?</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="modal-content01">
                <p class="modal-text">
                    <a href="login.php" class="modal-link">Acesse sua conta ou cadastre-se</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Offcanvas para usuário logado -->
    <div class="offcanvas logado offcanvas-end" tabindex="-1" id="canvas-logado" aria-labelledby="offcanvasExampleLabel">
        <div class="items-group">
            <div class="header-offcanvasLogado">
                <div class="group-header">
                    <!-- Exibe o nome do usuário logado -->
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bem vindo, <span class="nome-usuario"><?php echo isset($nome) ? $nome : ''; ?></span></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="botao-sair">
                    <a href="logout.php" class="btn-logout">Sair</a>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <div class="items-group-2">
            <div class="items-menu">
                <ul class="ul-items">
                    <?php
                    $menu = '
                        <li class="li-items"><a href="index.php">Home</a></li>
                        <li class="li-items"><a href="produtos.php">Produtos</a></li>
                        <li class="li-items"><a href="unidades.php">Unidades</a></li>
                        <li class="li-items"><a href="#">Minha conta</a></li>
                        <li class="li-items"><a href="#">Pedidos/Compras</a></li>';
                    if ($tipo !== "cliente") {
                        $menu = '
                                <li class="li-items"><a href="index.php">Home</a></li>
                                <li class="li-items"><a href="../admin/admin.php">Administrador</a></li>
                                <li class="li-items"><a href="produtos.php">Produtos</a></li>
                                <li class="li-items"><a href="unidades.php">Unidades</a></li>
                                <li class="li-items"><a href="#">Minha conta</a></li>
                                <li class="li-items"><a href="#">Pedidos/Compras</a></li>';
                    }
                    echo $menu;
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Seção de produtos em destaque -->
    <section class="py-5">
        <div class="titulo-pricipal">
            <h1 class="produtos-Destaques">PROMOÇÕES DA SEMANA</h1>
        </div>

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                // Inclui e exibe os produtos em destaque
                include("../includes/consulta.php");
                foreach ($produtos as $produto):
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <!-- Imagem do produto -->
                            <div class="card-img-container">
                                <img src="../imgs/<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['descricao']) ?>" style="max-height: 100%; max-width: 100%;">
                            </div>
                            <div class="card-body p-4">
                                <!-- Informações do produto -->
                                <h5 class="card-title"><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="card-text"><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="card-text">Preço: R$ <?= number_format($produto['valor'], 2, ',', '.') ?> cada</p>
                                <p class="card-text">Estoque: <?= $produto['estoque'] ?> unidades</p>
                            </div>
                            <!-- Controles de quantidade -->
                            <div class="quantity-controls">
                                <label class="qtd-label">Quantidade:</label>
                                <div>
                                    <input type="button" id="minus_<?= $produto['id'] ?>" value="-" onclick="process(-1, 'quant_<?= $produto['id'] ?>')" class="campo" />
                                    <input id="quant_<?= $produto['id'] ?>" name="quant" class="text" size="1" type="text" value="0" maxlength="5" />
                                    <input type="button" id="plus_<?= $produto['id'] ?>" value="+" onclick="process(1, 'quant_<?= $produto['id'] ?>')" class="campo" />
                                </div>
                            </div>
                            <!-- Botão de compra -->
                            <div class="text-center">
                                <a href="javascript:void(0)" onclick="addToCart(<?= $produto['id'] ?>, document.getElementById('quant_<?= $produto['id'] ?>').value)" class="btn btn-outline-primary mt-auto buy-button">Comprar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Offcanvas do carrinho -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasCartLabel">Carrinho de Compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <?php
                // Exibe os itens do carrinho
                @session_start();
                include("../carrinho/carrinho.php");
                ?>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Cantina Três Irmãos</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/funcao.js"></script>
    <script src="../js/controlaModal.js"></script>
</body>

</html>