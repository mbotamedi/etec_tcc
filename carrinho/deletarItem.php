<?php
session_start();

// Verifica se a sessão do carrinho existe
if (isset($_SESSION["carrinho"])) {
    // Esvazia completamente o array do carrinho
    unset($_SESSION["carrinho"]);
    // Opcional: Se você quiser garantir que o carrinho seja um array vazio após a remoção
    // $_SESSION["carrinho"] = []; 
}

// Redireciona de volta para a página principal ou para onde você quiser que o usuário vá após esvaziar o carrinho
// Geralmente, para a página de produtos ou o próprio carrinho vazio.
$pagina_origem = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../php/index.php';
header("Location: $pagina_origem?openCart=true");
exit(); // Garante que o script pare de executar após o redirecionamento
?>