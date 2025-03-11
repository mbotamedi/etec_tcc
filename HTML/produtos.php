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
     
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar" style="width: 100%; background-color: rgba(0, 0, 0, 0.791);">
        <div class="container-fluid px-4 px-lg-5">
            <div class="imagem col-2">
                <img src="../imgs/logo_copia01.png" alt="" width="100px">
            </div>

            <div class="items col-5">
                <a href="../index.php">INICIO</a>
                <a href="../html/produtos.php">PEÇA AGORA</a>
                <a href="../html/unidades.html">UNIDADES</a>

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


    </nav>
    <!-- Navigation End-->
    <!-- Section-->
    <section class="py-5">

        <div class="titulo-pricipal">
            <h1 class="produtos-Destaques">Produto Cantina</h1>
        </div>
        <?php
        // Inclui o arquivo de conexão
        include("../includes/conexao.php");

        // Executa a consulta usando MySQLi
        $query = "SELECT * FROM tb_produtos order by descricao";
        $resultado = mysqli_query($conexao, $query);

        // Verifica se a consulta foi bem-sucedida
        if (!$resultado) {
            die("Erro na consulta: " . mysqli_error($conexao));
        }

        // Busca todos os produtos
        $produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        ?>

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($produtos as $produto): ?>
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
                                <label>Quantidade:</label>
                                <input type="button" id="minus_<?= $produto['id'] ?>" value="-" onclick="process(-1, 'quant_<?= $produto['id'] ?>')" />
                                <input id="quant_<?= $produto['id'] ?>" name="quant" class="text" size="1" type="text" value="0" maxlength="5" />
                                <input type="button" id="plus_<?= $produto['id'] ?>" value="+" onclick="process(1, 'quant_<?= $produto['id'] ?>')" />
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
            <p class="m-0 text-center text-white">Copyright &copy; WebSolution 2025</p>
        </div>
    </footer>

    <!-- Footer End-->

    <!--------------SCRIPTS-------------->
    <script src="../js/funcao.js"></script>
    

</body>

</html>