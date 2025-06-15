<?php
session_start(); // Inicia a sessão para armazenar mensagens
?>
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
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="shortcut icon" href="../assets/img/logo_copia01.png" type="image/x-icon">
    <title>Cantina Três Irmãos - Cadastre-se</title>
</head>

<body>

    <div class="container">
        <div class="cadastro-login">
            <div class="header-title">
                <h2>Cadastre-se</h2>
                <div class="barra-laranja"></div>
            </div>
            <div class="user-icon">
                <img src="../assets/img/usuario-de-perfil.png" alt="" width="50px">
            </div>
            <!-- Exibe a mensagem de erro, se houver -->
            <?php

            if (isset($_SESSION['erro_senha'])) {
                echo "<p id='erro-msg' style='color: red;'>" . $_SESSION['erro_senha'] . "</p>";
                // Limpa a mensagem após exibir
                unset($_SESSION['erro_senha']);
            }
            ?>

            <form name="cadastro" id="cadastro" action="../includes/salvar.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="celular">Celular:</label>
                    <input type="tel" id="celular" name="celular" required pattern="\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}"
                        placeholder="(99) 99999-9999" maxlength="15" oninput="mascaraTelefone(this)">
                </div>
                <div class="form-group">
                    <label for="CPF">CPF:</label>
                    <input type="text" id="cpf" name="cpf" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                        placeholder="555.555.555-55" maxlength="14" oninput="mascaraCPF(this)">
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="form-group">
                    <label for="confirmar-senha">Confirmar Senha:</label>
                    <input type="password" id="confirmar-senha" name="confirmar-senha" required>
                </div>
                <div class="botao">
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
            <div class="information">
                <p>Já tem conta? <a href="login.php">Entrar</a></p>
            </div>
        </div>
    </div>

</body>

<script src="../js/funcao.js"></script>


</body>

</html>