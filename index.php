<?php
session_start()

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cantina Três Irmãos</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/inicio.css">
    <!--FONTS---->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar" style="width: 100%; background-color: rgba(0, 0, 0, 0.791);">
        <div class="container-fluid px-4 px-lg-5">
            <div class="imagem col-2">
                <img src="imgs/logo_copia01.png" alt="" width="100px">
            </div>

            <div class="items col-5">
                <a href="index.php">INICIO</a>
                <a href="PHP/produtos.php">PEÇA AGORA</a>
                <a href="PHP/unidades.php">UNIDADES</a>

            </div>

            <div class="menu-toggle">
                <img src="imgs/cardapio.png" alt="" width="32px">
                <ul class="menu">
                    <li><a href="index.html" style="margin-bottom: 5px;"><i class="fa-solid fa-house"></i> INICIO</a>
                    </li>
                    <li><a href="#" style="margin-bottom: 5px;"><i class="fa-solid fa-cart-plus"></i> PEÇA AGORA</a>
                    </li>
                    <li><a href="HTML/unidades.html" style="margin-bottom: 5px;"><i class="fa-solid fa-building"></i> UNIDADES</a></li>
                    <li><a href="#" id="abrirModalMenu" style="margin-bottom: 5px;"><i class="fa-solid fa-user"></i> MINHA CONTA</a></li>
                    <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> CARRINHO</a></li>
                </ul>
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

    <!-- Modal ANTES -->
    <div id="modalAntes" class="modal-container01">
        <div class="modal-content01">
            <p class="conta-cadastro">Não possui uma conta?</p>
            <a href="PHP/login.php">Cadastre-se ou faça seu login</a>
            <button id="fecharModalAntes">Fechar</button>
        </div>
    </div>

    <!-- Modal DEPOIS -->
    <div id="modalDepois" class="modal-container" style="display: none;">
        <div class="modal-content col-3">
            <div class="user-info" style="display: flex;">
                <div class="image-user">
                    <img src="imgs/usuario-de-perfil.png" alt="" width="50px">
                </div>
                <div class="user-name">
                    <h4 id="nomeUsuario"></h4>
                    <a href="./php/logout.php" class="sair-usuario"><span style="color: red;">Sair</span></a>
                </div>
            </div>

            <div class="action-buttons">
                <a href="./index.php" class="btn btn-primary">Home</a>
                <a href="#" class="btn btn-primary">Minha conta</a>
                <a href="#" class="btn btn-primary">Pedidos/Compras</a>
                <a href="./admin/admin.php" class="btn btn-primary">Administrador</a>
                <a href="#" class="btn btn-primary">Suporte</a>
            </div>
        </div>
    </div>




    <!--CARROSEL-->
    <div class="carrosel" style="display: flex; justify-content: center;">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="imgs/promocoes_notebook/promo01.png" alt="Promoção 1" class="d-block w-100">
                </div>
                <div class="carousel-item active">
                    <img src="imgs/promocoes_notebook/promo02.png" class="d-block w-100">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>


    <!-- Section-->
    <section class="py-5">

        <div class="titulo-pricipal">
            <h1 class="produtos-Destaques">PROMOÇÕES DA SEMANA</h1>
        </div>

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                include("includes/consulta.php");
                foreach ($produtos as $produto):
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-img-container">
                                <img src="<?= $produto['imagem1'] ?>" alt="<?= htmlspecialchars($produto['descricao']) ?>" style="max-height: 100%; max-width: 100%;">
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
                                <button type="submit" class="btn btn-outline-primary mt-auto buy-button ">Comprar</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Cantina Três Irmãos</p>
        </div>
    </footer>

    <!--------------SCRIPTS-------------->
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/funcao.js"></script>
    <script src="js/troca-modal.js"></script>
    <!--------------SCRIPTS/-------------->


</body>

</html>