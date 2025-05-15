<?php
@session_start();

$current_page = basename($_SERVER['PHP_SELF']); // Obtém o nome da página atual
$is_finalizar_pedido = ($current_page == 'finalizar_pedido.php');


if (!isset($_SESSION["carrinho"]) || (count($_SESSION["carrinho"]) <= 0)) {
    echo '<h3>Nenhum item no carrinho</h3>';
} else {
    // Contagem de itens no carrinho
    $totalItens = count($_SESSION["carrinho"]);

    echo '<style>
            .table-carrinho {
                width: 100%;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .table-carrinho th, .table-carrinho td {
                padding: 12px;
                text-align: center;
                vertical-align: middle;
                border-bottom: 1px solid #e0e0e0;
            }
            .table-carrinho th {
                background-color: rgba(41, 167, 29, 0.1);
                color: #333;
                font-size: 16px;
                font-weight: 600;
            }
            .table-carrinho td {
                font-size: 14px;
                color: #555;
            }
            .table-carrinho th.descricao { width: 20%; }
            .table-carrinho th.imagem { width: 15%; }
            .table-carrinho th.valor-unitario { width: 20%; }
            .table-carrinho th.quantidade { width: 5%; }
            .table-carrinho th.valor-total { width: 20%; }
            .table-carrinho img {
                max-width: 70px;
                height: auto;
                border-radius: 8px;
                border: 1px solid #e0e0e0;
            }
            .table-carrinho .deleta {
                color: rgba(70, 53, 220, 0.85);
                font-size: 16px;
                transition: color 0.3s ease;
                margin-left: 20px;
                
            }
            .table-carrinho .deleta:hover {
                color: rgba(18, 9, 43, 0.9);
            }
            .table-carrinho .qtd-controls {
                display: flex;
                padding: 50px;
                align-items: center;
                justify-content: center;
                gap: 5px;
            }
            .table-carrinho .qtd-controls a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 24px;
                height: 24px;
                background-color: #f5f5f5;
                color: #333;
                font-size: 14px;
                font-weight: 600;
                text-decoration: none;
                border-radius: 4px;
                border: 1px solid #e0e0e0;
                transition: background-color 0.3s ease, color 0.3s ease;
            }
            .table-carrinho .qtd-controls a:hover {
                background-color: rgba(41, 167, 29, 0.9);
                color: #fff;
                border-color: rgba(41, 167, 29, 0.9);
            }
            .table-carrinho .qtd-controls span {
                font-size: 14px;
                color: #333;
                min-width: 20px;
                text-align: center;
            }
            .table-carrinho .total-row td {
                font-size: 16px;
                font-weight: 700;
                color: #333;
            }
            h2 {
                font-size: 18px;
                color: rgba(41, 167, 29, 0.9);
                margin-bottom: 20px;
                font-weight: 500;
            }
            h3 {
                font-size: 18px;
                color: #777;
                text-align: center;
                margin-top: 20px;
            }
             
          </style>';

    // Exibir o título com a contagem de itens
    echo '<h2>Quantidade no Carrinho (' . $totalItens . ' ' . ($totalItens == 1 ? 'item' : 'itens') . ')</h2> 
          <table class="table table-carrinho">
              <tr>
                  <th class="descricao">Descrição</th>
                  <th class="imagem">Imagem</th>
                  <th class="valor-unitario">Valor Un.</th>
                  <th class="quantidade">Qtd.</th>
                  <th class="valor-total">Valor Total</th>
              </tr>';
    $total = 0;
    foreach ($_SESSION["carrinho"] as $key => $value) {
        $valprodutos = $value["valor"] * $value["qtd"];
        $foto = '../assets/fotos/' . $value["id"] . '.png';
        echo '<tr>';
        echo '<td>' . htmlspecialchars($value["descricao"], ENT_QUOTES, 'UTF-8') . '</td>';
        if (!$is_finalizar_pedido) {
            // Para páginas que não são finalizar_pedido.php
            echo '<td><img class="card-img-top" src="' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') . '" style="max-width:70px; height:auto; margin:auto" alt="' . htmlspecialchars($value["descricao"], ENT_QUOTES, 'UTF-8') . '"></td>';
        } else {
            // Para finalizar_pedido.php
            echo '<td><img src="../' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($value["descricao"], ENT_QUOTES, 'UTF-8') . '"></td>';
        }

        echo '<td>' . number_format($value["valor"], 2, ',', '.') . '</td>';
        echo '<td class="qtd-controls">
                <a href="../carrinho/alteraQtd.php?id=' . $key . '&acao=subtrair">−</a>
                <span>' . $value["qtd"] . '</span>
                <a href="../carrinho/alteraQtd.php?id=' . $key . '&acao=somar">+</a>
              </td>';
        echo '<td>' . number_format($valprodutos, 2, ',', '.') . ' 
              <a href="../carrinho/delCarrinho.php?id=' . $key . '"><i class="fas fa-trash deleta"></i></a>
             </td>';
        echo '</tr>';
        $total = $total + $valprodutos;
    }
    echo '<tr class="total-row">
            <td colspan="3"></td>
            <td><strong>Total:</strong></td>
            <td>' . number_format($total, 2, ',', '.') . '</td>
          </tr>';
    echo '</table>';
}
?>

<?php if (!$is_finalizar_pedido): ?>
    <div class="offcanvas-cart-buttons" style="margin-top: 20px; text-align: center;">
        <button class="btn btn-secondary" data-bs-dismiss="offcanvas">Continuar Comprando</button>
        <?php if (isset($_SESSION["carrinho"]) && count($_SESSION["carrinho"]) > 0): ?>
            <a href="../carrinho/pedidos/finalizar_pedido.php" class="btn btn-primary">Finalizar Pedido</a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="offcanvas-cart-buttons" style="margin-top: 20px; text-align: center; display: none;">
        <button class="btn btn-secondary" data-bs-dismiss="offcanvas">Continuar Comprando</button>
        <?php if (isset($_SESSION["carrinho"]) && count($_SESSION["carrinho"]) > 0): ?>
            <a href="../carrinho/pedidos/finalizar_pedido.php" class="btn btn-primary">Finalizar Pedido</a>
        <?php endif; ?>
    </div>
<?php endif; ?>