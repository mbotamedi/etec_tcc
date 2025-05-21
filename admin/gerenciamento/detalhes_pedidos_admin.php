<?php

ob_start();

include('../php/config.php');
include("../includes/conexao.php");

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'usuario') {
    die("Acesso negado.");
}

if (!isset($_GET['id'])) {
    die("Pedido não especificado.");
}

$id_pedido = mysqli_real_escape_string($conexao, $_GET['id']);
$id_cliente = $_SESSION['usuario']['id'];

$verifica_pedido = mysqli_query($conexao, "SELECT id FROM tb_pedidos WHERE id = '$id_pedido'");
if (mysqli_num_rows($verifica_pedido) == 0) {
    die("Pedido não encontrado ou não pertence a este cliente.");
}

$query_pedido = "SELECT 
                    cli.nome, p.*, 
                    e.endereco, e.numero, e.descricao,
                    e.bairro, e.cep,
                    c.nome_cidade, c.sigla_estado
                 FROM 
                    tb_clientes cli
                 LEFT JOIN 
                    tb_pedidos p on p.id_cliente = cli.id
                 LEFT JOIN 
                    tb_cliente_endereco e ON p.id_endereco = e.id
                 LEFT JOIN 
                    tb_cidades c ON e.id_cidade = c.codigo_cidade
                 WHERE 
                    p.id = '$id_pedido'";
$resultado_pedido = mysqli_query($conexao, $query_pedido);
if (!$resultado_pedido) {
    die("Erro na consulta do pedido: " . mysqli_error($conexao));
}
$pedido = mysqli_fetch_assoc($resultado_pedido);

$query_itens = "SELECT 
                    pi.*, 
                    pr.descricao, pr.id
                FROM 
                    tb_pedidos_itens pi
                JOIN 
                    tb_produtos pr ON pi.id_produtos = pr.id
                WHERE 
                    pi.id_pedidos = '$id_pedido'";
$resultado_itens = mysqli_query($conexao, $query_itens);
if (!$resultado_itens) {
    die("Erro na consulta dos itens: " . mysqli_error($conexao));
}

$itens = [];
while ($row = mysqli_fetch_assoc($resultado_itens)) {
    $itens[] = $row;
}
error_log("Número de itens encontrados: " . count($itens));
?>

<style>
    h5 {
        background-color: #f8c537;
        color: #000;
        padding: 15px 20px;
    }
</style>
<!-- Início do layout ajustado -->
<div class="container">
    <!-- Botão Voltar -->
    <div class="mb-3">
        <button onclick="history.back()" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </button>
    </div>
    <!-- Linha com Informações do Pedido e Itens do Pedido lado a lado -->
    <div class="row mb-4">
        <!-- Seção 1: Informações do Pedido (coluna à esquerda) -->
        <div class="col-md-4">
            <h5>Informações do Pedido</h5>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Nº Pedido:</strong> #<?= str_pad($pedido['id'], 4, '0', STR_PAD_LEFT) ?>

                </li>
                <li class="list-group-item">
                    <strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido['emissao'])) ?>
                </li>
                <li class="list-group-item">
                    <strong>Cliente:</strong> <?= $pedido['nome']  ?>
                </li>
                <li class="list-group-item">
                    <strong>Valor Total:</strong> R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?>
                </li>
                <li class="list-group-item">
                    <strong>Forma de Entrega:</strong> <?= ucfirst($pedido['tipo_entrega']) ?>
                </li>
                <li class="list-group-item">
                    <strong>Status:</strong>
                    <span class="badge bg-warning text-dark">Em processamento</span>
                </li>
            </ul>
        </div>

        <!-- Seção 3: Itens do Pedido (coluna à direita) -->
        <div class="col-md-8">
            <h5>Itens do Pedido</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $itemCount = 0;
                        foreach ($itens as $item):
                            $itemCount++;
                            // Calcula o caminho da imagem para cada item
                            $foto = '../assets/fotos/' . $item['id'] . '.png';
                        ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $foto ?>" alt="<?= htmlspecialchars($item['descricao']) ?>" class="img-product rounded" style="max-width: 100%; max-height: 80px; object-fit: cover;" onerror="this.src='../assets/img/no-image.png';">
                                            <span><?= htmlspecialchars($item['descricao']) ?></span>
                                        </div>
                                </td>
                                <td class="text-center align-middle"><?= $item['qtd'] ?></td>
                                <td class="text-center align-middle">R$ <?= number_format($item['valor_untiario'], 2, ',', '.') ?></td>
                                <td class="text-center align-middle">R$ <?= number_format($item['qtd'] * $item['valor_untiario'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach;
                        error_log("Número de itens renderizados: $itemCount");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Seção 2: Endereço de Entrega (abaixo das duas seções) -->
    <div class="row mb-4">
        <div class="col-12">
            <h5>Endereço de Entrega</h5>
            <?php if ($pedido['tipo_entrega'] == 'entrega' && !empty($pedido['endereco'])): ?>
                <address class="list-group">
                    <div class="list-group-item">
                        <?= $pedido['endereco'] ?>, <?= $pedido['numero'] ?>
                        <?= !empty($pedido['complemento']) ? ' - ' . $pedido['complemento'] : '' ?>
                    </div>
                    <div class="list-group-item"><?= $pedido['bairro'] ?></div>
                    <div class="list-group-item">
                        <?= $pedido['nome_cidade'] ?>/<?= $pedido['sigla_estado'] ?>
                    </div>
                    <div class="list-group-item">CEP: <?= $pedido['cep'] ?></div>
                </address>
            <?php else: ?>
                <div class="alert alert-info">Retirada no local</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Fim do layout ajustado -->

<?php
$output = ob_get_clean();
echo $output;
?>