<?php
$current_page = basename($_SERVER['PHP_SELF']);
$paginaSelecionada = ($current_page == 'pedidos_cliente.php');
?>
<style>
    .whatsapp-float {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .whatsapp-float img {
        width: 60px;
        /* Ajuste o tamanho conforme necessário */
        height: auto;
    }

    /* Efeito hover opcional */
    .whatsapp-float:hover {
        transform: scale(1.1);
    }

    /* Versão para mobile */
    @media (max-width: 768px) {
        .whatsapp-float {
            bottom: 15px;
            right: 15px;
        }

        .whatsapp-float img {
            width: 50px;
        }
    }

    .mensagem{
        padding: 5px;
        background-color: #40ce00;
        border-radius: 10px;
        padding-top: 10px;
        font-family: monospace; 
        color: white;
    }
</style>

<?php if (!$paginaSelecionada): ?>

    <div class="container">

        <div class="whatsapp-float">
            <div class="mensagem">
                <p>FALE PELO WHATSAPP</p>
            </div>
            <a href="https://wa.me/+5516988543993" target="_blank" rel="noopener">
                <img src="../imgs/zapImg.png" alt="WhatsApp">
            </a>
        </div>
    </div>

<?php else: ?>
    <div class="container">
        <div class="whatsapp-float">
            <div class="mensagem">
                <p>FALE PELO WHATSAPP</p>
            </div>
            <a href="https://wa.me/+5516988543993" target="_blank" rel="noopener">
                <img src="../../imgs/zapImg.png" alt="WhatsApp">
            </a>
        </div>
    </div>
<?php endif; ?>