<?php

include('../carrinho/pedidos/detalhes_pedidos.php');


?>


    
<style>
    .card {
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .card-header {
        border-radius: 10px 10px 0 0;
        padding: 15px;
        font-weight: bold;
    }
    .card-body {
        padding: 20px;
    }
    .table {
        border-radius: 8px;
        overflow: hidden;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 1rem;
        padding: 8px 12px;
    }
    @media (max-width: 768px) {
        .card {
            margin-bottom: 15px;
        }
        .img-product {
            width: 50px;
            height: 50px;
        }
    }
</style>