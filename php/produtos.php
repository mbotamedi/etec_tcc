<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
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
    <nav class="navbar" style="width: 100%; background-color: rgba(0, 0, 0, 0.791);">
        <div class="container-fluid px-4 px-lg-5">
            <div class="imagem col-2">
                <img src="../imgs/logo_copia01.png" alt="" width="100px">
            </div>

            <div class="items">
                <a href="../index.php">INÍCIO</a>
                <a href="../php/produtos.php">PEÇA AGORA</a>
                <a href="../php/unidades.php">UNIDADES</a>
            </div>


            <div class="menu-toggle">
                <img src="../imgs/cardapio.png" alt="" width="32px">
                <ul class="menu">
                    <li><a href="index.html" style="margin-bottom: 5px;"><i class="fa-solid fa-house"></i> INICIO</a>
                    </li>
                    <li><a href="#" style="margin-bottom: 5px;"><i class="fa-solid fa-cart-plus"></i> PEÇA AGORA</a>
                    </li>
                    <li><a href="HTML/unidades.html" style="margin-bottom: 5px;"><i class="fa-solid fa-building"></i> UNIDADES</a></li>
                    <li><a href="#" style="margin-bottom: 5px;"><i class="fa-solid fa-user"></i> MINHA CONTA</a></li>
                    <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> CARRINHO</a></li>
                </ul>
            </div>

            <div class="buy-actions">
                <a href="#" id="abrirModal">
                    <img src="../imgs/User.png" alt="Usuário" width="30px">
                </a>

                <a href="#">
                    <img src="../imgs/Shopping cart.png" alt="Carrinho" width="30px">
                </a>
            </div>
        </div>

        <div class="aaa">
            <form method="post" class="barra-pesquisa">
                <input type="text" name="consulta" id="consulta" class="pesquisa-input" placeholder="Digite o Nome do Produto" style="padding-left: 10px;">
                <button type="submit" class="botao-pesquisa" style="background-color: transparent; border: none;">
                    <img src="../imgs/lupa (1).png" style="width: 25px;" alt="" class="search-image">
                </button>
            </form>
        </div>


    </nav>
     <!-- Modal -->
     <div id="meuModal" class="modal-container">
        <div class="modal-content col-3">
            <a href="../php/cadastro.php">Cadastre-se</a>
            <a href="../php/login.php">Entrar</a>
            <button id="fecharModal">Fechar</button>
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
                                    <input type="button" id="minus_<?= $produto['id'] ?>" value="-" onclick="process(-1, 'quant_<?= $produto['id'] ?>')" class="campo"  />
                                    <input id="quant_<?= $produto['id'] ?>" name="quant" class="text" size="1" type="text" value="0" maxlength="5" />
                                    <input type="button" id="plus_<?= $produto['id'] ?>" value="+" onclick="process(1, 'quant_<?= $produto['id'] ?>')"   class="campo"/>
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

    <!--------------SCRIPTS-------------->
    <
        <script src="../js/scripts.js">
        </script>
        <script src="../js/dropDown-menu.js"></script>
        <script src="../js/funcao.js"></script>
        <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>


</body>

</html>