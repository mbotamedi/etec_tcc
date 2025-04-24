<?php
include 'verificar_login.php';
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Política de Devolução e Reembolso - Cantina Três Irmãos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="../css/footer.css" />
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Inter', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container-politica {
            max-width: 960px;
            margin: 60px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
        }

        .container-politica h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #2d3436;
            border-bottom: 3px solid #27ae60;
            display: inline-block;
            padding-bottom: 8px;
        }

        .container-politica h2 {
            margin-top: 35px;
            font-size: 1.75rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .container-politica p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #444;
        }

        .highlight {
            background-color: #eafaf1;
            padding: 15px 20px;
            border-left: 5px solid #27ae60;
            margin: 20px 0;
            border-radius: 4px;
            font-size: 1rem;
            color: #2c3e50;
        }

        ul {
            padding-left: 20px;
            margin-bottom: 25px;
        }

        ul li {
            margin-bottom: 12px;
            font-size: 1.05rem;
            position: relative;
            padding-left: 25px;
        }

        ul li::before {
            position: absolute;
            left: 0;
            top: 0;
            color: #27ae60;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <?php include("navbar.php"); ?>

    <div class="container-politica">
        <h1>Política de Devolução e Reembolso - Cantina Três Irmãos</h1>

        <p>Na <strong>Cantina Três Irmãos</strong>, nossa missão é garantir a satisfação de todos os nossos clientes. Trabalhamos com o sistema de pagamentos do <strong>Mercado Pago</strong> para proporcionar a maior segurança nas suas transações.</p>

        <div class="highlight">
            <strong>Proteção ao comprador:</strong> Caso seu pedido não seja retirado ou apresente algum problema, você poderá solicitar o reembolso diretamente pela plataforma do Mercado Pago.
        </div>

        <h2>1. Pedidos Não Retirados</h2>
        <p>Se, por algum motivo, o pedido não for retirado dentro do horário determinado na cantina, você poderá solicitar o reembolso do valor pago.</p>
        <ul>
            <li>Você pode solicitar o reembolso dentro de <strong>24 horas após o horário da retirada</strong>.</li>
            <li>Entre em contato conosco pelo e-mail <strong>suportecantina@gmail.com</strong> ou pelo nosso chat online.</li>
        </ul>

        <h2>2. Produtos com Defeito ou Incorretos</h2>
        <p>Se o produto recebido estiver com defeito ou for diferente do solicitado, você poderá solicitar a devolução ou o reembolso.</p>
        <ul>
            <li>Envie uma foto do produto para análise, junto com o número do pedido.</li>
            <li>A solicitação deve ser feita dentro de <strong>24 horas após a retirada</strong> do pedido.</li>
        </ul>

        <h2>3. Como Funciona o Reembolso?</h2>
        <p>O reembolso será processado pelo Mercado Pago. Se o pagamento foi feito via cartão de crédito, o valor será estornado na próxima fatura. Se o pagamento foi via boleto bancário ou saldo do Mercado Pago, o reembolso será feito diretamente na sua conta do Mercado Pago.</p>

        <h2>4. Requisitos para Devolução</h2>
        <ul>
            <li>O pedido deve ser retirado no horário estabelecido pela cantina.</li>
            <li>O produto deve ser devolvido na embalagem original, se aplicável, para análise e reembolso.</li>
        </ul>

        <h2>5. Importante</h2>
        <p>Nosso sistema de pedidos é exclusivamente para retirada na <strong>ETEC de Bebedouro</strong>. Não realizamos entregas fora do campus da escola. Lembre-se: a retirada do pedido no balcão da cantina é fundamental.</p>

        <p>Se precisar de mais informações ou tiver alguma dúvida, entre em contato conosco. Estamos à disposição para ajudar!</p>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>
