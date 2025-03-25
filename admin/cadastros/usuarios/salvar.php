<?php
include("../../../includes/conexao.php");
$nome = $_POST["txtnome"];
$cpf = $_POST["txtcpf"];
$email = $_POST["txtemail"];
$senha = $_POST["txtsenha"];
$celular = $_POST["txtcelular"];
$id        = $_POST["id"];


//echo $id_sub;

if ($id == 0) {
    $gravar = mysqli_query(
        $conexao,
        "INSERT INTO tb_usuarios (nome, CPF, email, senha, Celular) VALUES 
                                    ('$nome','$cpf', '$email', '$senha', '$celular')"
    );
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_usuarios SET id = '$id', 
                nome ='$nome', CPF = '$cpf', email = '$email', senha = '$senha', Celular = '$celular' WHERE id = '$id'"
    );
}

if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar SubCategoria";
}
