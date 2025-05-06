<?php
header('Content-Type: text/html; charset=utf-8');
ob_start();
session_start();
include("../../includes/conexao.php");

// Verifica se é um administrador
$is_admin = isset($_GET['admin']) && $_GET['admin'] == 1;

// Verifica permissões
if ($is_admin) {
    // Para administradores, exige sessão válida e tipo 'usuario'
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'usuario') {
        echo '<div class="alert alert-danger">Acesso negado para administradores.</div>';
        exit;
    }
} else {
    // Para clientes, exige sessão válida e tipo 'cliente'
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'cliente') {
        echo '<div class="alert alert-danger">Acesso negado para clientes.</div>';
        exit;
    }
}

// Verifica se o ID do pedido foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger">ID do pedido inválido.</div>';
    exit;
}

$id_pedido = mysqli_real_escape_string($conexao, $_GET['id']);

// Verifica se o pedido existe e, para clientes, se pertence ao cliente logado
if (!$is_admin) {
    $id_cliente = $_SESSION['usuario']['id'];
    $verifica_pedido = mysqli_query($conexao, "SELECT id FROM tb_pedidos WHERE id = '$id_pedido' AND id_cliente = '$id_cliente'");
    if (mysqli_num_rows($verifica_pedido) == 0) {
        echo '<div class="alert alert-danger">Pedido não encontrado ou não pertence a este cliente.</div>';
        exit;
    }
} else {
    // Para administradores, apenas verifica se o pedido existe
    $verifica_pedido = mysqli_query($conexao, "SELECT id FROM tb_pedidos WHERE id = '$id_pedido'");
    if (mysqli_num_rows($verifica_pedido) == 0) {
        echo '<div class="alert alert-danger">Pedido não encontrado.</div>';
        exit;
    }
}

// Consulta para o pedido específico
$query_pedido = "
    SELECT 
        p.*, 
        e.endereco, e.numero, e.descricao, e.complemento,
        e.bairro, e.cep,
        c.nome_cidade, c.sigla_estado,
        cl.nome AS cliente
    FROM 
        tb_pedidos p
    LEFT JOIN 
        tb_cliente_endereco e ON p.id_endereco = e.id
    LEFT JOIN 
        tb_cidades c ON e.id_cidade = c.codigo_cidade
    LEFT JOIN 
        tb_clientes cl ON p.id_cliente = cl.id
    WHERE 
        p.id = '$id_pedido'";
$resultado_pedido = mysqli_query($conexao, $query_pedido);

if (!$resultado_pedido || mysqli_num_rows($resultado_pedido) == 0) {
    echo '<div class="alert alert-danger">Erro na consulta do pedido: ' . mysqli_error($conexao) . '</div>';
    exit;
}

$pedido = mysqli_fetch_assoc($resultado_pedido);

// Consulta para os itens do pedido
$query_itens = "
    SELECT 
        pi.*, 
        pr.descricao, pr.imagem1
    FROM 
        tb_pedidos_itens pi
    JOIN 
        tb_produtos pr ON pi.id_produtos = pr.id
    WHERE 
        pi.id_pedidos = '$id_pedido'";
$resultado_itens = mysqli_query($conexao, $query_itens);

if (!$resultado_itens) {
    echo '<div class="alert alert-danger">Erro na consulta dos itens: ' . mysqli_error($conexao) . '</div>';
    exit;
}

$itens = [];
while ($row = mysqli_fetch_assoc($resultado_itens)) {
    $itens[] = $row;
}

error_log("Número de itens encontrados: " . count($itens));
?>

<div class="row">
    <div class="col-md-4">
        <h5>Informações do Pedido</h5>
        <ul class="list-group mb-4">
            <li class="list-group-item">
                <strong>Nº Pedido:</strong> #<?= str_pad($pedido['id'], 6, '0', STR_PAD_LEFT) ?>
            </li>
            <li class="list-group-item">
                <strong>Cliente:</strong> <?= htmlspecialchars($pedido['cliente']) ?>
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
                    ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if (!empty($item['imagem1'])): ?>
                                        <img src="<?= "../../" . $item['imagem1'] ?>" alt="<?= htmlspecialchars($item['descricao']) ?>" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.style.display='none';">
                                    <?php else: ?>
                                        <span>Imagem não disponível</span>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($item['descricao']) ?></span>
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
    </div>
    <div class="col-md-4">
        <h5>Endereço de Entrega</h5>
        <?php if ($pedido['tipo_entrega'] == 'entrega' && !empty($pedido['endereco'])): ?>
            <address class="list-group mb-4">
                <div class="list-group-item">
                    <?= htmlspecialchars($pedido['endereco']) ?>, <?= htmlspecialchars($pedido['numero']) ?>
                    <?= !empty($pedido['complemento']) ? ' - ' . htmlspecialchars($pedido['complemento']) : '' ?>
                </div>
                <div class="list-group-item"><?= htmlspecialchars($pedido['bairro']) ?></div>
                <div class="list-group-item">
                    <?= htmlspecialchars($pedido['nome_cidade']) ?>/<?= htmlspecialchars($pedido['sigla_estado']) ?>
                </div>
                <div class="list-group-item">CEP: <?= htmlspecialchars($pedido['cep']) ?></div>
            </address>
        <?php else: ?>
            <div class="alert alert-info">Retirada no local</div>
        <?php endif; ?>
    </div>
</div>

<?php
error_log("Número de itens renderizados: $itemCount");
$output = ob_get_clean();
echo $output;
?>