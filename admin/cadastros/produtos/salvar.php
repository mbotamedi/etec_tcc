<?php
include("../../../includes/conexao.php");
$produtos = $_POST["txtprodutos"];
$valor = $_POST["txtvalor"];
$quantidade = $_POST["txtquantidade"];
$id        = $_POST["id"];
$id_sub = $_POST["subcategoria"];

//echo $id_sub;

if ($id == 0) {
    $gravar = mysqli_query(
        $conexao,
        "INSERT INTO tb_produtos (id_subcategoria, descricao, valor, estoque) VALUES 
                                    ('$id_sub','$produtos', '$valor', '$quantidade')"
    );
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_produtos SET id = '$id', 
                descricao ='$produtos', valor = '$valor', estoque ='$quantidade' WHERE id = '$id'"
    );
}

if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar SubCategoria";
}
