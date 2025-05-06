<?php
// detalhe_pedido_admin.php

// Ajustar parâmetros para compatibilidade com detalhes_pedidos.php
$_GET['id'] = $_GET['id_pedido'] ?? null;
$is_admin = true; // Definir explicitamente

define('INCLUDED_BY_ADMIN', true);

// Salvar o diretório atual
$current_dir = getcwd();
// Mudar para a raiz do projeto para corrigir o caminho de includes
chdir('D:/wamp64/www/etec_tcc/');

// Iniciar buffer para capturar saída
ob_start();
include('carrinho/pedidos/detalhes_pedidos.php');
$output = ob_get_clean();

// Restaurar o diretório original
chdir($current_dir);

// Verificar se houve erro
if (strpos($output, 'alert alert-danger') !== false) {
    echo '<div class="alert alert-danger">Erro ao carregar detalhes do pedido: ' . htmlspecialchars($output) . '</div>';
    return;
}

// $pedido e $itens estão disponíveis para uso
?>

<div class="app-content">
    <div class="container-fluid">
        <!-- Botão Voltar -->
        <a href="?pg=Pedidos" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>

        <h3 class="mb-4">Detalhes do Pedido #<?php echo str_pad($pedido['id'], 6, '0', STR_PAD_LEFT); ?></h3>

        <div class="row">
            <!-- Informações do Pedido -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Informações do Pedido
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Nº Pedido:</strong>
                                <span>#<?php echo str_pad($pedido['id'], 6, '0', STR_PAD_LEFT); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Cliente:</strong>
                                <span><?php echo htmlspecialchars($pedido['cliente']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Data:</strong>
                                <span><?php echo date('d/m/Y H:i', strtotime($pedido['emissao'])); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Valor Total:</strong>
                                <span>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Forma de Entrega:</strong>
                                <span><?php echo ucfirst($pedido['tipo_entrega']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Status:</strong>
                                <span class="badge bg-warning text-dark">Em processamento</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Itens do Pedido -->
            <div class="col-lg-8 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Itens do Pedido
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Produto</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-center">Valor Unitário</th>
                                        <th class="text-center">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($itens) > 0): ?>
                                        <?php foreach ($itens as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!empty($item['imagem1'])): ?>
                                                            <img src="<?php echo "../../" . $item['imagem1']; ?>" alt="<?php echo htmlspecialchars($item['descricao']); ?>" class="img-product rounded me-2" style="width: 60px; height: 60px; object-fit: cover;" onerror="this.src='../../assets/img/no-image.png';">
                                                        <?php else: ?>
                                                            <img src="../../assets/img/no-image.png" alt="Sem imagem" class="img-product rounded me-2" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <?php endif; ?>
                                                        <span><?php echo htmlspecialchars($item['descricao']); ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-center"><?php echo $item['qtd']; ?></td>
                                                <td class="text-center">R$ <?php echo number_format($item['valor_untiario'], 2, ',', '.'); ?></td>
                                                <td class="text-center">R$ <?php echo number_format($item['qtd'] * $item['valor_untiario'], 2, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Nenhum item encontrado.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td class="text-center"><strong>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Endereço de Entrega -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Endereço de Entrega
                    </div>
                    <div class="card-body">
                        <?php if ($pedido['tipo_entrega'] == 'entrega' && !empty($pedido['endereco'])): ?>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <?php echo htmlspecialchars($pedido['endereco']); ?>, <?php echo htmlspecialchars($pedido['numero']); ?>
                                    <?php echo !empty($pedido['complemento']) ? ' - ' . htmlspecialchars($pedido['complemento']) : ''; ?>
                                </li>
                                <li class="list-group-item"><?php echo htmlspecialchars($pedido['bairro']); ?></li>
                                <li class="list-group-item">
                                    <?php echo htmlspecialchars($pedido['nome_cidade']); ?>/<?php echo htmlspecialchars($pedido['sigla_estado']); ?>
                                </li>
                                <li class="list-group-item">CEP: <?php echo htmlspecialchars($pedido['cep']); ?></li>
                            </ul>
                        <?php else: ?>
                            <div class="alert alert-info">Retirada no local</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .card-header {
        border-radius: 10px 10px 0 0;
        padding: 15px;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .badge {
        font-size: 1rem;
        padding: 8px 12px;
    }

    @media (max-width: 768px) {
        .card {
            margin-bottom: 15px;
        }

        .img-product {
            width: 50px;
            height: 50px;
        }
    }
</style>