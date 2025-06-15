<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>Cantina Três Irmãos - Já é nosso Cliente?</title>
    <link rel="shortcut icon" href="../assets/img/logo_copia01.png" type="image/x-icon">
</head>

<body>

    <div class="container">
        <div class="cadastro-login">
            <div class="header-title">
                <h2>Já é nosso Cliente?</h2>
                <div class="barra-laranja"></div>
            </div>
            <div class="user-icon">
                <img src="../assets/img/usuario-de-perfil.png" alt="" width="80px">
            </div>
            <form action="../includes/consulta_cliente.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="botao">
                    <button type="submit">Entrar</button>
                </div>
            </form>
            <div class="information">

                <p>Não tem conta? <a href="../php/cadastro.php">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</body>

</html>