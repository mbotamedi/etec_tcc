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

    // Log dos elementos encontrados
    console.log('Elementos encontrados:', {
        // Menu
        menuToggle: !!menuToggle,
        menu: !!menu,
        // Modais
        modalAntes: !!modalAntes,
        modalDepois: !!modalDepois,
        abrirModalBtn: !!abrirModalBtn,
        abrirModalMenuBtn: !!abrirModalMenuBtn,
        fecharModalAntes: !!fecharModalAntes,
        fecharModalDepois: !!fecharModalDepois,
        nomeUsuario: !!nomeUsuario
    });

    // Configuração do Menu
    if (menuToggle && menu) {
        console.log('Configurando menu dropdown...');
        menuToggle.addEventListener('click', () => {
            console.log('Menu toggle clicado');
            if (menu.classList.contains('active')) {
                console.log('Fechando menu');
                menu.classList.remove('active');
                menu.style.display = 'none';
            } else {
                console.log('Abrindo menu');
                menu.classList.add('active');
                menu.style.display = 'block';
            }
        });

        // Fecha o menu ao clicar fora
        document.addEventListener('click', (event) => {
            if (!menuToggle.contains(event.target) && !menu.contains(event.target)) {
                console.log('Clicou fora do menu, fechando...');
                menu.classList.remove('active');
                menu.style.display = 'none';
            }
        });
    }

    // Função para atualizar o estado do modal
    function atualizarEstadoModal(data) {
        console.log('Atualizando estado do modal com dados:', data);
        if (!modalAntes || !modalDepois || !nomeUsuario) {
            console.error('Elementos necessários não encontrados');
            return;
        }

        if (data.logado) {
            console.log('Usuário logado, mostrando modal depois');
            nomeUsuario.textContent = data.nome;
            modalDepois.style.display = "block";
            modalAntes.style.display = "none";
            modalDepois.classList.add('show');
            modalAntes.classList.remove('show');
        } else {
            console.log('Usuário não logado, mostrando modal antes');
            modalAntes.style.display = "block";
            modalDepois.style.display = "none";
            modalAntes.classList.add('show');
            modalDepois.classList.remove('show');
        }
    }

    // Função para verificar o estado de login
    function verificarLogin() {
        console.log('Iniciando verificação de login...');
        if (!modalAntes || !modalDepois || !nomeUsuario) {
            console.error('Elementos necessários não encontrados:', {
                modalAntes: !!modalAntes,
                modalDepois: !!modalDepois,
                nomeUsuario: !!nomeUsuario
            });
            return;
        }

        fetch('PHP/verificar_login.php')
            .then(response => {
                console.log('Resposta recebida do servidor:', response);
                return response.json();
            })
            .then(data => {
                console.log('Dados recebidos:', data);
                atualizarEstadoModal(data);
            })
            .catch(error => {
                console.error('Erro ao verificar login:', error);
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
        console.log('Fechando todos os modais');
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
        console.log('Função abrirModal chamada');
        if (e) {
            e.preventDefault();
            console.log('Prevenindo comportamento padrão do evento');
        }

        // Verifica se algum modal está aberto
        const modalAntesAberto = modalAntes && modalAntes.style.display === "block";
        const modalDepoisAberto = modalDepois && modalDepois.style.display === "block";

        if (modalAntesAberto || modalDepoisAberto) {
            console.log('Modal já está aberto, fechando...');
            fecharTodosModais();
        } else {
            console.log('Modal fechado, abrindo...');
            verificarLogin();
        }
    }

    // Event Listeners dos Modais
    if (abrirModalBtn) {
        console.log('Adicionando listener ao botão abrirModal');
        abrirModalBtn.addEventListener('click', abrirModal);
    }

    if (abrirModalMenuBtn) {
        console.log('Adicionando listener ao botão abrirModalMenu');
        abrirModalMenuBtn.addEventListener('click', abrirModal);
    }

    if (fecharModalAntes) {
        console.log('Adicionando listener ao botão fecharModalAntes');
        fecharModalAntes.addEventListener('click', function () {
            console.log('Fechando modal antes');
            if (modalAntes) {
                modalAntes.style.display = "none";
                modalAntes.classList.remove('show');
            }
        });
    }

    if (fecharModalDepois) {
        console.log('Adicionando listener ao botão fecharModalDepois');
        fecharModalDepois.addEventListener('click', function () {
            console.log('Fechando modal depois');
            if (modalDepois) {
                modalDepois.style.display = "none";
                modalDepois.classList.remove('show');
            }
        });
    }

    // Fechar modais ao clicar fora
    window.addEventListener('click', function (e) {
        console.log('Clique fora dos modais detectado');
        if (e.target === modalAntes || e.target === modalDepois) {
            console.log('Clicou no modal, fechando...');
            fecharTodosModais();
        }
    });

    // Verificar estado de login periodicamente
    setInterval(verificarLogin, 5000); // Verifica a cada 5 segundos

    console.log('Configuração dos modais e menu concluída');
});
