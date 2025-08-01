<?php
@session_start();
include("../../includes/conexao.php");
include("../../pgseguro/config.php");

$id_pedido = isset($_GET['id_pedido']) ? (int)$_GET['id_pedido'] : 0;

// Consulta o pedido e o status do pagamento inicial em uma única query
$query_pedido = "
    SELECT p.*, c.nome, pay.status AS payment_status
    FROM tb_pedidos p 
    JOIN tb_clientes c ON p.id_cliente = c.id
    LEFT JOIN tb_payments pay ON p.id = pay.id_pedidos
    WHERE p.id = ?
    ORDER BY pay.id DESC 
    LIMIT 1
";

$stmt = mysqli_prepare($conexao, $query_pedido);
mysqli_stmt_bind_param($stmt, "i", $id_pedido);
mysqli_stmt_execute($stmt);
$result_pedido = mysqli_stmt_get_result($stmt);
$pedido = mysqli_fetch_assoc($result_pedido);

// Define o status inicial. Se não houver pagamento, considera pendente.
$status_inicial = $pedido['payment_status'] ?? 'PENDING';


// ########## NOVA LINHA AQUI ##########
// O PHP monta a URL completa e correta para o script de verificação
$url_verificacao = BASE_URL . '/pgseguro/verificar_status.php';

//PEGAR A PAGINA ATUAL

$current_page = basename($_SERVER['PHP_SELF']);
$is_paginaatual = ($current_page == 'confirmacao_pedido.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Pedido - Cantina Três Irmãos</title>
    <link rel="stylesheet" href="../../css/styles.css" />
    <link rel="stylesheet" href="../../css/inicio.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../../css/canvaLogado.css">
    <link rel="icon" type="image/x-icon" href="../../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        .container-confirmacao {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .status-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .spinner-border {
            width: 4rem;
            height: 4rem;
        }

        h2 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .text-muted {
            font-size: 1.1rem;
        }

        .btn-continuar {
            margin-top: 30px;
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-continuar:hover {
            background-color: #0056b3;
        }

        /* Esconde as seções de status por padrão */
        .status-section {
            display: none;
        }
    </style>
</head>

<body>
    <?php include("../../php/navbar_ConfirmaPedido.php"); ?>

    <section class="py-5">
        <div class="container-confirmacao">

            <div id="status-pending" class="status-section">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h2 class="mt-3">Aguardando Confirmação do Pagamento</h2>
                <p class="text-muted">Seu pedido nº <?= $id_pedido ?> foi realizado e estamos aguardando a confirmação do pagamento.</p>
                <p>Isso pode levar alguns segundos. Por favor, não feche esta página.</p>
            </div>

            <div id="status-paid" class="status-section">
                <i class="bi bi-check-circle-fill text-success status-icon"></i>
                <h2>Pedido Confirmado!</h2>
                <p class="text-muted">Obrigado, <?= htmlspecialchars($pedido['nome']) ?>! O pagamento do seu pedido nº <?= $id_pedido ?> foi aprovado.</p>
                <p>Você receberá uma confirmação por e-mail em breve.</p>
            </div>

            <div id="status-declined" class="status-section">
                <i class="bi bi-x-circle-fill text-danger status-icon"></i>
                <h2>Pagamento Recusado</h2>
                <p class="text-muted">O pagamento para o seu pedido nº <?= $id_pedido ?> não foi autorizado.</p>
                <p>Por favor, tente novamente com outro método de pagamento ou entre em contato com seu banco.</p>
            </div>

            <a href="../../php/produtos.php" class="btn-continuar">Continuar Comprando</a>
        </div>
    </section>

    <?php include("../../php/footer.php"); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const idPedido = <?= $id_pedido ?>;
            const statusInicial = '<?= trim(strtoupper($status_inicial)) ?>';

            // ########## MUDANÇA IMPORTANTE AQUI ##########
            // A URL agora é pega da variável que o PHP criou. Sem adivinhação!
            const urlVerificacao = '<?= $url_verificacao ?>';

            let statusChecker;

            // ... (função showStatusSection continua igual) ...
            function showStatusSection(status) {
                document.querySelectorAll('.status-section').forEach(el => el.style.display = 'none');

                if (status === 'PAID') {
                    document.getElementById('status-paid').style.display = 'block';
                } else if (status === 'DECLINED' || status === 'CANCELED') {
                    document.getElementById('status-declined').style.display = 'block';
                } else {
                    document.getElementById('status-pending').style.display = 'block';
                }
            }

            async function checkStatus() {
                try {
                    // Usamos a URL completa que o PHP nos deu
                    const urlCompleta = `${urlVerificacao}?id_pedido=${idPedido}`;
                    console.log("Verificando status em:", urlCompleta);

                    const response = await fetch(urlCompleta);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    const statusRecebido = data.status ? data.status.trim().toUpperCase() : 'UNKNOWN';

                    console.log(`Status recebido da API: '${statusRecebido}'`);

                    if (statusRecebido === 'PAID' || statusRecebido === 'DECLINED' || statusRecebido === 'CANCELED') {
                        console.log("Status final detectado! Parando verificação.");
                        showStatusSection(statusRecebido);
                        clearInterval(statusChecker);
                    }
                } catch (error) {
                    console.error('Falha na verificação de status:', error);
                    clearInterval(statusChecker);
                }
            }

            showStatusSection(statusInicial);

            if (statusInicial === 'PENDING') {
                statusChecker = setInterval(checkStatus, 3000);
            }
        });
    </script>
    <!---<script src="../../js/carrinho.js"></script>
    <script>
        // Este arquivo está vazio pois os modais foram removidos
    </script>
    </script>--->

    <?php //if ($is_paginaatual): 
    ?>

    <!---<script>
        // Função para verificar o estado de login
        async function verificarLogin() {
            try {
                const response = await fetch('../../php/verificar_login.php', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
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
    </script>--->

    <?php //endif; 
    ?>
</body>

</html>