<?php
include("../../../includes/conexao.php");
$categoria = $_POST["categoria"];
$subcategoria = $_POST["txtsubcategoria"];
$id        = $_POST["id"];

if ($id == 0) {
    $gravar = mysqli_query(
        $conexao,
        "INSERT INTO tb_subcategorias (id_categoria, descricao) VALUES 
                                    ('$categoria', '$subcategoria')"
    );
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_subcategorias SET id_categoria = '$categoria', 
                descricao ='$subcategoria' WHERE id = '$id'"
    );
}

if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar SubCategoria";
}
