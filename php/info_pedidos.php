<?php
include 'verificar_login.php';
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Como Funciona - Cantina Três Irmãos</title>
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

        .container-pedidos {
            max-width: 960px;
            margin: 60px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
        }

        .container-pedidos h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #2d3436;
            border-bottom: 3px solid #27ae60;
            display: inline-block;
            padding-bottom: 8px;
        }

        .container-pedidos h2 {
            margin-top: 35px;
            font-size: 1.75rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .container-pedidos p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #444;
        }

        .container-pedidos ul {
            padding-left: 20px;
            margin-bottom: 25px;
        }

        .container-pedidos ul li {
            margin-bottom: 12px;
            font-size: 1.05rem;
            position: relative;
            padding-left: 25px;
        }

        .container-pedidos ul li::before {
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

    <div class="container-pedidos">
        <h1>Como Funciona o Pedido na Cantina Três Irmãos?</h1>

        <p>A Cantina Três Irmãos está localizada dentro da ETEC de Bebedouro e oferece um serviço prático para você fazer seu pedido antes do intervalo. Veja como funciona:</p>

        <h2>Passo a Passo para Realizar seu Pedido</h2>
        <ul>
            <li>✅ Acesse o nosso site e escolha os produtos que você deseja comprar.</li>
            <li>✅ Adicione os itens ao carrinho e finalize o pagamento através da plataforma Mercado Pago.</li>
            <li>✅ O pagamento é processado de forma segura, garantindo a proteção dos seus dados.</li>
            <li>✅ Após o pagamento confirmado, você pode retirar seu pedido diretamente no balcão da Cantina Três Irmãos na ETEC de Bebedouro.</li>
        </ul>

        <h2>Importante</h2>
        <p>🛑 **Entrega limitada**: A Cantina Três Irmãos **não realiza entregas fora da ETEC**. Todos os pedidos devem ser retirados no balcão.</p>

        <div class="highlight">
            <strong>Horário de Retirada:</strong> Você poderá retirar seu pedido durante o intervalo. O pagamento é feito antecipadamente, então você não precisa se preocupar com fila ou pagamento no balcão.
        </div>

        <h2>Vantagens de Pedir Antes</h2>
        <ul>
            <li>✅ Evite as filas durante o intervalo.</li>
            <li>✅ Receba seu pedido fresquinho e pronto para consumo.</li>
            <li>✅ Compre de forma rápida e fácil sem sair de sua sala de aula.</li>
        </ul>

        <h2>Detalhes Importantes</h2>
        <p>A Cantina Três Irmãos está comprometida em oferecer uma experiência prática e segura para todos os alunos da ETEC de Bebedouro. Nossa plataforma de pagamento é 100% segura e seus dados estão protegidos.</p>

        <p>Em caso de dúvidas, entre em contato pelo e-mail: <strong>suportecantina@gmail.com</strong></p>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>
