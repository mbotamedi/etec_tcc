<?php
include("../../../includes/conexao.php");
$nome = $_POST["txtnome"];
$cpf = $_POST["txtcpf"];
$email = $_POST["txtemail"];
$celular = $_POST["txtcelular"];
/*$celular = preg_replace('/[^0-9]/', '', $celular); // remove tudo que não for número*/
$senha = $_POST["txtsenha"];
$id_cargo = $_POST["id_cargo"];

$id        = $_POST["id"];


//echo $id_cargo;

if ($id == 0) {
    $gravar = mysqli_query(
        $conexao,
        "INSERT INTO tb_usuarios (nome, CPF, email, senha, Celular, id_cargo) VALUES 
                                    ('$nome','$cpf', '$email', '$senha', '$celular', $id_cargo)"
    );
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_usuarios SET id = '$id', 
                nome ='$nome', CPF = '$cpf', email = '$email',senha = '$senha', id_cargo = $id_cargo, Celular = '$celular' WHERE id = '$id'"
    );
}


if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar SubCategoria";
}
