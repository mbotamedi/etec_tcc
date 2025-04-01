
    /*Simulação de dados do usuário (normalmente você obteria isso do PHP)*/
    const usuarioLogado = {
        nome: "<?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario']['nome'] : ''; ?>",
        papel: "<?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario']['papel'] : ''; ?>"
    };

    // Função para alternar entre os modais
    function alternarModais(usuario) {
        const modalAntes = document.getElementById("meuModal");
        const modalUsuario = document.getElementById("modalUsuario");

        if (usuario.nome && usuario.papel === 'admin') {
            // Se o usuário estiver logado e for admin, exibe o modal do usuário
            document.getElementById("nomeUsuario").innerText = usuario.nome; // Atualiza o nome do usuário
            modalUsuario.style.display = "block"; // Exibe o modal do usuário
            modalAntes.style.display = "none"; // Esconde o modal de início
        } else {
            // Se o usuário não estiver logado ou não for admin, exibe o modal de início
            modalAntes.style.display = "block"; // Exibe o modal de início
            modalUsuario.style.display = "none"; // Esconde o modal do usuário
        }
    }

    // Chama a função para alternar os modais
    alternarModais(usuarioLogado);

    // Função para fechar o modal
    document.getElementById("fecharModal").onclick = function() {
        document.getElementById("meuModal").style.display = "none";
    };