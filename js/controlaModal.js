// Função para verificar se o usuário está logado
function verificarLogin() {
    const logado = sessionStorage.getItem('usuario_logado') === 'true';
    const nome = sessionStorage.getItem('usuario_nome');
    return { logado, nome };
}

// Função para fazer logout
async function fazerLogout() {
    try {
        const response = await fetch('php/logout.php');
        const data = await response.json();
        if (data.success) {
            // Limpa o sessionStorage
            sessionStorage.removeItem('usuario_id');
            sessionStorage.removeItem('usuario_nome');
            sessionStorage.removeItem('usuario_email');
            sessionStorage.removeItem('usuario_logado');
        }
        return data;
    } catch (error) {
        console.error('Erro ao fazer logout:', error);
        return { success: false };
    }
}

// Função para mostrar/esconder modais
function toggleModal(modalId, show) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = show ? 'block' : 'none';
    }
}

// Função para atualizar a exibição dos modais
function atualizarModais() {
    const loginStatus = verificarLogin();

    if (loginStatus.logado) {
        // Usuário logado - mostra modal de usuário
        toggleModal('modalAntes', false);
        toggleModal('modalDepois', true);
        const nomeUsuario = document.getElementById('nomeUsuario');
        if (nomeUsuario) {
            nomeUsuario.textContent = loginStatus.nome;
        }
    } else {
        // Usuário não logado - mostra modal de login
        toggleModal('modalAntes', true);
        toggleModal('modalDepois', false);
    }
}

// Função principal que inicializa todos os eventos
function inicializarModais() {
    // Elementos principais
    const btnUsuario = document.getElementById('abrirModal');
    const modalLogout = document.getElementById('modalLogout');

    // Botões de logout
    const btnLogout = document.getElementById('btnLogout');
    const btnConfirmarLogout = document.getElementById('btnConfirmarLogout');
    const btnCancelarLogout = document.getElementById('btnCancelarLogout');

    // Atualiza os modais inicialmente
    atualizarModais();

    // Evento de clique no botão de usuário
    if (btnUsuario) {
        btnUsuario.addEventListener('click', () => {
            atualizarModais();
        });
    }

    // Evento de abrir modal de logout
    if (btnLogout) {
        btnLogout.addEventListener('click', () => {
            toggleModal('modalLogout', true);
        });
    }

    // Evento de confirmar logout
    if (btnConfirmarLogout) {
        btnConfirmarLogout.addEventListener('click', async () => {
            const resultado = await fazerLogout();
            if (resultado.success) {
                toggleModal('modalLogout', false);
                atualizarModais(); // Atualiza os modais após o logout
            }
        });
    }

    // Evento de cancelar logout
    if (btnCancelarLogout) {
        btnCancelarLogout.addEventListener('click', () => {
            toggleModal('modalLogout', false);
        });
    }

    // Fechar modais ao clicar fora
    window.addEventListener('click', (e) => {
        if (e.target === modalLogout) {
            toggleModal('modalLogout', false);
        }
    });
}

// Inicializa tudo quando o documento estiver carregado
document.addEventListener('DOMContentLoaded', inicializarModais);






