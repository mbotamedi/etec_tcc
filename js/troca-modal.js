document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM carregado, iniciando configuração dos modais e menu...');

    // Elementos do Menu
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.menu');

    // Elementos dos Modais
    const modalAntes = document.getElementById("modalAntes");
    const modalDepois = document.getElementById("modalDepois");
    const abrirModalBtn = document.getElementById("abrirModal");
    const abrirModalMenuBtn = document.getElementById("abrirModalMenu");
    const fecharModalAntes = document.getElementById("fecharModalAntes");
    const fecharModalDepois = document.getElementById("fecharModalDepois");
    const nomeUsuario = document.getElementById("nomeUsuario");

    // Elementos do modal de logout
    const modalLogout = document.getElementById('modalLogout');
    const btnConfirmarLogout = document.getElementById('btnConfirmarLogout');
    const btnCancelarLogout = document.getElementById('btnCancelarLogout');
    const btnLogout = document.querySelector('.logout');

    // Configuração do Menu
    if (menuToggle && menu) {
        menuToggle.addEventListener('click', () => {
            if (menu.classList.contains('active')) {
                menu.classList.remove('active');
                menu.style.display = 'none';
            } else {
                menu.classList.add('active');
                menu.style.display = 'block';
            }
        });

        // Fecha o menu ao clicar fora
        document.addEventListener('click', (event) => {
            if (!menuToggle.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.remove('active');
                menu.style.display = 'none';
            }
        });
    }

    // Função para atualizar o estado do modal
    function atualizarEstadoModal(data) {
        if (!modalAntes || !modalDepois || !nomeUsuario) {
            return;
        }

        if (data.logado) {
            nomeUsuario.textContent = data.nome;
            modalDepois.style.display = "block";
            modalAntes.style.display = "none";
            modalDepois.classList.add('show');
            modalAntes.classList.remove('show');
        } else {
            modalAntes.style.display = "block";
            modalDepois.style.display = "none";
            modalAntes.classList.add('show');
            modalDepois.classList.remove('show');
        }
    }

    // Função para verificar o estado de login
    function verificarLogin() {
        if (!modalAntes || !modalDepois || !nomeUsuario) {
            return;
        }

        fetch('PHP/verificar_login.php')
            .then(response => response.json())
            .then(data => {
                atualizarEstadoModal(data);
            })
            .catch(error => {
                if (modalAntes) {
                    modalAntes.style.display = "block";
                    modalAntes.classList.add('show');
                }
                if (modalDepois) {
                    modalDepois.style.display = "none";
                    modalDepois.classList.remove('show');
                }
            });
    }

    // Função para fechar todos os modais
    function fecharTodosModais() {
        if (modalAntes) {
            modalAntes.style.display = "none";
            modalAntes.classList.remove('show');
        }
        if (modalDepois) {
            modalDepois.style.display = "none";
            modalDepois.classList.remove('show');
        }
    }

    // Função para abrir o modal
    function abrirModal(e) {
        if (e) {
            e.preventDefault();
        }

        // Verifica se algum modal está aberto
        const modalAntesAberto = modalAntes && modalAntes.style.display === "block";
        const modalDepoisAberto = modalDepois && modalDepois.style.display === "block";

        if (modalAntesAberto || modalDepoisAberto) {
            fecharTodosModais();
        } else {
            verificarLogin();
        }
    }

    // Event Listeners dos Modais
    if (abrirModalBtn) {
        abrirModalBtn.addEventListener('click', abrirModal);
    }

    if (abrirModalMenuBtn) {
        abrirModalMenuBtn.addEventListener('click', abrirModal);
    }

    if (fecharModalAntes) {
        fecharModalAntes.addEventListener('click', function () {
            if (modalAntes) {
                modalAntes.style.display = "none";
                modalAntes.classList.remove('show');
            }
        });
    }

    if (fecharModalDepois) {
        fecharModalDepois.addEventListener('click', function () {
            if (modalDepois) {
                modalDepois.style.display = "none";
                modalDepois.classList.remove('show');
            }
        });
    }

    // Fechar modais ao clicar fora
    window.addEventListener('click', function (e) {
        if (e.target === modalAntes || e.target === modalDepois) {
            fecharTodosModais();
        }
    });

    // Função para mostrar o modal de logout
    function mostrarModalLogout() {
        modalLogout.style.display = 'flex';
    }

    // Função para esconder o modal de logout
    function esconderModalLogout() {
        modalLogout.style.display = 'none';
    }

    // Event listener para o botão de logout
    if (btnLogout) {
        btnLogout.addEventListener('click', function (e) {
            e.preventDefault();
            mostrarModalLogout();
        });
    }

    // Event listener para o botão de confirmar logout
    if (btnConfirmarLogout) {
        btnConfirmarLogout.addEventListener('click', function () {
            fetch('php/logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erro ao fazer logout:', error);
                });
        });
    }

    // Event listener para o botão de cancelar logout
    if (btnCancelarLogout) {
        btnCancelarLogout.addEventListener('click', function () {
            esconderModalLogout();
        });
    }

    // Fechar modal ao clicar fora dele
    modalLogout.addEventListener('click', function (e) {
        if (e.target === modalLogout) {
            esconderModalLogout();
        }
    });

    console.log('Configuração dos modais e menu concluída');
});
