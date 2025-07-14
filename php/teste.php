<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido - Cantina Três Irmãos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">
    <link rel="stylesheet" href="../css/mediaQuery.css">
    <link rel="icon" type="image/x-icon" href="../../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        .cart-container {
            max-width: 340px;
            margin: 0 auto;
            padding-top: 10px;
        }

        .container-finalizar {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .endereco-list,
        .tipo-entrega-options {
            margin-bottom: 20px;
        }

        .endereco-item {
            display: flex;
            align-items: flex-start;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .endereco-item input[type="radio"] {
            margin-right: 15px;
            margin-top: 5px;
        }

        .endereco-item label {
            flex: 1;
            text-align: left;
            line-height: 1.5;
        }

        .btn-finalizar {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 300px;
        }

        .btn-finalizar:hover {
            background-color: #218838;
        }

        .tipo-entrega-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .tipo-entrega-option:has(input:checked) {
            border-color: #28a745;
            background-color: #e9f5ec;
        }

        .tipo-entrega-option input {
            margin-right: 10px;
        }

        #endereco-section {
            display: none;
        }

        .erro {
            color: #D8000C;
            background-color: #FFD2D2;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .container-buttonConcluir {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

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
                    <img src="../../assets/img/user.png" alt="Usuário" width="30px">
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
                            Maria Hernandes Silva </span></h5>
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

                    <li class="li-items"><a href="../../index.php">Home</a></li>
                    <li class="li-items"><a href="../../php/produtos.php">Produtos</a></li>
                    <li class="li-items"><a href="../../php/unidades.php">Unidades</a></li>

                    <li class="li-items"><a href="../../carrinho/pedidos/pedidos_cliente.php">Pedidos/Compras</a></li>
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
            <style>
                .cart-item {
                    display: flex;
                    flex-direction: column;
                    width: 300px;
                    padding: 10px;
                    border: 1px solid #e0e0e0;
                    border-radius: 10px;
                    margin-bottom: 10px;
                    background-color: #fff;
                }

                .cart-item .top-row {
                    display: flex;
                    align-items: center;
                    margin-bottom: 10px;
                }

                .cart-item img {
                    max-width: 50px;
                    height: auto;
                    margin-right: 10px;
                }

                .cart-item .description {
                    font-size: 12px;
                    color: #333;
                    flex: 1;
                }

                .cart-item .bottom-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .cart-item .quantity-controls {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .cart-item .quantity-controls a {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 24px;
                    height: 24px;
                    background-color: #f5f5f5;
                    color: #333;
                    font-size: 14px;
                    font-weight: 600;
                    text-decoration: none;
                    border: 1px solid #e0e0e0;
                    border-radius: 4px;
                    transition: background-color 0.3s ease, color 0.3s ease;
                }

                .cart-item .quantity-controls a:hover {
                    background-color: #ddd;
                    color: #000;
                }

                .cart-item .quantity-controls span {
                    font-size: 14px;
                    color: #333;
                    min-width: 20px;
                    text-align: center;
                }

                .cart-item .unit-price {
                    font-size: 12px;
                    color: #666;
                }

                .total-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    font-size: 14px;
                    font-weight: 600;
                    color: #333;
                    margin-top: 20px;
                    padding: 0;
                }

                .offcanvas-cart-buttons {
                    margin-top: 20px;
                    display: flex;
                    justify-content: center;
                    gap: 20px;
                    /* Aumentado o espaço entre os botões */
                    margin-bottom: 10px;
                }

                .close-btn {
                    background: none;
                    border: none;
                    font-size: 24px;
                    cursor: pointer;
                    color: #777;
                }

                .close-btn:hover {
                    color: #000;
                }

                h3 {
                    font-size: 18px;
                    color: #777;
                    text-align: center;
                    margin-top: 20px;
                }

                .button-clear {
                    color: red;
                    /* Cor do texto padrão */
                    text-decoration: underline;
                    /* Deixa o texto sublinhado */
                    transition: color 0.3s ease-in-out;
                    /* Transição suave para a cor */
                    cursor: pointer;
                    /* Indica que é clicável */
                }

                .button-clear:hover {
                    color: rgb(198, 0, 0);
                    /* Cor vermelha escura ao passar o mouse */
                }
            </style>
            <div>
                <div class="cart-item">
                    <div class="top-row"><img src="../../assets/fotos/7.png" alt="SANDUÍCHE COM PEITO DE PERU E QUEIJO">
                        <div class="description">SANDUÍCHE COM PEITO DE PERU E QUEIJO</div>
                    </div>
                    <div class="bottom-row">
                        <div class="quantity-controls">
                            <a href="../carrinho/alteraQtd.php?id=0&acao=subtrair">−</a>
                            <span>1</span>
                            <a href="../carrinho/alteraQtd.php?id=0&acao=somar">+</a>
                        </div>
                        <div class="unit-price">R$6,50 (unitário)</div>
                        <div><a href="../carrinho/delCarrinho.php?id=0"><i class="fas fa-trash deleta"></i></a></div>
                    </div>
                </div>
                <div class="cart-item">
                    <div class="top-row"><img src="../../assets/fotos/57.png" alt="COCA-COLA">
                        <div class="description">COCA-COLA</div>
                    </div>
                    <div class="bottom-row">
                        <div class="quantity-controls">
                            <a href="../carrinho/alteraQtd.php?id=1&acao=subtrair">−</a>
                            <span>1</span>
                            <a href="../carrinho/alteraQtd.php?id=1&acao=somar">+</a>
                        </div>
                        <div class="unit-price">R$4,50 (unitário)</div>
                        <div><a href="../carrinho/delCarrinho.php?id=1"><i class="fas fa-trash deleta"></i></a></div>
                    </div>
                </div>
                <div class="total-row"><span>Total:</span><span>R$11,00</span></div>
                <div class="offcanvas-cart-buttons" style="display: none;"><button class="btn btn-secondary" data-bs-dismiss="offcanvas">Continuar</button><a href="../carrinho/pedidos/finalizar_pedido.php" class="btn btn-primary">Finalizar</a></div>
            </div>
        </div>
    </div>


    <section class="py-5">
        <div class="container-finalizar">
            <h2>Finalizando Pedido</h2>
            <h3>Resumo do Carrinho</h3>
            <div class="cart-container">
                <style>
                    .cart-item {
                        display: flex;
                        flex-direction: column;
                        width: 300px;
                        padding: 10px;
                        border: 1px solid #e0e0e0;
                        border-radius: 10px;
                        margin-bottom: 10px;
                        background-color: #fff;
                    }

                    .cart-item .top-row {
                        display: flex;
                        align-items: center;
                        margin-bottom: 10px;
                    }

                    .cart-item img {
                        max-width: 50px;
                        height: auto;
                        margin-right: 10px;
                    }

                    .cart-item .description {
                        font-size: 12px;
                        color: #333;
                        flex: 1;
                    }

                    .cart-item .bottom-row {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }

                    .cart-item .quantity-controls {
                        display: flex;
                        align-items: center;
                        gap: 5px;
                    }

                    .cart-item .quantity-controls a {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        width: 24px;
                        height: 24px;
                        background-color: #f5f5f5;
                        color: #333;
                        font-size: 14px;
                        font-weight: 600;
                        text-decoration: none;
                        border: 1px solid #e0e0e0;
                        border-radius: 4px;
                        transition: background-color 0.3s ease, color 0.3s ease;
                    }

                    .cart-item .quantity-controls a:hover {
                        background-color: #ddd;
                        color: #000;
                    }

                    .cart-item .quantity-controls span {
                        font-size: 14px;
                        color: #333;
                        min-width: 20px;
                        text-align: center;
                    }

                    .cart-item .unit-price {
                        font-size: 12px;
                        color: #666;
                    }

                    .total-row {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        font-size: 14px;
                        font-weight: 600;
                        color: #333;
                        margin-top: 20px;
                        padding: 0;
                    }

                    .offcanvas-cart-buttons {
                        margin-top: 20px;
                        display: flex;
                        justify-content: center;
                        gap: 20px;
                        /* Aumentado o espaço entre os botões */
                        margin-bottom: 10px;
                    }

                    .close-btn {
                        background: none;
                        border: none;
                        font-size: 24px;
                        cursor: pointer;
                        color: #777;
                    }

                    .close-btn:hover {
                        color: #000;
                    }

                    h3 {
                        font-size: 18px;
                        color: #777;
                        text-align: center;
                        margin-top: 20px;
                    }

                    .button-clear {
                        color: red;
                        /* Cor do texto padrão */
                        text-decoration: underline;
                        /* Deixa o texto sublinhado */
                        transition: color 0.3s ease-in-out;
                        /* Transição suave para a cor */
                        cursor: pointer;
                        /* Indica que é clicável */
                    }

                    .button-clear:hover {
                        color: rgb(198, 0, 0);
                        /* Cor vermelha escura ao passar o mouse */
                    }
                </style>
                <div>
                    <div class="cart-item">
                        <div class="top-row"><img src="../../assets/fotos/7.png" alt="SANDUÍCHE COM PEITO DE PERU E QUEIJO">
                            <div class="description">SANDUÍCHE COM PEITO DE PERU E QUEIJO</div>
                        </div>
                        <div class="bottom-row">
                            <div class="quantity-controls">
                                <a href="../carrinho/alteraQtd.php?id=0&acao=subtrair">−</a>
                                <span>1</span>
                                <a href="../carrinho/alteraQtd.php?id=0&acao=somar">+</a>
                            </div>
                            <div class="unit-price">R$6,50 (unitário)</div>
                            <div><a href="../carrinho/delCarrinho.php?id=0"><i class="fas fa-trash deleta"></i></a></div>
                        </div>
                    </div>
                    <div class="cart-item">
                        <div class="top-row"><img src="../../assets/fotos/57.png" alt="COCA-COLA">
                            <div class="description">COCA-COLA</div>
                        </div>
                        <div class="bottom-row">
                            <div class="quantity-controls">
                                <a href="../carrinho/alteraQtd.php?id=1&acao=subtrair">−</a>
                                <span>1</span>
                                <a href="../carrinho/alteraQtd.php?id=1&acao=somar">+</a>
                            </div>
                            <div class="unit-price">R$4,50 (unitário)</div>
                            <div><a href="../carrinho/delCarrinho.php?id=1"><i class="fas fa-trash deleta"></i></a></div>
                        </div>
                    </div>
                    <div class="total-row"><span>Total:</span><span>R$11,00</span></div>
                    <div class="offcanvas-cart-buttons" style="display: none;"><button class="btn btn-secondary" data-bs-dismiss="offcanvas">Continuar</button><a href="../carrinho/pedidos/finalizar_pedido.php" class="btn btn-primary">Finalizar</a></div>
                </div>
            </div>

            <form method="POST" action="finalizar_pedido.php">
                <h3>Escolha a Forma de Recebimento</h3>
                <div class="tipo-entrega-options">
                    <label class="tipo-entrega-option">
                        <input type="radio" name="tipo_entrega" value="retirada" checked onclick="toggleEndereco(false)">
                        <div>
                            <strong>Retirar na Cantina</strong>
                            <p>Você pode retirar seu pedido no balcão da cantina.</p>
                        </div>
                    </label>

                    <label class="tipo-entrega-option">
                        <input type="radio" name="tipo_entrega" value="entrega" onclick="toggleEndereco(true)">
                        <div>
                            <strong>Entrega</strong>
                            <p>Entregamos no endereço cadastrado.</p>
                        </div>
                    </label>
                </div>

                <div id="endereco-section">
                    <h3>Selecione o Endereço de Entrega</h3>
                    <div class="endereco-list">
                        <div class="endereco-item">
                            <input type="radio" name="id_endereco" value="1">
                            <label>
                                <strong>Casa</strong><br>
                                Rua Tiburcio Gonçalves Filhos, 183<br>
                                Centro - CEP: 14700-470<br>
                                BEBEDOURO - SP </label>
                        </div>
                    </div>
                </div>

                <h3>Pagamento</h3>
                <!---<div class="tipo-entrega-options">
                    <label class="tipo-entrega-option">
                        <input type="radio" name="metodo_pagamento" value="dinheiro" required>
                        <div>
                            <strong>Dinheiro</strong>
                            <p>Pagamento em dinheiro na entrega ou retirada.</p>
                        </div>
                    </label>
                    <label class="tipo-entrega-option">
                        <input type="radio" name="metodo_pagamento" value="cartao">
                        <div>
                            <strong>Cartão</strong>
                            <p>Pagamento com cartão na entrega ou retirada.</p>
                        </div>
                    </label>---->
                <label class="tipo-entrega-option">
                    <input type="radio" name="metodo_pagamento" value="online" checked>
                    <div>
                        <strong>Online</strong>
                        <p>Pagamento via PIX ou Cartão de Crédito.</p>
                    </div>
                </label>
        </div>
        <div class="container-buttonConcluir">
            <button type="submit" class="btn-finalizar">Finalizar Pedido</button>
        </div>
        </form>

        </div>
    </section>


    <style>
        .info-footer {
            display: flex;
            justify-content: center;
            gap: 100px;
        }

        .ul-content {
            list-style: none;
        }
    </style>



    <head>
        <link rel="stylesheet" href="../../css/mediaQuery.css" />
    </head>
    <footer class="py-5 bg-dark">
        <div class="info-footer">
            <div class="information-divs">
                <h2 style="color: white;" class="ul-title">Sobre nós</h2>
                <ul class="ul-content">
                    <li><a href="../../php/unidades.php">Nossa história</a></li>
                    <li><a href="../../php/termos_Uso.php">Termos de uso</a></li>
                </ul>
            </div>
            <div class="information-divs">
                <h2 style="color: white;" class="ul-title">Dúvidas</h2>
                <ul class="ul-content">
                    <li><a href="../../php/compra_segura.php">É seguro comprar?</a></li>
                    <li><a href="../../php/info_pedidos.php">Como funciona os Pedidos</a></li>
                    <li><a href="../../php/reembolso.php">Política de Reembolso</a></li>
                </ul>
            </div>
            <div class="information-divs">
                <h2 style="color: white;" class="ul-title">Atendimento</h2>
                <ul class="ul-content">
                    <li><a href="../../php/faleConosco.php">Fale conosco</a></li>
                </ul>
            </div>
        </div>
        <div>
            <p class="m-0 text-center text-white">Copyright &copy; Cantina Três Irmãos</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/carrinho.js"></script>
    <script>
        function toggleEndereco(show) {
            const enderecoSection = document.getElementById('endereco-section');
            const enderecoInputs = enderecoSection.querySelectorAll('input[name="id_endereco"]');

            if (show) {
                enderecoSection.style.display = 'block';
                if (enderecoInputs.length > 0) {
                    // Marca o primeiro endereço como obrigatório e selecionado por padrão
                    enderecoInputs.forEach((input, index) => {
                        input.required = true;
                        if (index === 0) input.checked = true;
                    });
                } else {
                    // Se não houver endereço, redireciona para o cadastro
                    alert('Nenhum endereço cadastrado. Você será redirecionado para cadastrar um.');
                    window.location.href = '../cadastro_endereco.php?retorno=./finalizar_pedido.php';
                }
            } else {
                enderecoSection.style.display = 'none';
                enderecoInputs.forEach(input => {
                    input.required = false;
                    input.checked = false;
                });
            }
        }
    </script>
</body>

</html>