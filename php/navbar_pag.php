<?php
$current_page = basename($_SERVER['PHP_SELF']);
$is_finalizar_pedido = ($current_page == 'cadastro_endereco.php' || $current_page == 'finalizar_pedido.php' || $current_page == 'pedidos_cliente.php' || $current_page == 'confirmacao_pedido.php' );
?>

<head>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/mediaQuery.css">

</head>


    <nav class="navbar">
        <div class="nav-top">
            <div class="logo">
                <img src="../assets/img/logo_copia01.png" alt="Logo Cantina" width="100px">
            </div>
            <div class="menu" id="menu">
                <ul>
                    <li><a href="../index.php" class="titulo">INICIO</a></li>
                    <li><a href="../php/produtos.php" class="titulo">PEÇA AGORA</a></li>
                    <li><a href="../php/unidades.php" class="titulo">UNIDADES</a></li>
                </ul>
            </div>
            <div></div>  
        </div>
    </nav>

    

