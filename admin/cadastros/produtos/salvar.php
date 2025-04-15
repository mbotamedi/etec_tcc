<?php
include("../../../includes/conexao.php");
$produtos = $_POST["txtprodutos"];
$valor = $_POST["txtvalor"];
$quantidade = $_POST["txtquantidade"];
$id        = $_POST["id"];
$id_sub = $_POST["subcategoria"];

//echo $id_sub;

if ($id == 0) {
    $gravar = mysqli_query($conexao, "INSERT INTO tb_produtos (id_subcategoria, descricao, valor, estoque) VALUES 
                                    ('$subcategoria', '$produto', '$valor', '$estoque')");
    $id = mysqli_insert_id($conexao);
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_produtos SET id_subcategoria = '$subcategoria', 
                descricao ='$produto',
                valor = '$valor',
                estoque = '$estoque' WHERE id = '$id'"
    );
}

if (isset($_FILES["foto"])) {
    move_uploaded_file($_FILES["foto"]["tmp_name"], 'foto/' . $id . ".jpeg");
}

if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar SubCategoria";
}
