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
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/unidades.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">
    <link rel="stylesheet" href="../css/mediaQuery.css">

    <!--FONTS---->
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>

    <!-- Navigation-->
    <?php include("navbar.php"); ?>
    <!-- Navigation End-->

    </div>

    <section class="#">
        <div class="container-info col-12">
            <div class="container col-12" style="display: flex;">
                <div class="foto01-cantina">
                    <img src="../assets/img/cantina.jpg" alt="Logo" style="width: 100%; height: 100%;">
                </div>

                <div class="sobre-cantina">
                    <h2 class="header-title">CANTINA TRÊS IRMÃOS - UNIDADE ETEC IDIO ZUCCHI</h2>
                    <p>A Cantina Três Irmãos na ETEC Bebedouro é o lugar ideal para uma pausa saborosa durante o dia.
                        Fundada em 2020, tornamos referência dentro das escolas, e nós estamos aqui para complementar
                        essa experiência com opções práticas e deliciosas.

                        Complementando com o nosso cardápio temos diversas opções de salgados, incluindo opções assadas
                        e fritas,
                        perfeitos para um intervalo rápido ou para recarregar as energias entre as aulas. Tudo é
                        preparado com cuidado e qualidade, garantindo sabor e praticidade.

                        A Cantina Três Irmãos é mais do que um local para comer; é um espaço de convívio e descontração
                        para a comunidade da ETEC. Venha nos visitar e experimente nossas opções!</p>
                </div>
            </div>

        </div>
    </section>
    <section class="sec-02">
        <div class="container col-12" style="display: flex;">


            <div class="sobre-cantina">
                <h2 class="header-title">CANTINA TRÊS IRMÃOS - UNIDADE IMESB VOCÊ</h2>
                <p>Na unidade IMESB, a Cantina Três Irmãos é o ponto certo para uma pausa rápida e saborosa. Fundado
                    nossa unidade em
                    2022, o IMESB já é um importante centro de ensino superior, e nós estamos aqui para oferecer
                    opções leves e práticas para alunos, professores e colaboradores.

                    Nosso cardápio inclui lanches naturais e salgados, com opções assadas e fritas, ideais para quem
                    busca algo rápido e gostoso. Tudo é preparado com qualidade, pensando no seu bem-estar e no seu
                    dia a dia.

                    A Cantina Três Irmãos é mais do que um local para comer; é um espaço de <br>
                    integração e convívio
                    para a comunidade do IMESB. Venha nos visitar e aproveite nossas delícias!</p>
            </div>
            <div class="foto01-cantina">
                <img src="../assets/img/cantinaImesb.jpg" alt="Logo" style="width: 100%; height: 100%;">
            </div>
        </div>
    </section>

    <!-- Section End-->

    <!---Footer--->
    <?php include("footer.php"); ?>
    <?php
    include("./zap.php")
    ?>
    <!---Footer End--->




    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--------------SCRIPTS-------------->
    <script src="../js/"></script>
    <script src="../js/funcao.js"></script>
    <script src="../js/controlaModal.js"></script>


    <!--------------SCRIPTS/-------------->


</body>

</html>