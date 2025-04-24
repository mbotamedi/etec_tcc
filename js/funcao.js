function mascaraTelefone(input) {
  var telefone = input.value.replace(/\D/g, "");
  input.value = telefone
    .replace(/(\d{2})(\d)/, "($1) $2")
    .replace(/(\d{5})(\d)/, "$1-$2");
}

function mascaraCPF(input) {
  // Remove tudo que não é dígito
  var cpf = input.value.replace(/\D/g, "");

  // Aplica a máscara
  input.value = cpf
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
}

//Adicionando um script JavaScript para esconder a mensagem de erro após 3 segundos
window.onload = function () {
  var erroMsg = document.getElementById("erro-msg");
  if (erroMsg) {
    // Atraso de 3 segundos para esconder a mensagem
    setTimeout(function () {
      erroMsg.style.display = "none"; // Esconde a mensagem de erro após 3 segundos
    }, 3000); // 3000ms = 3 segundos
  }
};

//Botões Quantidade
// Função para processar a quantidade
function process(change, quantId) {
  var quantInput = document.getElementById(quantId);
  var currentValue = parseInt(quantInput.value, 10);
  if (!isNaN(currentValue)) {
    quantInput.value = Math.max(0, currentValue + change);
  }
}

// Exibe o modal quando a página é carregada
document.addEventListener("DOMContentLoaded", function () {
  const mensagemModalElement = document.getElementById("mensagemModal");
  if (mensagemModalElement) {
    var mensagemModal = new bootstrap.Modal(mensagemModalElement);
    mensagemModal.show();

    // Fecha o modal após 6 segundos
    setTimeout(function () {
      mensagemModal.hide();
    }, 6000); // 6000 milissegundos = 6 segundos
  }
});

// Função para o Carrossel Produtos
function process(change, inputId) {
  const input = document.getElementById(inputId);
  let value = parseInt(input.value) || 0;
  value += change;
  if (value < 0) value = 0; // Impede valores negativos
  input.value = value;
}
