<?php
session_start();

// Verifica se o usuário está logado
$logado = isset($_SESSION['usuario']);
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['nome'] : '';

// Define a classe de exibição do modal baseado no estado de login
$modalAntesDisplay = $logado ? 'none' : 'block';
$modalDepoisDisplay = $logado ? 'block' : 'none';
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
                <a href="#" id="abrirModal">
                    <img src="../imgs/User.png" alt="Usuário" width="30px">
                </a>
                <a href="#">
                    <img src="../imgs/Shopping cart.png" alt="Carrinho" width="30px">
                </a>
            </div>
        </div>

        <div class="search-bar" style="gap: 20px;">
            <form method="post" class="barra-pesquisa" style="display: flex; gap: 20px; align-items: center;">
                <input type="text" name="consulta" id="consulta" class="pesquisa-input" placeholder="Digite o Nome do Produto" style="padding-left: 10px; height: 40px; width: 800px;">
                <button type="submit" class="botao-pesquisa" style="background: none; border: none; cursor: pointer; padding: 0; height: 30px; display: flex; align-items: center;">
                <img src="./lupa (3).png" style="width: 25px;" alt="" >
                </button>
            </form>
        </div>
    </nav>

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
                                <button type="submit" class="btn btn-outline-primary mt-auto buy-button">Comprar</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </section>
    <!-- Section End-->
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
    <script src="../js/troca-modal.js"></script>
    <!--------------SCRIPTS/-------------->
</body>

</html>