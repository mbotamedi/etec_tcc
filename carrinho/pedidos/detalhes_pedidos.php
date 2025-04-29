<?php
session_start();
include("../../includes/conexao.php");

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
    die("Acesso negado.");
}

if (!isset($_GET['id'])) {
    die("Pedido não especificado.");
}

$id_pedido = $_GET['id'];
$id_cliente = $_SESSION['usuario']['id'];

// Verifica se o pedido pertence ao cliente
$verifica_pedido = mysqli_query($conexao, "SELECT id FROM tb_pedidos WHERE id = '$id_pedido' AND id_cliente = '$id_cliente'");
if (mysqli_num_rows($verifica_pedido) == 0) {
    die("Pedido não encontrado ou não pertence a este cliente.");
}

// Consulta os detalhes do pedido
$query_pedido = "SELECT 
                    p.*, 
                    e.endereco, e.numero, e.descricao,
                     e.bairro, e.cep,
                    c.nome_cidade, c.sigla_estado
                 FROM 
                    tb_pedidos p
                 LEFT JOIN 
                    tb_cliente_endereco e ON p.id_endereco = e.id
                 LEFT JOIN 
                    tb_cidades c ON e.id_cidade = c.codigo_cidade
                 WHERE 
                    p.id = '$id_pedido'";
$resultado_pedido = mysqli_query($conexao, $query_pedido);
$pedido = mysqli_fetch_assoc($resultado_pedido);

// Consulta os itens do pedido
$query_itens = "SELECT 
                    pi.*, 
                    pr.descricao, pr.imagem1
                FROM 
                    tb_pedidos_itens pi
                JOIN 
                    tb_produtos pr ON pi.id_produtos = pr.id
                WHERE 
                    pi.id_pedidos = '$id_pedido'";
$resultado_itens = mysqli_query($conexao, $query_itens);
$itens = mysqli_fetch_all($resultado_itens, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-md-6">
        <h5>Informações do Pedido</h5>
        <ul class="list-group mb-4">
            <li class="list-group-item">
                <strong>Nº Pedido:</strong> #<?= str_pad($pedido['id'], 6, '0', STR_PAD_LEFT) ?>
            </li>
            <li class="list-group-item">
                <strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido['emissao'])) ?>
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
    
    <div class="col-md-6">
        <h5>Endereço de Entrega</h5>
        <?php if ($pedido['tipo_entrega'] == 'entrega' && !empty($pedido['endereco'])): ?>
            <address class="list-group mb-4">
                <div class="list-group-item">
                    <?= $pedido['endereco'] ?>, <?= $pedido['numero'] ?>
                    <?= !empty($pedido['complemento']) ? ' - '.$pedido['complemento'] : '' ?>
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

<h5 class="mt-4">Itens do Pedido</h5>
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
            <?php foreach ($itens as $item): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <?php if (!empty($item['imagem1'])): ?>
                                <img src="<?= $item['imagem1'] ?>" alt="<?= $item['descricao'] ?>" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php endif; ?>
                            <span><?= $item['descricao'] ?></span>
                        </div>
                    </td>
                    <td><?= $item['qtd'] ?></td>
                    <td>R$ <?= number_format($item['valor_untiario'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($item['qtd'] * $item['valor_untiario'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div>