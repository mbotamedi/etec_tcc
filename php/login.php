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
    <link rel="stylesheet" href="../css/mediaQuery.css">
    <title>Cantina Três Irmãos - Já é nosso Cliente?</title>
    <link rel="shortcut icon" href="../assets/img/logo_copia01.png" type="image/x-icon">

    <style>
        @media (max-width: 992px) {
            form {
                width: 70%;
                margin: 0 auto;
                padding: 0 auto;
            }

            .header-font {
                font-size: 40px;
            }

            .information-text {
                font-size: 18px;
            }

            .link-cadastro {
                font-size: 15px;
            }

            .label-text {
                font-size: 18px;
            }

            .button-open {
                margin-left: 10px;
            }
        }
    </style>
</head>


<body>

    <div class="container">
        <div class="cadastro-login">
            <div class="header-title">
                <h2 class="header-font">Já é nosso Cliente?</h2>
                <div class="barra-laranja"></div>
            </div>
            <div class="user-icon">
                <img src="../assets/img/usuario-de-perfil.png" alt="" width="80px">
            </div>
            <form action="../includes/consulta_cliente.php" method="POST">
                <div class="form-group">
                    <label for="email" class="label-text">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha" class="label-text">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="botao">
                    <button type="submit" class="button-open">Entrar</button>
                </div>
            </form>
            <div class="information">

                <p class="information-text">Não tem conta? <a href="../php/cadastro.php" class="link-cadastro">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</body>

</html>