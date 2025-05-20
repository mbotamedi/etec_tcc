<style>
    .whatsapp-float {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .whatsapp-float img {
        width: 60px; /* Ajuste o tamanho conforme necessário */
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
</style>

<div class="whatsapp-float">
    <a href="https://wa.me/SEUNUMERO" target="_blank" rel="noopener">
        <img src="../imgs/zapImg.png" alt="WhatsApp">
    </a>
</div>  