<?php
session_start();
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fale Conosco - Cantina Três Irmãos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">
    <link rel="stylesheet" href="../css/mediaQuery.css">

</head>

<body>
    <?php include("navbar.php"); ?>

    <div class="container-contato">
        <div class="titulo-contato">
            <h1>Fale Conosco</h1>
        </div>

        <form method="post" action="../email/email.php">
            <div class="form-group">
                <label for="txtnome">Nome</label>
                <input type="text" class="form-control" name="txtnome" id="txtnome" required>
            </div>

            <div class="form-group">
                <label for="txtemail">Email</label>
                <input type="email" class="form-control" name="txtemail" id="txtemail" required>
            </div>

            <div class="form-group">
                <label for="txtmensagem">Mensagem</label>
                <textarea class="form-control" name="txtmensagem" id="txtmensagem" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-enviar">Enviar Mensagem</button>
        </form>
    </div>
    

<?php include("./zap.php")?>

    <?php include("footer.php"); ?>
</body>

</html>