// Este arquivo está vazio pois os modais foram removidos

// Função para verificar o estado de login
async function verificarLogin() {
    try {
        const response = await fetch('verificar_login.php');
        const data = await response.json();

        console.log('Resposta do servidor:', data);

        if (data.logado) {
            sessionStorage.setItem('usuario_logado', 'true');
            sessionStorage.setItem('nome_usuario', data.nome);
        } else {
            sessionStorage.setItem('usuario_logado', 'false');
            sessionStorage.removeItem('nome_usuario');
        }

        return data.logado;
    } catch (error) {
        console.error('Erro ao verificar login:', error);
        sessionStorage.setItem('usuario_logado', 'false');
        sessionStorage.removeItem('nome_usuario');
        return false;
    }
}

// Função para controlar o offcanvas baseado no estado de login
async function controlarOffcanvas() {
    console.log('Verificando estado de login...');

    // Verifica o login no servidor
    const estaLogado = await verificarLogin();
    const nomeUsuario = sessionStorage.getItem('nome_usuario');

    // Seleciona o botão e os offcanvas
    const botaoUsuario = document.querySelector('.btn-primary[data-bs-toggle="offcanvas"]');
    const offcanvasDeslogado = document.querySelector('#canvas-deslogado');
    const offcanvasLogado = document.querySelector('#canvas-logado');

    // Primeiro verifica se está deslogado
    if (!estaLogado) {
        console.log('Usuário não logado - Configurando offcanvas deslogado');
        // Configura para usuário não logado
        if (botaoUsuario) {
            botaoUsuario.setAttribute('data-bs-target', '#canvas-deslogado');
        }
        if (offcanvasDeslogado) offcanvasDeslogado.classList.remove('d-none');
        if (offcanvasLogado) offcanvasLogado.classList.add('d-none');
    } else {
        console.log('Usuário logado - Configurando offcanvas logado');
        // Configura para usuário logado
        if (botaoUsuario) {
            botaoUsuario.setAttribute('data-bs-target', '#canvas-logado');
        }
        if (offcanvasDeslogado) offcanvasDeslogado.classList.add('d-none');
        if (offcanvasLogado) {
            offcanvasLogado.classList.remove('d-none');
            const nomeElement = offcanvasLogado.querySelector('#nomeUsuario');
            if (nomeElement) nomeElement.textContent = nomeUsuario;
        }
    }
}

// Função para inicializar o offcanvas
function inicializarOffcanvas() {
    console.log('Iniciando inicialização do offcanvas...');

    // Aguarda um pequeno delay para garantir que o DOM está pronto
    setTimeout(() => {
        const usuarioLogado = sessionStorage.getItem('usuario_logado');
        const targetId = usuarioLogado === 'true' ? '#canvas-logado' : '#canvas-deslogado';

        console.log('Target ID para inicialização:', targetId);

        // Inicializa o offcanvas apenas se o elemento existir
        const offcanvasElement = document.querySelector(targetId);
        if (offcanvasElement) {
            const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            console.log('Offcanvas inicializado com sucesso');
        } else {
            console.log('Elemento offcanvas não encontrado:', targetId);
        }
    }, 100);
}


// Executa quando a página carrega
document.addEventListener('DOMContentLoaded', controlarOffcanvas);

// Executa quando o sessionStorage muda
window.addEventListener('storage', controlarOffcanvas);





