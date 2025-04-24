<?php
include 'verificar_login.php';
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fale Conosco - Cantina Três Irmãos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="../css/footer.css" />
    <style>
        :root {
            --primary-color: #27ae60;
            --hover-color: #219150;
            --bg-color: #f8f9fa;
            --text-color: #333;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container-contato {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .titulo-contato {
            text-align: center;
            margin-bottom: 40px;
        }

        .titulo-contato h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .btn-enviar {
            background-color: var(--primary-color);
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-enviar:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }

        .btn-enviar:active {
            transform: translateY(0);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container-contato {
                margin: 20px;
                padding: 20px;
            }

            .titulo-contato h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .titulo-contato h1 {
                font-size: 1.8rem;
            }

            .form-control {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <?php include("navbar.php"); ?>

    <div class="container-contato">
        <div class="titulo-contato">
            <h1>Fale Conosco</h1>
        </div>

        <form method="post" action="">
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
    <?php
    if (isset($_POST["txtnome"])) {
        $nome     = $_POST["txtnome"];
        $email    = $_POST["txtemail"];
        $mensagem = $_POST["txtmensagem"];
        //Conecta com o Banco de dados         
        include("../email.php");
    }

    ?>

    <?php include("footer.php"); ?>
</body>

</html>