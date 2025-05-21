<?php
    $host = "localhost";
    $usuario= "root";
    $senha = "";
    $banco = "bd_cantina";
    $port = "3307";

    $conexao = mysqli_connect($host, $usuario, $senha, $banco, $port);

    // Define o charset para utf8mb4
    if (!mysqli_set_charset($conexao, "utf8mb4")) {
        die("Erro ao definir o charset: " . mysqli_error($conexao));
    }

    /*if($conexao){
        echo ('Conexão estabelecida com sucesso!');
    } else {
        echo ('Falha de conexão');
    }*/

?>