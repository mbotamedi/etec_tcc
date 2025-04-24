<?php
// Inclui o arquivo de verificação de login
include 'verificar_login.php';
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Termos e Condições - Cantina Três Irmãos</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">
    <!-- Fontes e Ícones -->
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Maven Pro', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .terms-container {
            max-width: 900px;
            margin: 60px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .terms-container h1 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .terms-container h2 {
            font-size: 24px;
            color: #34495e;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .terms-container p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .terms-container ul {
            margin-left: 20px;
            margin-bottom: 15px;
        }
        .terms-container ul li {
            margin-bottom: 10px;
        }
        @media (max-width: 768px) {
            .terms-container {
                padding: 20px;
                margin: 20px;
            }
            .terms-container h1 {
                font-size: 28px;
            }
            .terms-container h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include("navbar.php"); ?>

    <!-- Conteúdo dos Termos e Condições -->
    <div class="terms-container">
        <h1>Termos e Condições</h1>

        <p>Bem-vindo à <strong>Cantina Três Irmãos</strong>. Ao utilizar nossos serviços ou navegar em nosso site, você concorda com os seguintes Termos e Condições:</p>

        <h2>1. Uso do Serviço</h2>
        <p>O serviço da cantina é destinado a fornecer alimentos e bebidas de forma segura e organizada. Espera-se que o usuário aja com respeito aos demais clientes e colaboradores.</p>

        <h2>2. Pagamentos</h2>
        <p>Todos os pagamentos devem ser realizados no ato da compra, utilizando os métodos de pagamento aceitos no momento.</p>

        <h2>3. Cancelamentos e Reembolsos</h2>
        <p>Pedidos realizados erroneamente devem ser informados imediatamente à equipe. Reembolsos podem ser realizados a critério da administração.</p>

        <h2>4. Responsabilidade</h2>
        <p>A cantina se compromete a fornecer alimentos de qualidade, mas não se responsabiliza por eventuais reações alérgicas. Informe-se sobre os ingredientes antes do consumo.</p>

        <h2>5. Privacidade</h2>
        <p>As informações pessoais coletadas (como nome e e-mail em pedidos online) serão usadas apenas para fins operacionais da cantina e não serão compartilhadas com terceiros.</p>

        <h2>6. Alterações nos Termos</h2>
        <p>Estes termos podem ser atualizados periodicamente. Recomendamos que você os revise com frequência. Última atualização: <strong>23 de abril de 2025</strong>.</p>

        <h2>7. Contato</h2>
        <p>Para dúvidas ou sugestões, entre em contato pelo e-mail: <strong>suportecantina@gmail.com</strong></p>
    </div>

    <!-- Footer -->
    <?php include("footer.php"); ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/funcao.js"></script>
    <script src="../js/controlaModal.js"></script>
    <script src="../js/carrinho.js"></script>
</body>
</html>
