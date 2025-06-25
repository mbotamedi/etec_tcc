//Carrinho

function process(change, inputId) {
  let input = document.getElementById(inputId);
  let value = parseInt(input.value) + change;
  if (value >= 0) {
    // Evita quantidades negativas
    input.value = value;
  }
}
function addToCart(produtoId, quantidade) {
  // Converte a quantidade para um número inteiro
  let qty = parseInt(quantidade)
  // Apenas redireciona se a quantidade for maior que 0
  if (qty > 0) {
    window.location.href = `../carrinho/addCarrinho.php?id_produto=${produtoId}&qtd=${qty}`;
  }
  // Se a quantidade for 0, não faz nada.
}

