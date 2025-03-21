<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
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
                <a href="index.html">INICIO</a>
                <a href="#">PEÇA AGORA</a>
                <a href="HTML/unidades.html">UNIDADES</a>
                
            </div>

            <div class="menu-toggle">
                <img src="imgs/cardapio (1).png" alt="" width="32px">
                <ul class="menu">
                    <li><a href="index.html" style="margin-bottom: 5px;"><i class="fa-solid fa-house"></i> INICIO</a>
                    </li>
                    <li><a href="#" style="margin-bottom: 5px;"><i class="fa-solid fa-cart-plus"></i> PEÇA AGORA</a>
                    </li>
                    <li><a href="./HTML/unidades.html" style="margin-bottom: 5px;"><i class="fa-solid fa-building"></i> UNIDADES</a></li>
                    <li><a href="#" style="margin-bottom: 5px;"><i class="fa-solid fa-user"></i> MINHA CONTA</a></li>
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

    <!-- Modal -->
    <div id="meuModal" class="modal-container">
        <div class="modal-content col-3">
            <a href="HTML/cadastro.php">Cadastre-se</a>
            <a href="HTML/login.html">Entrar</a>
            <button id="fecharModal">Fechar</button>
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
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="./imgs/imagem/kitcat.png" alt="Kitcat" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"> Chocolate Kitkat 40gr</h5>
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through">R$12.00</span>
                                R$5.00
                            </div>
                            <div class="d-flex justify-content-center small text-warning mb-2">
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">COMPRA RÁPIDA</a></div>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Sale badge-->
                        
                        <!-- Product image-->
                        <img class="card-img-top" src="imgs/imagem/trento.jpg" alt="Trento" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"> Chocolate Trento 32gr </h5>
                                
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through">R$ 10,00</span>
                                R$ 8,50
                            </div>
                             <!-- Product reviews-->
                             <div class="d-flex justify-content-center small text-warning mb-2">
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">COMPRA RÁPIDA</a></div>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Sale badge-->
                        
                        <!-- Product image-->
                        <img class="card-img-top" src="imgs/imagem/barra cerral.jpeg" alt="barra" />
                        <!-- Product details-->
                         
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"> Barra de cereal Nutry 22gr</h5>
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through">R$10.00</span>
                                R$6.00
                            </div>
                             <!-- Product reviews-->
                             <div class="d-flex justify-content-center small text-warning mb-2">
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">COMPRA RÁPIDA</a></div>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="imgs/imagem/Fini Tubes Doce Tutti Frutti.jpeg" Fini" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">Fini Tubes - Diversos Sabores</h5>
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through">R$12.00</span>
                                R$7,50
                            </div>
                             <!-- Product reviews-->
                             <div class="d-flex justify-content-center small text-warning mb-2">
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">COMPRA RÁPIDA</a></div>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Sale badge-->
                        
                        <!-- Product image-->
                        <img class="card-img-top" src="imgs/imagem/sonodevalsa.jpeg" alt="bombons" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">Bombom Sonho de Valsa</h5>
                                <!-- Product price-->
                                
                                <span class="text-muted text-decoration-line-through">R$2,50</span>
                                R$1,50
                            </div>
                             <!-- Product reviews-->
                             <div class="d-flex justify-content-center small text-warning mb-2">
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                            </div>
                            
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">COMPRA RÁPIDA</a></div>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="imgs/imagem/Bis.jpeg" alt="Bis" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">Chocolate Bis Extra Original</h5>
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through">$20.00</span>
                                $18.00
                            </div>
                             <!-- Product reviews-->
                             <div class="d-flex justify-content-center small text-warning mb-2">
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">COMPRA AGORA</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Sale badge-->
                        
                        <!-- Product image-->
                        <img class="card-img-top" src="imgs/imagem/nikito.jpeg" alt="nikito" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">Bolacha Nikito - Diversos Sabores</h5>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through">$20.00</span>
                                $18.00
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">COMPRA RÁPIDA</a></div>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="imgs/imagem/Melancia Azedinha fini.jpg" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">Fini Melancia Azedinha</h5>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through">R$12,00</span>
                                $7,50
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">COMPRA RÁPIDA</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; WebSolution 2025</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>



    <!--------------SCRIPTS-------------->

    <script src="js/scripts.js"></script>
    <script src="js/dropDown-menu.js"></script>

    <!--------------SCRIPTS/-------------->


</body>

</html>