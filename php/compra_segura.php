<?php
include 'verificar_login.php';
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>É seguro comprar? - Cantina Três Irmãos</title>
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

        .container-seguro {
            max-width: 960px;
            margin: 60px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
        }

        .container-seguro h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #2d3436;
            border-bottom: 3px solid #27ae60;
            display: inline-block;
            padding-bottom: 8px;
        }

        .container-seguro h2 {
            margin-top: 35px;
            font-size: 1.75rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .container-seguro p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #444;
        }

        .container-seguro ul {
            padding-left: 20px;
            margin-bottom: 25px;
        }

        .container-seguro ul li {
            margin-bottom: 12px;
            font-size: 1.05rem;
            position: relative;
            padding-left: 25px;
        }

        .container-seguro ul li::before {
            content: '✔';
            position: absolute;
            left: 0;
            top: 0;
            color: #27ae60;
            font-weight: bold;
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

        h1 {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <?php include("navbar.php"); ?>

    <div class="container-seguro">
        <h1>É seguro comprar na Cantina Três Irmãos?</h1>

        <p>Sim, sua compra conosco é 100% segura. Utilizamos a plataforma <strong>Mercado Pago</strong>, uma das maiores intermediadoras de pagamento da América Latina, que garante a proteção total de seus dados financeiros e pessoais.</p>

        <div class="highlight">
            <strong>Proteção ao comprador:</strong> Caso seu pedido não seja entregue ou apresente algum problema, você poderá solicitar reembolso diretamente pela plataforma do Mercado Pago.
        </div>

        <h2>Por que confiar?</h2>
        <ul>
            <li>✅ Seus dados são criptografados e armazenados com segurança.</li>
            <li>✅ Não temos acesso às suas informações bancárias ou de cartão de crédito.</li>
            <li>✅ O pagamento é processado em ambiente seguro e auditado.</li>
        </ul>

        <h2>Transações com garantia</h2>
        <p>Ao efetuar um pagamento com Mercado Pago, o valor fica em custódia da plataforma até que você receba seu pedido corretamente. Isso garante mais segurança e confiança para o comprador.</p>

        <div class="highlight">
            <strong>Política de Privacidade:</strong> Seus dados são tratados com total sigilo. Nossa empresa segue normas de privacidade rigorosas, para garantir a segurança das suas informações pessoais e bancárias.
        </div>

        <div class="highlight">
            <strong>Compra Garantida:</strong> Se o produto não chegar ou não for conforme o esperado, o Mercado Pago assegura o reembolso total de seu valor.
        </div>

        <div class="highlight">
            <strong>Certificação de Segurança:</strong> As transações são realizadas em um ambiente criptografado e auditado, seguindo padrões internacionais de segurança de dados.
        </div>

        <h2>Privacidade e segurança</h2>
        <p>Além do Mercado Pago, nós da <strong>Cantina Três Irmãos</strong> seguimos rigorosamente políticas de privacidade e boas práticas de segurança da informação. Seus dados estão protegidos!</p>

        <p>Em caso de dúvidas, entre em contato pelo e-mail: <strong>suportecantina@gmail.com</strong></p>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>
