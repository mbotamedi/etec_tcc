<?php
include("../../../includes/conexao.php");

$id = $_POST["id"];

$delete = mysqli_query($conexao, "CALL spr_apagaregistro($id,'tb_produto_pro')");

$retorno = mysqli_fetch_assoc($delete);

echo $retorno["resultado"];
