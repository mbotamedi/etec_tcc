<?php
    $host = "localhost";
    $usuario= "root";
    $senha = "";
    $banco = "bd_cantina";
$port = "3306";

    $conexao = mysqli_connect($host, $usuario, $senha, $banco, $port);

date_default_timezone_set('America/Sao_Paulo');
    // Define o charset para utf8mb4
    if (!mysqli_set_charset($conexao, "utf8mb4")) {
        die("Erro ao definir o charset: " . mysqli_error($conexao));
    }

    /*if($conexao){
        echo ('Conexão estabelecida com sucesso!');
    } else {
        echo ('Falha de conexão');
    }*/

?> \