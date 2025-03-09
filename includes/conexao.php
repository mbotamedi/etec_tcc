<?php
    $host = "localhost";
    $usuario= "root";
    $senha = "";
    $banco = "bd_cantina";
    $port = "3307";

    $conexao = mysqli_connect($host, $usuario, $senha, $banco, $port);

    /*if($conexao){
        echo ('Conexão estabelecida com sucesso!');
    } else {
        echo ('Falha de conexão');
    }*/

?>