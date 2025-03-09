function mascaraTelefone(input) {
    var telefone = input.value.replace(/\D/g, '');
    input.value = telefone.replace(/(\d{2})(\d)/, '($1) $2')
        .replace(/(\d{5})(\d)/, '$1-$2');
}

function mascaraCPF(input) {
    // Remove tudo que não é dígito
    var cpf = input.value.replace(/\D/g, '');

    // Aplica a máscara
    input.value = cpf.replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
}


//Adicionando um script JavaScript para esconder a mensagem de erro após 3 segundos 

window.onload = function() {
    var erroMsg = document.getElementById('erro-msg');
    if (erroMsg) {
        // Atraso de 3 segundos para esconder a mensagem
        setTimeout(function() {
            erroMsg.style.display = 'none';  // Esconde a mensagem de erro após 3 segundos
        }, 3000); // 3000ms = 3 segundos
    }
};

