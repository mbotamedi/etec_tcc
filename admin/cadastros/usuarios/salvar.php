<?php
include("../../../includes/conexao.php");
$nome = $_POST["txtnome"];
$cpf = $_POST["txtcpf"];
$email = $_POST["txtemail"];
$celular = $_POST["txtcelular"];
$id_cargo = $_POST["txtcargo"];
$id        = $_POST["id"];


//echo $id_sub;

if ($id == 0) {
    $gravar = mysqli_query(
        $conexao,
        "INSERT INTO tb_usuarios (nome, CPF, email, Celular, id_cargo) VALUES 
                                    ('$nome','$cpf', '$email', '$celular', '$id_cargo')"
    );
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_usuarios SET id = '$id', 
                nome ='$nome', CPF = '$cpf', email = '$email', id_cargo = '$id_cargo', Celular = '$celular' WHERE id = '$id'"
    );
}


if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar SubCategoria";
}
