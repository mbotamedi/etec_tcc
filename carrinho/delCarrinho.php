<?php
session_start();
$id = $_GET["id"];
unset($_SESSION["carrinho"][$id]);

// Determinar a página de origem
$pagina_origem = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../php/produtos.php';

// Redirecionar para a página de origem com o parâmetro openCart=true
header("Location: $pagina_origem?openCart=true");
?>
