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
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: all 0.3s ease;
    }

    .whatsapp-float img {
        width: 60px;
        height: auto;
    }

    .whatsapp-float:hover {
        transform: scale(1.1);
    }

    @media (max-width: 768px){
        .whatsapp-float {
            bottom: 15px;
            right: 15px;
        }

        .whatsapp-float img {
            width: 40px;
        }
    }

    @media (max-width: 364px){
       
    }

    .mensagem {
        background-color: #40ce00;
        color: white;
        font-family: monospace;
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        position: relative;
        max-width: 130px;
        text-align: center;
    }

    .mensagem::after {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border: 10px solid transparent;
        border-top-color: #40ce00;
    }
</style>

<?php if (!$paginaSelecionada): ?>
    <div class="container">
        <div class="whatsapp-float">
            <div class="mensagem">
                FALE PELO WHATSAPP
            </div>
            <a href="https://wa.me/+5516988543993" target="_blank" rel="noopener">
                <img src="../assets/img/zapImg.png" alt="WhatsApp">
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="container">
        <div class="whatsapp-float">
            <div class="mensagem">
                <p class="msg-zap">FALE PELO WHATSAPP</p>
            </div>
            <a href="https://wa.me/+5516988543993" target="_blank" rel="noopener">
                <img src="../../assets/img/zapImg.png" alt="WhatsApp">
            </a>
        </div>
    </div>
<?php endif; ?>
