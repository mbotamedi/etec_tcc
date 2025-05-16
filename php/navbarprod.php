<?php
//@session_start();
// Inclui o arquivo de verificação de login
include 'verificar_login.php';
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
?>

<head>
    <link rel="stylesheet" href="../css/mediaQuery.css">
</head>


<nav class="navbar">
    <div class="nav-top">
        <div class="logo">
            <img src="../imgs/logo_copia01.png" alt="Logo Cantina" width="100px">
        </div>
        <div class="menu">
            <ul>
                <li><a href="index.php">INICIO</a></li>
                <li><a href="produtos.php">PEÇA AGORA</a></li>
                <li><a href="unidades.php">UNIDADES</a></li>
            </ul>
        </div>
        <div class="user-cart">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" style="background-color: transparent; border: none;">
                <img src="../imgs/user.png" alt="Usuário" width="30px">
            </button>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart" style="background-color: transparent; border: none;">
                <img src="../imgs/Shopping cart.png" alt="Carrinho" width="30px">
                <?php
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
                <input type="text" name="consulta" id="consulta" class="pesquisa-input" placeholder="Digite o Nome do Produto" style="padding-left: 10px; height: 40px; width: 800px;" >
                <button type="submit" class="botao-pesquisa" style="background: none; border: none; cursor: pointer; padding: 0; height: 30px; display: flex; align-items: center;" >
                    <img src="../imgs/lupa (3).png" style="width: 25px;" alt="">
                </button>
            </form>
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
                <a href="login.php" class="modal-link">Acesse sua conta ou cadastre-se</a>
            </p>
        </div>
    </div>
</div>

<!-- OFF CANVAS PARA USUARIO LOGADO -->
<div class="offcanvas logado offcanvas-end" tabindex="-1" id="canvas-logado" aria-labelledby="offcanvasExampleLabel">
    <div class="items-group">
        <div class="header-offcanvasLogado">
            <div class="group-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bem vindo, <span class="nome-usuario"><?php 
                    if (isset($_SESSION['usuario']['nome'])) {
                        echo htmlspecialchars($_SESSION['usuario']['nome']);
                    } else {
                        echo '<script>
                            const nomeUsuario = sessionStorage.getItem("nome_usuario");
                            if (nomeUsuario) {
                                document.querySelector(".nome-usuario").textContent = nomeUsuario;
                            }
                        </script>';
                    }
                ?></span></h5>
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
                    <li class="li-items"><a href="../carrinho/pedidos/pedidos_cliente.php">Pedidos/Compras</a></li>';
                if ($tipo !== "cliente") {
                    $menu = '
                        <li class="li-items"><a href="index.php">Home</a></li>
                        <li class="li-items"><a href="../admin/admin.php">Administrador</a></li>
                        <li class="li-items"><a href="produtos.php">Produtos</a></li>
                        <li class="li-items"><a href="unidades.php">Unidades</a></li>';
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