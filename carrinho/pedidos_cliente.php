<?php
session_start();

include ("../includes/consulta_pedidos.php");

// Verifica se o usuário está logado como cliente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina Três Irmãos - Meus Pedidos</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/mediaQuery.css">
    <link rel="stylesheet" href="../css/canvaDeslogado.css">
    <link rel="stylesheet" href="../css/canvaLogado.css">
    <!-- Favicon-->
    <link rel="icon" type="../image/x-icon" href="../assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!--FONTS-------->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!---Carrinho--->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style>
        .gradient-custom {
            background: #f6d365;
            background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));
            background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
        }
        .pedido-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .pedido-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
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
    </style>
</head>

<body>
    <!-- Navigation-->
    <?php include("../php/navbar.php"); ?>
    <!-- Navigation End-->

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
                            <a href="../php/conta.php" class="list-group-item list-group-item-action">Meus Dados</a>
                            <a href="enderecos_cliente.php" class="list-group-item list-group-item-action">Meus Endereços</a>
                            <a href="../php/logout.php" class="list-group-item list-group-item-action text-danger">Sair</a>
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
                                                        <button class="btn btn-sm btn-detalhes" 
                                                                onclick="detalhesPedido(<?= $pedido['id'] ?>)">
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
                                    <a href="../index.php" class="alert-link">Ir para a loja</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para detalhes do pedido -->
    <div class="modal fade" id="modalDetalhes" tabindex="-1" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="modalDetalhesLabel">Detalhes do Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detalhesPedidoContent">
                    <!-- Conteúdo será carregado via AJAX -->
                    <div class="text-center">
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!---Footer--->
    <?php include("../php/footer.php"); ?>

    <!--------------SCRIPTS-------------->
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/funcao.js"></script>
    
    <script>
        // Função para carregar detalhes do pedido via AJAX
        function detalhesPedido(idPedido) {
            // Mostra o modal
            var modal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
            modal.show();
            
            // Carrega o conteúdo via AJAX
            fetch(`../php/detalhes_pedido.php?id=${idPedido}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('detalhesPedidoContent').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('detalhesPedidoContent').innerHTML = `
                        <div class="alert alert-danger">
                            Ocorreu um erro ao carregar os detalhes do pedido.
                        </div>
                    `;
                });
        }
    </script>
</body>
</html>