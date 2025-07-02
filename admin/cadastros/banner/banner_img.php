<?php
   
    // Pegando o valor do select
    $codigo = $_POST['cod_banner'];
   

    if (isset($_FILES["foto"])) {
        move_uploaded_file($_FILES["foto"]["tmp_name"], '../../../assets/img/promocoes_notebook/promo' . $codigo . ".jpg");
        echo "Arquivo enviado ";
    header("Location: ../../admin.php?pg=Banner");
    exit();
} else {
    echo "Nenhuma imagem enviada.";
}
    

?>
