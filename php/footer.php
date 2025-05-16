<?php
$current_page = basename($_SERVER['PHP_SELF']);
$is_finalizar_pedido =
    ($current_page == 'cadastro_endereco.php' ||
        $current_page == 'finalizar_pedido.php' ||
        $current_page == 'pedidos_cliente.php' ||
        $current_page == 'confirmacao_pedido.php'
    );
?>

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
    <link rel="stylesheet" href="../css/mediaQuery.css" />
</head>

<?php if (!$is_finalizar_pedido): ?>
    <footer class="py-5 bg-dark">
        <div class="info-footer">
            <div class="information-divs">
                <h2 style="color: white;">Sobre nós</h2>
                <ul class="ul-content">
                    <li><a href="unidades.php">Nossa história</a></li>
                    <li><a href="termos_Uso.php">Termos de uso</a></li>
                </ul>
            </div>
            <div class="information-divs">
                <h2 style="color: white;">Dúvidas</h2>
                <ul class="ul-content">
                    <li><a href="compra_segura.php">É seguro comprar?</a></li>
                    <li><a href="info_pedidos.php">Como funciona os Pedidos</a></li>
                    <li><a href="reembolso.php">Política de Reembolso</a></li>
                </ul>
            </div>
            <div class="information-divs">
                <h2 style="color: white;">Atendimento</h2>
                <ul class="ul-content">
                    <li><a href="faleConosco.php">Fale conosco</a></li>
                </ul>
            </div>
        </div>
        <div>
            <p class="m-0 text-center text-white">Copyright &copy; Cantina Três Irmãos</p>
        </div>
    </footer>
<?php else: ?>
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
<?php endif; ?>