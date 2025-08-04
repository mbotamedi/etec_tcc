<?php
@session_start();

$current_page = basename($_SERVER['PHP_SELF']);
$is_finalizar_pedido = ($current_page == 'finalizar_pedido.php');

if (!isset($_SESSION["carrinho"]) || (count($_SESSION["carrinho"]) <= 0)) {
    echo '<h3>Nenhum item no carrinho</h3>';
} else {
    // Estilos foram mantidos, sem erros.
    echo '<style>
            .cart-item { display: flex; flex-direction: column; width: 300px; padding: 10px; border: 1px solid #e0e0e0; border-radius: 10px; margin-bottom: 10px; background-color: #fff; }
            .cart-item .top-row { display: flex; align-items: center; margin-bottom: 10px; }
            .cart-item img { max-width: 50px; height: auto; margin-right: 10px; }
            .cart-item .description { font-size: 12px; color: #333; flex: 1; }
            .cart-item .bottom-row { display: flex; justify-content: space-between; align-items: center; }
            .cart-item .quantity-controls { display: flex; align-items: center; gap: 5px; }
            .cart-item .quantity-controls a { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; background-color: #f5f5f5; color: #333; font-size: 14px; font-weight: 600; text-decoration: none; border: 1px solid #e0e0e0; border-radius: 4px; transition: background-color 0.3s ease, color 0.3s ease; }
            .cart-item .quantity-controls a:hover { background-color: #ddd; color: #000; }
            .cart-item .quantity-controls span { font-size: 14px; color: #333; min-width: 20px; text-align: center; }
            .cart-item .unit-price { font-size: 12px; color: #666; }
            .total-row { display: flex; justify-content: space-between; align-items: center; font-size: 14px; font-weight: 600; color: #333; margin-top: 20px; padding: 0; }
            .offcanvas-cart-buttons { margin-top: 20px; display: flex; justify-content: center; gap: 20px; margin-bottom: 10px; }
            .close-btn { background: none; border: none; font-size: 24px; cursor: pointer; color: #777; }
            .close-btn:hover { color: #000; }
            h3 { font-size: 18px; color: #777; text-align: center; margin-top: 20px; }
            .button-clear { color: red; text-decoration: underline; transition: color 0.3s ease-in-out; cursor: pointer; }
            .button-clear:hover { color: rgb(198, 0, 0); }
          </style>';

    echo '<div>';

    $total = 0;
    foreach ($_SESSION["carrinho"] as $key => $value) {
        $valprodutos = $value["valor"] * $value["qtd"];
        if ($is_finalizar_pedido) {
            $foto = '../../assets/fotos/' . $value["id"] . '.png';
        } else {
            $foto = '../assets/fotos/' . $value["id"] . '.png';
        }


        echo '<div class="cart-item">';
        echo '  <div class="top-row">';
        echo '    <img src="' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($value["descricao"], ENT_QUOTES, 'UTF-8') . '">';
        echo '    <div class="description">' . htmlspecialchars($value["descricao"], ENT_QUOTES, 'UTF-8') . '</div>';
        echo '  </div>';
        echo '  <div class="bottom-row">';
        echo '    <div class="quantity-controls">
                      <a href="../carrinho/alteraQtd.php?id=' . $key . '&acao=subtrair">−</a>
                      <span>' . $value["qtd"] . '</span>
                      <a href="../carrinho/alteraQtd.php?id=' . $key . '&acao=somar">+</a>
                  </div>';
        echo '    <div class="unit-price">R$' . number_format($value["valor"], 2, ',', '.') . ' (unitário)</div>';
        echo '    <div><a href="../carrinho/delCarrinho.php?id=' . $key . '"><i class="fas fa-trash deleta"></i></a></div>';
        echo '  </div>';
        echo '</div>';

        $total = $total + $valprodutos;
    }

    echo '<div class="total-row">';
    echo '  <span>Total:</span>';
    echo '  <span>R$' . number_format($total, 2, ',', '.') . '</span>';
    echo '</div>';

    /*if (!$is_finalizar_pedido) {
        // O LINK MAIS IMPORTANTE - AGORA CORRIGIDO
        echo '<div class="clear-items" style="text-align: center; margin-top: 15px;"> 
                <a class="button-clear" href="../carrinho/deletarItem.php?acao=limpar">Limpar Carrinho</a>
              </div>';
    }*/

    /*if ($is_finalizar_pedido) {
        echo '<div class="alert alert-info" role="alert" style="margin-top: 15px;">';
        echo '    <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Close">&times;</button>';
        echo '    <strong>Informação:</strong> O carrinho não contém o botão finalizar, pois você já está na página de finalização.';
        echo '</div>';
    }*/

    if (!$is_finalizar_pedido) {
        echo '<div class="clear-items" style="text-align: center; margin-top: 15px;"> 
                <a class="btn btn-dark" href="../carrinho/deletarItem.php?acao=limpar">Limpar Carrinho</a>
              </div>';
        echo '<div class="offcanvas-cart-buttons">';
        echo '  <button class="btn btn-secondary" data-bs-dismiss="offcanvas">Continuar</button>';
        if (isset($_SESSION["carrinho"]) && count($_SESSION["carrinho"]) > 0) {
            echo '<a href="../carrinho/pedidos/finalizar_pedido.php" class="btn btn-primary">Finalizar</a>';
        }
        echo '</div>';
    }
    
    echo '</div>';
}
?>