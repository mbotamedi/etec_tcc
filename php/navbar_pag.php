<?php
$current_page = basename($_SERVER['PHP_SELF']);
$is_finalizar_pedido = ($current_page == 'cadastro_endereco.php' || $current_page == 'finalizar_pedido.php' || $current_page == 'pedidos_cliente.php' || $current_page == 'confirmacao_pedido.php');
?>

<?php if (!$is_finalizar_pedido): ?>

    <head>
        <link rel="stylesheet" href="../css/navbar.css">
        <link rel="stylesheet" href="../css/mediaQuery.css">

    </head>

    <style>
        .nav-top {
            z-index: 9999;
        }
    </style>

    <nav class="navbar">
        <div class="nav-top">
            <div class="logo">
                <img src="../assets/img/logo_copia01.png" alt="Logo Cantina" width="100px">
            </div>
            <div class="menu" id="menu">
                <ul>
                    <li><a href="../index.php" class="titulo">INICIO</a></li>
                    <li><a href="../php/produtos.php" class="titulo">PEÇA AGORA</a></li>
                    <li><a href="../php/unidades.php" class="titulo">UNIDADES</a></li>
                </ul>
            </div>

            <div class="user-cart" id="user-cart">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#<?php echo isset($_SESSION['usuario']) ? 'canvas-logado' : 'canvas-deslogado'; ?>" aria-controls="offcanvasExample" style="background-color: transparent; border: none;">
                    <img src="../assets/img/User.png" alt="Usuário" width="30px">
                </button>
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart" style="background-color: transparent; border: none;">
                    <img src="../assets/img/Shopping cart.png" alt="Carrinho" width="30px">
                    <?php
                    $quantidadeItens = isset($_SESSION["carrinho"]) && is_array($_SESSION["carrinho"]) ? count($_SESSION["carrinho"]) : 0;
                    if ($quantidadeItens > 0) {
                        echo '<span class="cart-badge">' . $quantidadeItens . '</span>';
                    }
                    ?>
                </button>
            </div>
        </div>
    </nav>

    <!-- OFF CANVAS PARA USUARIO DESLOGADO -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="canvas-deslogado" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Não possui uma conta?</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="modal-content01">
                <p class="modal-text">
                    <a href="../php/login.php" class="modal-link">Acesse sua conta ou cadastre-se</a>
                </p>
            </div>
        </div>
    </div>

    <!-- OFF CANVAS PARA USUARIO LOGADO -->
    <div class="offcanvas logado offcanvas-end" tabindex="-1" id="canvas-logado" aria-labelledby="offcanvasExampleLabel">
        <div class="items-group">
            <div class="header-offcanvasLogado">
                <div class="group-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bem vindo, <span class="nome-usuario">
                            <?php
                            if (isset($_SESSION['usuario']['nome'])) {
                                echo htmlspecialchars($_SESSION['usuario']['nome']);
                            } else {
                                echo 'Usuário';
                            }
                            ?>
                        </span></h5>
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
                    $tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
                    $menu = '
                        <li class="li-items"><a href="../index.php">Home</a></li>
                        <li class="li-items"><a href="../php/produtos.php">Produtos</a></li>
                        <li class="li-items"><a href="../php/unidades.php">Unidades</a></li>
                        <li class="li-items"><a href="../carrinho/pedidos/pedidos_cliente.php">Pedidos/Compras</a></li>';
                    if ($tipo !== "cliente") {
                        $menu = '
                            <li class="li-items"><a href="../index.php">Home</a></li>
                            <li class="li-items"><a href="../admin/admin.php">Administrador</a></li>
                            <li class="li-items"><a href="../php/produtos.php">Produtos</a></li>
                            <li class="li-items"><a href="../php/unidades.php">Unidades</a></li>';
                    }
                    echo $menu;
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Offcanvas para o Carrinho de Compras -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasCartLabel">Carrinho de Compras</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php include("../carrinho/carrinho.php"); ?>
        </div>
    </div>

<?php else: ?>

    <head>
        <link rel="stylesheet" href="../../css/navbar.css">
        <link rel="stylesheet" href="../../css/mediaQuery.css">

    </head>
    <nav class="navbar">
        <div class="nav-top">
            <div class="logo">
                <img src="../../assets/img/logo_copia01.png" alt="Logo Cantina" width="100px">
            </div>
            <div class="menu">
                <ul>
                    <li><a href="../../index.php">INICIO</a></li>
                    <li><a href="../../php/produtos.php">PEÇA AGORA</a></li>
                    <li><a href="../../php/unidades.php">UNIDADES</a></li>
                </ul>
            </div>
            <div class="user-cart">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#canvas-logado" aria-controls="offcanvasExample" style="background-color: transparent; border: none;">
                    <img src="../../assets/img/User.png" alt="Usuário" width="30px">
                </button>

            </div>
    </nav>

    <!-- OFF CANVAS PARA USUARIO DESLOGADO -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="canvas-deslogado" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Não possui uma conta?</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="modal-content01">
                <p class="modal-text">
                    <a href="../../php/login.php" class="modal-link">Acesse sua conta ou cadastre-se</a>
                </p>
            </div>
        </div>
    </div>

    <!-- OFF CANVAS PARA USUARIO LOGADO -->
    <div class="offcanvas logado offcanvas-end" tabindex="-1" id="canvas-logado" aria-labelledby="offcanvasExampleLabel">
        <div class="items-group">
            <div class="header-offcanvasLogado">
                <div class="group-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bem vindo, <span class="nome-usuario">
                            <?php
                            if (isset($_SESSION['usuario']['nome'])) {
                                echo htmlspecialchars($_SESSION['usuario']['nome']);
                            } else {
                                echo 'Usuário';
                            }
                            ?>
                        </span></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="botao-sair">
                    <a href="../../php/logout.php" class="btn-logout">Sair</a>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <div class="items-group-2">
            <div class="items-menu">
                <ul class="ul-items">
                    <?php
                    $tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
                    $menu = '
                        <li class="li-items"><a href="../../index.php">Home</a></li>
                        <li class="li-items"><a href="../../php/produtos.php">Produtos</a></li>
                        <li class="li-items"><a href="../../php/unidades.php">Unidades</a></li>
                    
                        <li class="li-items"><a href="../../carrinho/pedidos/pedidos_cliente.php">Pedidos/Compras</a></li>';
                    if ($tipo !== "cliente") {
                        $menu = '
                            <li class="li-items"><a href="../../index.php">Home</a></li>
                            <li class="li-items"><a href="../../admin/admin.php">Administrador</a></li>
                            <li class="li-items"><a href="../../php/produtos.php">Produtos</a></li>
                            <li class="li-items"><a href="../../php/unidades.php">Unidades</a></li>';
                    }
                    echo $menu;
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Offcanvas para o Carrinho de Compras -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasCartLabel">Carrinho de Compras</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php include(__DIR__ . '/../carrinho/carrinho.php');; ?>
        </div>
    </div>

<?php endif; ?>