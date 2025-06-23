<?php
include("../../../includes/conexao.php");

$id = $_POST["id"];
$cod_pro   = $_POST["txtcod"];
$cod_promocao = $_POST["txtpro"];
$qtd = $_POST["txtqtd"];
$vl = $_POST["txtvl"];

if ($id == 0) {
    $gravar = mysqli_query($conexao, "INSERT INTO tb_promocao_itens (id_promocao, id_produto, quantidade, Vl_pro) VALUES 
                                    ('$cod_promocao','$cod_pro','$qtd','$vl')");
    $id = mysqli_insert_id($conexao);
} else {
    $gravar = mysqli_query(
        $conexao,
        "UPDATE tb_promocao_itens SET id_promocao ='$cod_promocao', id_produto ='$cod_pro', quantidade ='$qtd', Vl_pro ='$vl'  WHERE id = '$id'"

    );
}

/*if (isset($_FILES["foto"])) {
    move_uploaded_file($_FILES["foto"]["tmp_name"], '../../../assets/img/promocoes_notebook/promo' . $cod_promocao . ".jpg");
}*/

if ($gravar) {
    echo "Dados salvos com sucesso";
} else {
    echo "Erro ao tentar Gravar ";
}

