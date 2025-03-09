<?php
    $host = "localhost:3307";
    $usuario= "root";
    $senha = "";
    $banco = "bd_cantina";

    $conexao = mysqli_connect($host, $usuario, $senha, $banco);

    /*if($conexao){
        echo ('Conexão estabelecida com sucesso!');
    } else {
        echo ('Falha de conexão');
    }*/

?>