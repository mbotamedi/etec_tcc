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
  // Verifica se a quantidade é válida
  if (quantidade <= 0) {
    alert("Por favor, selecione uma quantidade válida.");
    return;
  }

  // Redireciona para o addCarrinho.php com o ID do produto e a quantidade
  window.location.href = `../carrinho/addCarrinho.php?id_produto=${produtoId}&qtd=${quantidade}`;
}
