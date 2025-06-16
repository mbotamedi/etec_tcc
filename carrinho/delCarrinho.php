<?php
session_start();

// Pega o índice do item no carrinho que o usuário clicou para remover (ex: 0, 1, 2...)
$key_para_remover = $_GET["id"];

// Garante que o item realmente existe no carrinho antes de fazer qualquer coisa
if (isset($_SESSION["carrinho"][$key_para_remover])) {
    
    // ======================================================================================
    // PASSO 1: O código verifica se o item clicado tem a "marca" de uma promoção.
    // ('id_promocao_origem' é a marca que colocamos no script addPromocao.php)
    // ======================================================================================
    if (isset($_SESSION["carrinho"][$key_para_remover]['id_promocao_origem'])) {
        
        // Se tem a marca, ele descobre QUAL promoção é. Ex: Promoção de ID '1' ou '2'.
        $id_promocao_para_remover = $_SESSION["carrinho"][$key_para_remover]['id_promocao_origem'];
        
        // ===================================================================================================
        // PASSO 2: Agora, o código olha o carrinho INTEIRO novamente, item por item (usando o foreach).
        // ===================================================================================================
        foreach ($_SESSION["carrinho"] as $key => $item) {
            
            // =====================================================================================================================
            // PASSO 3: Para cada item do carrinho, ele compara a marca com a da promoção que queremos remover.
            // Se a marca for a mesma (ex: id_promocao_origem == 1), ele remove.
            // Se a marca for diferente (ex: id_promocao_origem == 2), ele IGNORA e não faz nada com esse item.
            // =====================================================================================================================
            if (isset($item['id_promocao_origem']) && $item['id_promocao_origem'] == $id_promocao_para_remover) {
                unset($_SESSION["carrinho"][$key]); // Remove APENAS os itens da promoção clicada.
            }
        }
        
    } else {
        // Se o item clicado NÃO era de uma promoção, ele remove apenas aquele item individual.
        unset($_SESSION["carrinho"][$key_para_remover]);
    }
    
    // Reorganiza o array do carrinho para não ficar com "buracos"
    $_SESSION["carrinho"] = array_values($_SESSION["carrinho"]);
}

// Redireciona de volta para a página de onde o usuário veio
$pagina_origem = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../php/produtos.php';
header("Location: $pagina_origem?openCart=true");
?>