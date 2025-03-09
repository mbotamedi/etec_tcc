<?php
    session_start(); // Inicia a sessão para armazenar mensagens

    include("conexao.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
        $nome  = $_POST["nome"];
        $email = $_POST["email"];
        $celular = $_POST["celular"];
        $cpf = $_POST["cpf"];
        $senha = $_POST["senha"];
        $confirmar = $_POST["confirmar-senha"];

    }

    if ($senha === $confirmar) {
        $senhaCad =  $senha;
        $gravar = mysqli_query($conexao,"INSERT INTO tb_cliente  VALUES(0,'$nome','$cpf', '$email', '$celular','$senhaCad')");

        if ($gravar){
            echo "Dados salvos com sucesso";
        }else{
            echo "Erro ao tentar cadastrar cliente";
        }
    } else {        
        // Se as senhas não coincidirem, armazena a mensagem de erro na sessão e redireciona
        $_SESSION['erro_senha'] = "Senha diferente, favor digitar a mesma senha";
        header("Location: ../html/cadastro.php"); // Redireciona para o cadastro
        exit(); // Certifica-se de que o script seja interrompido após o redirecionamento
    }

    
?>