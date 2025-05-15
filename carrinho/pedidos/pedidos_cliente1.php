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
    <link rel="stylesheet" href="../../css/telaFlutuante.css">
    <link rel="icon" type="image/x-icon" href="../../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jockey+One&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("../../php/navbar.php"); ?>

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">Minha Conta</h5>
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="mostrarPedidos()">Meus Pedidos</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="mostrarEnderecos()">Meus Endereços</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="mostrarConta()">Meus Dados</a>
                            <a href="../../php/logout.php" class="list-group-item list-group-item-action text-danger">Sair</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <!-- Seção de Pedidos -->
                    <div id="secaoPedidos" class="card">
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
                                                    <td><?= ucfirst($pedido['tipo_entrega']) ?></td>
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

                    <!-- Seção de Endereços -->
                    <div id="secaoEnderecos" class="card" style="display: none;">
                        <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Meus Endereços</h3>
                            <a href="cadastro_endereco.php" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle"></i> Adicionar Endereço
                            </a>
                        </div>
                        <div class="card-body">
                            <div id="enderecosContent">
                                <div class="text-center py-4">
                                    <div class="spinner-border text-warning" role="status">
                                        <span class="visually-hidden">Carregando...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Seção de conta -->
                    <div id="conta" class="card" style="display: none;">
                        <div class="card-header bg-warning">
                            <h3>Meus Dados</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-4">
                                <div>
                                    <?php include('../../php/conta.php'); ?>
                                </div>
                            </div>

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
        <div class="floating-window-backdrop" style="display: none;"></div>
    </div>

    <?php include("../../php/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/scripts.js"></script>
    <script src="../../js/funcao.js"></script>
    <script src="../../js/pedidos.js"></script>
    <script src="../../js/gerenciar.js"></script>


</body>

</html>