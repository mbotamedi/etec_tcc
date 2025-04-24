<?php   
    include("../../../includes/conexao.php");
    $categoria = $_POST["txtcategoria"];
    $id        = $_POST["id"];
    if ($id == 0){
        $gravar = mysqli_query($conexao, 
        "INSERT INTO tb_categorias (descricao) VALUES ('$categoria')");
    }else{
        $gravar = mysqli_query($conexao, 
        "UPDATE tb_categorias SET descricao ='$categoria' WHERE id = '$id'");   
    }    

    if ($gravar){
        echo "Dados salvos com sucesso";
    }else{
        echo "Erro ao tentar Gravar Categoria";
    }
?>