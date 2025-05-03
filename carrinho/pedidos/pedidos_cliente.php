<?php
session_start();

include("../../includes/consulta_pedidos.php");

// Verifica se o usuário está logado como cliente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    header("Location: ../../php/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina Três Irmãos - Meus Pedidos</title>
    <link rel="stylesheet" href="../../css/styles.css" />
    <link rel="stylesheet" href="../../css/inicio.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/mediaQuery.css">
    <link rel="stylesheet" href="../../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../../css/canvaLogado.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/favicon.ico" />
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!-- Font Awesome para carrinho -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gradient-custom {
            background: #f6d365;
            background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));
            background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
        }

        .pedido-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .pedido-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .badge-status {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .btn-detalhes {
            background-color: #f6d365;
            border: none;
            color: #333;
        }

        .btn-detalhes:hover {
            background-color: #f8c537;
            color: #000;
        }

        /* Estilos para a janela flutuante */
        .floating-window {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 1200px;
            max-height: 90vh;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            overflow: auto;
            display: none;
            font-size: 0.9em;
            /* Reduz o tamanho da fonte para 90% do padrão (ajuste conforme necessário) */
            ;
        }

        .floating-window-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .floating-window-header {
            background-color: #ffc107;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .floating-window-title {
            margin: 0;
            font-size: 1.5rem;
            color: #333;
        }

        .floating-window-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
            line-height: 1;
        }

        .floating-window-close:hover {
            color: #000;
        }

        .floating-window-body {
            padding: 20px;
            overflow-y: auto;
            max-height: 80vh;
            min-height: 300px;
        }

        .floating-window-footer {
            padding: 15px 20px;
            border-top: 1px solid #e0e0e0;
            text-align: right;
        }

        .floating-window .table-responsive {
            overflow-x: auto;
            max-height: none;
            /* Remova qualquer restrição de altura */
        }

        .floating-window .table {
            width: 100%;
            min-width: 600px;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .floating-window .table tbody tr {
            display: table-row !important;
            visibility: visible !important;
            height: auto !important;
            opacity: 1 !important;
            position: relative;
        }

        .floating-window .table td,
        .floating-window .table th {
            padding: 8px;
            vertical-align: middle;
            border: 1px solid #ddd;
            font-size: 0.9em;
            /* Garante que a fonte nas células da tabela também seja ajustada */
        }

        .floating-window .table img {
            max-width: 60px;
            height: auto;
        }

        .floating-window .table {
            display: table-row !important;
            visibility: visible !important;
        }

        .floating-window-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        @media (max-width: 768px) {
            .floating-window {
                width: 95%;
                max-height: 90vh;
            }

            .floating-window-body {
                padding: 20px;
                overflow-y: auto;
                max-height: 70vh;
                /* Ajuste para garantir que o conteúdo não seja cortado */
                flex-grow: 1;
            }

            .floating-window .table {
                width: 100%;
                min-width: 600px;
            }

            .floating-window .table img {
                max-width: 60px;
                height: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include("../../php/navbar.php"); ?>
    <!-- Navigation End -->

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                <div class="col-md-3">
                    <!-- Sidebar do Cliente -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">Minha Conta</h5>
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="pedidos_cliente.php" class="list-group-item list-group-item-action active">Meus Pedidos</a>
                            <a href="../../php/conta.php" class="list-group-item list-group-item-action">Meus Dados</a>
                            <a href="enderecos_cliente.php" class="list-group-item list-group-item-action">Meus Endereços</a>
                            <a href="../../php/logout.php" class="list-group-item list-group-item-action text-danger">Sair</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h3 class="mb-0">Meus Pedidos</h3>
                        </div>
                        <div class="card-body">
                            <?php if (mysqli_num_rows($resultado_pedidos) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nº Pedido</th>
                                                <th>Data</th>
                                                <th>Itens</th>
                                                <th>Valor Total</th>
                                                <th>Tipo Entrega</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($pedido = mysqli_fetch_assoc($resultado_pedidos)): ?>
                                                <tr>
                                                    <td>#<?= str_pad($pedido['id'], 6, '0', STR_PAD_LEFT) ?></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($pedido['emissao'])) ?></td>
                                                    <td><?= $pedido['total_itens'] ?></td>
                                                    <td>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></td>
                                                    <td>
                                                        <?= ucfirst($pedido['tipo_entrega']) ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-detalhes" onclick="detalhesPedido(<?= $pedido['id'] ?>, event)">
                                                            <i class="bi bi-eye-fill"></i> Detalhes
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    Você ainda não realizou nenhum pedido.
                                    <a href="../../index.php" class="alert-link">Ir para a loja</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Janela flutuante para detalhes do pedido -->
    <div id="floatingWindow" class="floating-window" style="display: none;">
        <div class="floating-window-content">
            <div class="floating-window-header">
                <h5 class="floating-window-title">Detalhes do Pedido</h5>
                <button type="button" class="floating-window-close" onclick="closeFloatingWindow()">×</button>
            </div>
            <div class="floating-window-body" id="detalhesPedidoContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                </div>
            </div>
            <div class="floating-window-footer">
                <button type="button" class="btn btn-secondary" onclick="closeFloatingWindow()">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include("../../php/footer.php"); ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/scripts.js"></script>
    <script src="../../js/funcao.js"></script>

    <script>
        async function detalhesPedido(idPedido, event) {
            event.preventDefault();
            try {
                console.log('Carregando detalhes do pedido ID:', idPedido);
                const floatingWindow = document.getElementById('floatingWindow');
                const floatingWindowBody = document.getElementById('detalhesPedidoContent');
                const backdrop = document.createElement('div');
                backdrop.className = 'floating-window-backdrop';
                document.body.appendChild(backdrop);

                floatingWindowBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-warning" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p>Carregando detalhes...</p>
            </div>
        `;

                floatingWindow.style.display = 'block';
                backdrop.style.display = 'block';

                const url = `detalhes_pedidos.php?id=${idPedido}`;
                console.log('Requisição para:', url);
                const response = await fetch(url, {
                    cache: 'no-store'
                });

                console.log('Status da resposta:', response.status);
                const data = await response.text();
                console.log('Conteúdo retornado (primeiros 1000 caracteres):', data.substring(0, 1000));
                console.log('Número de linhas <tr> no HTML retornado:', (data.match(/<tr>/g) || []).length);

                if (!response.ok) {
                    throw new Error(`Erro HTTP ${response.status}: ${response.statusText}`);
                }

                if (!data.trim()) {
                    throw new Error('Resposta vazia do servidor');
                }

                floatingWindowBody.innerHTML = data;

                setTimeout(() => {
                    const rows = floatingWindowBody.querySelectorAll('.table tbody tr');
                    console.log('Número de <tr> renderizados:', rows.length);
                    rows.forEach((row, index) => {
                        row.style.display = 'table-row';
                        row.style.visibility = 'visible';
                        row.style.opacity = '1';
                        console.log(`Linha ${index + 1} visível:`, window.getComputedStyle(row).display !== 'none' && window.getComputedStyle(row).visibility !== 'hidden');
                        console.log(`Conteúdo da linha ${index + 1}:`, row.innerHTML.substring(0, 200));
                    });
                    console.log('Forçando exibição das linhas');
                }, 100);

                if (floatingWindowBody.scrollHeight > floatingWindowBody.clientHeight) {
                    floatingWindowBody.style.paddingRight = '1rem';
                }
            } catch (error) {
                console.error('Erro:', error);
                floatingWindowBody.innerHTML = `
            <div class="alert alert-danger">
                <h5>Erro ao carregar detalhes</h5>
                <p>${error.message}</p>
                <p>URL: ${url}</p>
                <button onclick="detalhesPedido(${idPedido}, event)" class="btn btn-warning btn-sm mt-2">
                    Tentar novamente
                </button>
            </div>
        `;
            }
        }

        function closeFloatingWindow() {
            const floatingWindow = document.getElementById('floatingWindow');
            const backdrop = document.querySelector('.floating-window-backdrop');
            if (floatingWindow) floatingWindow.style.display = 'none';
            if (backdrop) backdrop.remove();
        }
    </script>
</body>

</html>