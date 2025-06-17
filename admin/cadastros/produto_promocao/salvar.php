<?php
include("../../../includes/conexao.php");

$desconto = $_POST["txtdesconto"];
$desconto = (float) $desconto;
$desc = $desconto / 100;

$id = $_POST["id"];
$id_cod   = $_POST["txtcod"];
$id_cod = (int) $id_cod;



if ($id == 0) {
    $gravar = mysqli_query($conexao, "INSERT INTO tb_produto_pro (id_produto, desconto) VALUES 
                                    ('$id_cod', '$desc')");
    $id = mysqli_insert_id($conexao);
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_produto_pro SET id_produto ='$id_cod',desconto = '$desc'  WHERE id = '$id'"

    );
}

if (isset($_FILES["foto"])) {
    move_uploaded_file($_FILES["foto"]["tmp_name"], '../../../assets/fotos/' . $id_cod . ".png");
}

if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar SubCategoria";
}
