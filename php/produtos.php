<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina Três Irmãos</title>
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

    <?php include("navbarprod.php"); ?>
    <!-- Navigation End-->
    <!-- Section-->
    <section class="py-5">

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                include("../includes/pesquisa.php");
                foreach ($produtos as $produto):
                    $em_promocao = !is_null($produto['desconto']);
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-img-container">
                                <?php $foto = '../assets/fotos/' . $produto["id"] . '.png'; ?>
                                <img class="card-img-top" src="<?php echo $foto ?>" style=" padding-top: 5px; width:200px; height:200px; margin:auto" alt="<?php echo htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="card-body p-4">
                                <h5 class="card-title"><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></h5>
                                <!---<p class="card-text"><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></p>--->
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
                <?php endforeach; ?>
            </div>
        </div>

    </section>
    <!-- Section End-->

    <!---Footer--->
    <?php include("footer.php"); ?>
    <!---Footer End--->

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

</body>

</html>