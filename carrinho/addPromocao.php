<?php
// Este script é EXCLUSIVO para os BANNERS de promoção.
session_start();
include("../includes/conexao.php");

// 1. Valida se o ID da promoção do banner foi recebido.
if (!isset($_GET['id_promo'])) {
    header("Location: ../php/index.php?erro=promo_invalida");
    exit;
}
$id_promocao_pacote = intval($_GET['id_promo']);

// 2. CONSULTA MODIFICADA: Busca os itens do pacote e o VALOR PROMOCIONAL INDIVIDUAL (Vl_pro) de cada um.
$query_pacote = "SELECT 
                    pi.id_produto, 
                    pi.quantidade, 
                    pi.Vl_pro 
                 FROM tb_promocao_itens pi
                 WHERE pi.id_promocao = $id_promocao_pacote";

$result_pacote = mysqli_query($conexao, $query_pacote);

if ($result_pacote && mysqli_num_rows($result_pacote) > 0) {
    
    // REMOVIDO: O cálculo de preço proporcional não é mais necessário.

    // Adiciona cada item do pacote ao carrinho com seu preço individual promocional.
    while($item_promo = mysqli_fetch_assoc($result_pacote)){
        $id_produto = $item_promo['id_produto'];
        $qtd_promo = $item_promo['quantidade'];
        $valor_individual_promo = $item_promo['Vl_pro']; // Pega o preço promocional individual da tabela.

        // Pula para o próximo item se o valor promocional não for válido.
        if ($valor_individual_promo <= 0) {
            continue; 
        }

        $result_produto = mysqli_query($conexao, "SELECT * FROM tb_produtos WHERE id = $id_produto");
        $produto_data = mysqli_fetch_assoc($result_produto);

        if ($produto_data) {
            // DEFINE O PREÇO: Usa o valor individual da promoção (Vl_pro)
            $produto_data['valor'] = $valor_individual_promo;
            $produto_data['qtd'] = $qtd_promo;
            
            // "Marca" o item com o ID do pacote para permitir a remoção em grupo.
            $produto_data['id_promocao_origem'] = $id_promocao_pacote; 

            // Adiciona o item ao carrinho
            if (!isset($_SESSION["carrinho"])) {
                $_SESSION["carrinho"] = array();
            }
            $_SESSION["carrinho"][] = $produto_data;
        }
    }
}

// Redireciona de volta para a página inicial, abrindo o carrinho.
header("Location: ../php/index.php?openCart=true");
exit;
?>
