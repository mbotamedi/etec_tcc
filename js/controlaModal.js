document.addEventListener('DOMContentLoaded', function () {
    // Elementos dos modais
    const modalAntes = document.getElementById('modalAntes');
    const modalDepois = document.getElementById('modalDepois');
    const abrirModal = document.getElementById('abrirModal');
    const fecharModalAntes = document.getElementById('fecharModalAntes');
    const btnConfirmarLogout = document.getElementById('btnConfirmarLogout');
    const btnCancelarLogout = document.getElementById('btnCancelarLogout');
    const modalLogout = document.getElementById('modalLogout');

    // Função para verificar o estado de login
    function verificarLogin() {
        console.log('Verificando estado de login...');
        fetch('php/verificar_login.php')
            .then(response => response.json())
            .then(data => {
                console.log('Resposta do servidor:', data);
                if (!data.logado) {
                    // Se NÃO estiver logado
                    console.log('Usuário não logado. Abrindo modal de login...');
                    modalAntes.style.display = 'block';
                    modalDepois.style.display = 'none';
                } else {
                    // Se estiver logado
                    console.log('Usuário logado. Abrindo modal de usuário...');
                    modalAntes.style.display = 'none';
                    modalDepois.style.display = 'block';
                    if (document.getElementById('nomeUsuario')) {
                        document.getElementById('nomeUsuario').textContent = data.nome;
                        console.log('Nome do usuário atualizado:', data.nome);
                    }
                }
            })
            .catch(error => {
                console.error('Erro ao verificar login:', error);
                console.log('Mostrando modal de login devido ao erro...');
                modalAntes.style.display = 'block';
                modalDepois.style.display = 'none';
            });
    }

    // Evento para abrir o modal de login
    if (abrirModal) {
        abrirModal.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Botão de usuário clicado. Verificando login...');
            verificarLogin();
        });
    }

    // Evento para fechar o modal de login
    if (fecharModalAntes) {
        fecharModalAntes.addEventListener('click', function () {
            console.log('Fechando modal de login...');
            modalAntes.style.display = 'none';
        });
    }

    // Eventos para o modal de logout
    if (btnConfirmarLogout) {
        btnConfirmarLogout.addEventListener('click', function () {
            console.log('Iniciando processo de logout...');
            // Faz logout
            fetch('logout.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Resposta do logout:', data);
                    if (data.success) {
                        console.log('Logout realizado com sucesso. Fechando modais...');
                        modalLogout.style.display = 'none';
                        verificarLogin(); // Atualiza a exibição dos modais
                    }
                })
                .catch(error => {
                    console.error('Erro ao fazer logout:', error);
                });
        });
    }

    if (btnCancelarLogout) {
        btnCancelarLogout.addEventListener('click', function () {
            console.log('Cancelando logout. Fechando modal de confirmação...');
            modalLogout.style.display = 'none';
        });
    }

    // Fecha modais ao clicar fora
    window.addEventListener('click', function (e) {
        if (e.target === modalAntes) {
            console.log('Clicou fora do modal de login. Fechando...');
            modalAntes.style.display = 'none';
        }
        if (e.target === modalDepois) {
            console.log('Clicou fora do modal de usuário. Fechando...');
            modalDepois.style.display = 'none';
        }
        if (e.target === modalLogout) {
            console.log('Clicou fora do modal de logout. Fechando...');
            modalLogout.style.display = 'none';
        }
    });
});






