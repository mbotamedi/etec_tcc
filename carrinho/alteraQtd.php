<?php
session_start();

if (!isset($_SESSION["carrinho"]) || !isset($_GET["id"]) || !isset($_GET["acao"])) {
    header("Location: ../php/produtos.php?openCart=true");
    exit;
}

$id = $_GET["id"];
$acao = $_GET["acao"];

// Verificar se o item existe no carrinho
if (isset($_SESSION["carrinho"][$id])) {
    if ($acao == "subtrair") {
        if ($_SESSION["carrinho"][$id]["qtd"] > 1) {
            $_SESSION["carrinho"][$id]["qtd"] -= 1;
        } else {
            // Se a quantidade for 1, remover o item
            unset($_SESSION["carrinho"][$id]);
        }
    } elseif ($acao == "somar") {
        $_SESSION["carrinho"][$id]["qtd"] += 1;
    }
}

// Reindexar o array para evitar índices inconsistentes
$_SESSION["carrinho"] = array_values($_SESSION["carrinho"]);

header("Location: ../php/produtos.php?openCart=true");
?>