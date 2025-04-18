<?php
session_start();

$id_produto = $_GET["id_produto"];
$qtd = isset($_GET["qtd"]) ? intval($_GET["qtd"]) : 1; // Usa a quantidade passada ou 1 como padrão
include("../includes/conexao.php");
$produto = mysqli_query($conexao, "select * from tb_produtos where id = '$id_produto'");

if (!isset($_SESSION["carrinho"])) {
    $_SESSION["carrinho"] = array();
}

$produto_data = mysqli_fetch_assoc($produto);

// Verificar se o produto já está no carrinho
$produto_existe = false;
foreach ($_SESSION["carrinho"] as $key => $item) {
    if ($item['id'] == $id_produto) {
        // Produto já existe, atualizar a quantidade
        $_SESSION["carrinho"][$key]['qtd'] += $qtd;
        $produto_existe = true;
        break;
    }
}

// Se o produto não existe, adicionar como novo
if (!$produto_existe) {
    $produto_data['qtd'] = $qtd; // Define a quantidade
    $_SESSION["carrinho"][] = $produto_data; // Adiciona ao carrinho
}

header("Location: ../php/produtos.php?openCart=true");
?>

// Em vez de redirecionar, retorna um script para abrir o offcanvas
/*echo "<script>
    window.history.back(); // Volta para a página anterior (produtos.php)
    document.addEventListener('DOMContentLoaded', function() {
        var offcanvasElement = document.getElementById('offcanvasCart');
        var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
        offcanvas.show();
    });
</script>";*/
