<?php
session_start();

$pagina_origem = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../php/produtos.php';

if (!isset($_SESSION["carrinho"]) || !isset($_GET["id"]) || !isset($_GET["acao"])) {
    header("Location: $pagina_origem?openCart=true");
    exit;
}

$id = $_GET["id"];
$acao = $_GET["acao"];

// Extrair quantidades originais
$original_quantities = [];
foreach ($_SESSION["carrinho"] as $key => $value) {
    if (isset($value['id_promocao_origem'])) {
        $id_promo = $value['id_promocao_origem'];
        if (!isset($original_quantities[$id_promo])) {
            $original_quantities[$id_promo] = [];
        }
        $original_quantities[$id_promo][$value['id']] = $value['qtd'];
    }
}

if (isset($_SESSION["carrinho"][$id])) {
    $is_promotion_item = isset($_SESSION["carrinho"][$id]['id_promocao_origem']);
    $qtd = $_SESSION["carrinho"][$id]['qtd'] ?? 1;
    $original_qtd = $is_promotion_item ? ($original_quantities[$_SESSION["carrinho"][$id]['id_promocao_origem']][$_SESSION["carrinho"][$id]['id']] ?? $qtd) : null;

    if ($acao == "subtrair") {
        if ($qtd > 1) {
            $_SESSION["carrinho"][$id]["qtd"] -= 1;
        } else {
            unset($_SESSION["carrinho"][$id]);
        }
    } elseif ($acao == "somar") {
        if (!$is_promotion_item || ($is_promotion_item && $qtd < $original_qtd * 2)) {
            $_SESSION["carrinho"][$id]["qtd"] += 1;
        }
    }
}

$_SESSION["carrinho"] = array_values($_SESSION["carrinho"]);
header("Location: $pagina_origem?openCart=true");
?>