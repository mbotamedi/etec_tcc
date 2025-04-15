<!DOCTYPE html>
<html>

<head>
    <title>Configurando Sessão</title>
    <script>
        // Função para configurar o sessionStorage
        function setSessionStorage() {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            const nome = urlParams.get('nome');
            const email = urlParams.get('email');

            // Armazena os dados no sessionStorage
            sessionStorage.setItem('usuario_id', id);
            sessionStorage.setItem('usuario_nome', nome);
            sessionStorage.setItem('usuario_email', email);
            sessionStorage.setItem('usuario_logado', 'true');

            // Redireciona para a página inicial
            window.location.href = '../index.php';
        }
    </script>
</head>

<body onload="setSessionStorage()">
    <p>Configurando sua sessão...</p>
</body>

</html>