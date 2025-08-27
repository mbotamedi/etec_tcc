<?php
// Inclui o arquivo de verificação de login
session_start();
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
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
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">
    <link rel="stylesheet" href="../css/mediaQuery.css">


    <!--FONTS---->
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

    <style>
        /*CONTROLE CARROSEL CELULAR 360px */

        @media (max-width: 360px) {
            .carousel-control-next-icon {
                margin-top: 50px;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation-->

    <?php
    include("navbar.php");
    include("nav_cat.php");

    ?>

    <!-- Navigation End-->

    <div class="carrosel" style="display: flex; justify-content: center;">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <a href="../carrinho/addPromocao.php?id_promo=1" title="Adicionar promoção ao carrinho">
                        <img src="../assets/img/promocoes_notebook/promo1.jpg" alt="Promoção Coxinhas e Refrigerante" class="d-block w-100">
                    </a>
                </div>

                <div class="carousel-item">
                    <a href="../carrinho/addPromocao.php?id_promo=2" title="Adicionar promoção ao carrinho">
                        <img src="../assets/img/promocoes_notebook/promo2.jpg" alt="Promoção 2 Lanche e Refrigerante" class="d-block w-100">
                    </a>
                </div>

            </div>

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

    <!-- Section-->

    <section class="py-5">

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                // Inclui o arquivo de pesquisa que agora contém a lógica de paginação
                include("../includes/pesquisa.php");
                if (empty($produtos)) {
                    echo '<div style="height: 20%; width:60%;">
                        <div class="alert alert-info d-flex align-items-center justify-content-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>
                                Sua busca não retornou produtos. Tente de novo.
                            </div>
                        </div>
                    </div>';
                } else {

                    // Loop para exibir os produtos da página atual
                    foreach ($produtos as $produto):
                        $em_promocao = !is_null($produto['desconto']) && $produto['desconto'] > 0;

                ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-img-container">
                                    <?php $foto = '../assets/fotos/' . $produto["id"] . '.png'; ?>
                                    <img class="card-img-top" src="<?php echo $foto ?>" style=" padding-top: 5px; width:200px; height:200px; margin:auto" alt="<?php echo htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title"><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></h5>
                                    <?php if ($em_promocao): ?>
                                        <span class="text-muted text-decoration-line-through">R$ <?= number_format($produto['valor_original'], 2, ',', '.') ?></span>
                                        <span style="color:red; font-weight:bold;">R$ <?= number_format($produto['valor_promocional'], 2, ',', '.') ?></span>
                                    <?php else: ?>
                                        R$ <?= number_format($produto['valor_original'], 2, ',', '.') ?>
                                    <?php endif; ?>
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
                <?php endforeach;
                }
                ?>
            </div>

            <?php

            // Só exibe a paginação se houver mais de uma página
            if ($total_paginas > 1):

                // Pega todos os parâmetros GET atuais (ex: 'subCategoria', 'consulta', etc.)
                $parametros_atuais = $_GET;
            ?>
                <nav aria-label="Navegação de página de produtos">
                    <ul class="pagination justify-content-center mt-5">

                        <li class="page-item <?= ($pagina_atual <= 1) ? 'disabled' : '' ?>">
                            <?php
                            $parametros_atuais['pagina'] = $pagina_atual - 1;
                            $query_string = http_build_query($parametros_atuais);
                            ?>
                            <a class="page-link" href="?<?= $query_string ?>" aria-label="Anterior">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <?php
                            $parametros_atuais['pagina'] = $i;
                            $query_string = http_build_query($parametros_atuais);
                            ?>
                            <li class="page-item <?= ($i == $pagina_atual) ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= $query_string ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= ($pagina_atual >= $total_paginas) ? 'disabled' : '' ?>">
                            <?php
                            $parametros_atuais['pagina'] = $pagina_atual + 1;
                            $query_string = http_build_query($parametros_atuais);
                            ?>
                            <a class="page-link" href="?<?= $query_string ?>" aria-label="Próxima">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            <?php
            endif;
            ?>
        </div>
    </section>

    <!---Footer--->
    <?php include("footer.php"); ?>
    <?php include("zap.php"); ?>
    <!---Footer End--->

    <!--------------SCRIPTS-------------->
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/funcao.js"></script>
    <script src="../js/controlaModal.js"></script>
    <script src="../js/carrinho.js"></script>
    <!--------------SCRIPTS/-------------->


</body>

</html>