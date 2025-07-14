<?php
@session_start();
include("../includes/conexao.php");

$id_pedido = isset($_GET['id_pedido']) ? (int)$_GET['id_pedido'] : 0;

// Verifica se o pedido existe
$query_pedido = "SELECT p.*, c.nome FROM tb_pedidos p 
                 JOIN tb_clientes c ON p.id_cliente = c.id 
                 WHERE p.id = '$id_pedido'";
$result_pedido = mysqli_query($conexao, $query_pedido);
$pedido = mysqli_fetch_assoc($result_pedido);

if (!$pedido) {
    header("Location: produtos.php?erro=pedido_nao_encontrado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Pedido - Cantina Três Irmãos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <style>
        .container-confirmacao {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .btn-continuar {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-continuar:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Inclui a navegação -->
    <?php include("../php/navbar.php"); ?>

    <section class="py-5">
        <div class="container-confirmacao">
            <h2>Pedido Confirmado!</h2>
            <p>Obrigado, <?= htmlspecialchars($pedido['nome']) ?>!</p>
            <p>Seu pedido nº <?= $id_pedido ?> foi realizado com sucesso.</p>
            <p>Você receberá uma confirmação por e-mail em breve.</p>
            <a href="../php/produtos.php" class="btn-continuar">Continuar Comprando</a>
        </div>
    </section>

    <!-- Footer -->
    <?php include("../php/footer.php"); ?>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>