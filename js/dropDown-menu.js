/*-----------ANIMAÇÃO DO MENU------------------------ */
const abrirModalBtn = document.getElementById("abrirModal");
const fecharModalBtn = document.getElementById("fecharModal");
const modal = document.getElementById("meuModal");

// Abre e fecha o modal ao clicar no ícone do usuário
abrirModalBtn.addEventListener("click", function (event) {
    event.preventDefault(); // Impede que o link recarregue a página

    if (modal.classList.contains("show")) {
        fecharModal(); // Fecha se já estiver aberto
    } else {
        abrirModal(); // Abre se estiver fechado
    }
});

// Fecha ao clicar no botão de fechar
fecharModalBtn.addEventListener("click", fecharModal);

// Fecha ao clicar fora do modal
modal.addEventListener("click", function (event) {
    if (event.target === modal) {
        fecharModal();
    }
});

// Função para abrir o modal
function abrirModal() {
    modal.style.display = "block"; // Exibe o modal antes da animação
    setTimeout(() => {
        modal.classList.add("show"); // Inicia a animação de abertura
    }, 10); // Pequeno delay para garantir a transição
}

// Função para fechar o modal
function fecharModal() {
    modal.classList.remove("show"); // Inicia a animação de fechamento
    setTimeout(() => {
        modal.style.display = "none"; // Esconde o modal após a animação
    }, 400); // Tempo igual ao da transição no CSS
}


