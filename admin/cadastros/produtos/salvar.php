<?php
include("../../../includes/conexao.php");
$produto = $_POST["txtprodutos"];
$valor = $_POST["txtvalor"];
$qtd = $_POST["txtquantidade"];
$id        = $_POST["id"];
$id_sub = $_POST["subcategoria"];

//echo $id_sub;

if ($id == 0) {
    $gravar = mysqli_query($conexao, "INSERT INTO tb_produtos (id_subcategoria, descricao, valor, estoque) VALUES 
                                    ('$id_sub', '$produto', '$valor', '$qtd')");
    $id = mysqli_insert_id($conexao);
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_produtos SET id_subcategoria = '$id_sub ', 
                descricao ='$produto',
                valor = '$valor',
                estoque = '$qtd' WHERE id = '$id'"
    );
}

/*if (isset($_FILES["foto"])) {
    move_uploaded_file($_FILES["foto"]["tmp_name"], '../../../assets/fotos/' . $id . ".png");
}*/

if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar SubCategoria";
}
