<?php
// Inclui o arquivo de conexão com o banco de dados
include('../includes/conexao.php');

// Verifica se está na página de detalhes
$mostrar_detalhes = isset($_GET['pg']) && $_GET['pg'] === 'detalhes' && isset($_GET['id_pedido']);

if (!$mostrar_detalhes) {
    // Consulta para todos os pedidos do sistema com detalhes agregados por pedido
    $query = "
        SELECT 
            p.id AS id_pedido,
            c.nome AS cliente,
            p.emissao,
            p.valor_total,
            p.tipo_entrega,
            e.endereco,
            e.numero,
            e.bairro,
            e.cep,
            cid.nome_cidade,
            cid.sigla_estado,
            SUM(pi.qtd) AS quantidade_total
        FROM tb_pedidos p
        LEFT JOIN tb_clientes c ON p.id_cliente = c.id
        LEFT JOIN tb_cliente_endereco e ON p.id_endereco = e.id
        LEFT JOIN tb_cidades cid ON e.id_cidade = cid.codigo_cidade
        LEFT JOIN tb_pedidos_itens pi ON p.id = pi.id_pedidos
        GROUP BY p.id, c.nome, p.emissao, p.valor_total, p.tipo_entrega, e.endereco, e.numero, e.bairro, e.cep, cid.nome_cidade, cid.sigla_estado
        ORDER BY p.emissao DESC
    ";
    $resultado = mysqli_query($conexao, $query);

    // Verifica se a consulta foi bem-sucedida
    if (!$resultado) {
        $erro = "Erro na consulta: " . mysqli_error($conexao);
    }
} else {
    // Lógica para exibir detalhes do pedido
    $id_pedido = mysqli_real_escape_string($conexao, $_GET['id_pedido']);

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
        $erro = "Pedido não encontrado.";
    } else {
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
            $erro = "Erro na consulta dos itens: " . mysqli_error($conexao);
        } else {
            $itens = [];
            while ($row = mysqli_fetch_assoc($resultado_itens)) {
                $itens[] = $row;
            }
        }
    }
}
?>

<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid py-4">
        <!--begin::Row-->
        <div class="row">
            <div class="col-12">
                <!--begin::Card-->
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0"><?php echo $mostrar_detalhes ? 'Detalhes do Pedido' : 'Lista de Pedidos'; ?></h3>
                    </div>
                    <!--begin::Card Body-->
                    <div class="card-body p-4">
                        <?php if (isset($erro)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                        <?php else: ?>
                            <?php if ($mostrar_detalhes): ?>
                                <!-- Exibição dos detalhes do pedido -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5>Informações do Pedido</h5>
                                        <ul class="list-group mb-4">
                                            <li class="list-group-item">
                                                <strong>Nº Pedido:</strong> #<?php echo str_pad($pedido['id'], 6, '0', STR_PAD_LEFT); ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Cliente:</strong> <?php echo htmlspecialchars($pedido['cliente']); ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['emissao'])); ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Valor Total:</strong> R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Forma de Entrega:</strong> <?php echo ucfirst($pedido['tipo_entrega']); ?>
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
                                                    <?php foreach ($itens as $item): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <?php if (!empty($item['imagem1'])): ?>
                                                                        <img src="<?php echo "../../" . $item['imagem1']; ?>" alt="<?php echo htmlspecialchars($item['descricao']); ?>" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.style.display='none';">
                                                                    <?php else: ?>
                                                                        <span>Imagem não disponível</span>
                                                                    <?php endif; ?>
                                                                    <span><?php echo htmlspecialchars($item['descricao']); ?></span>
                                                                </div>
                                                            </td>
                                                            <td><?php echo $item['qtd']; ?></td>
                                                            <td>R$ <?php echo number_format($item['valor_untiario'], 2, ',', '.'); ?></td>
                                                            <td>R$ <?php echo number_format($item['qtd'] * $item['valor_untiario'], 2, ',', '.'); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                        <td><strong>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></strong></td>
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
                                                    <?php echo htmlspecialchars($pedido['endereco']); ?>, <?php echo htmlspecialchars($pedido['numero']); ?>
                                                    <?php echo !empty($pedido['complemento']) ? ' - ' . htmlspecialchars($pedido['complemento']) : ''; ?>
                                                </div>
                                                <div class="list-group-item"><?php echo htmlspecialchars($pedido['bairro']); ?></div>
                                                <div class="list-group-item">
                                                    <?php echo htmlspecialchars($pedido['nome_cidade']); ?>/<?php echo htmlspecialchars($pedido['sigla_estado']); ?>
                                                </div>
                                                <div class="list-group-item">CEP: <?php echo htmlspecialchars($pedido['cep']); ?></div>
                                            </address>
                                        <?php else: ?>
                                            <div class="alert alert-info">Retirada no local</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a href="?pg=lista" class="btn btn-primary mt-3">Voltar para Lista</a>
                            <?php else: ?>
                                <!-- Exibição da lista de pedidos -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered align-middle">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">ID Pedido</th>
                                                <th class="text-center">Cliente</th>
                                                <th class="text-center">Endereço</th>
                                                <th class="text-center">Quantidade Total</th>
                                                <th class="text-center">Data Emissão</th>
                                                <th class="text-center">Valor Total</th>
                                                <th class="text-center">Tipo Entrega</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($resultado) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo htmlspecialchars($row['id_pedido']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['cliente'] ?? 'Cliente não informado'); ?></td>
                                                        <td>
                                                            <?php
                                                            if ($row['tipo_entrega'] === 'entrega' && $row['endereco']) {
                                                                echo htmlspecialchars(
                                                                    $row['endereco'] . ', ' . 
                                                                    $row['numero'] . ', ' . 
                                                                    $row['bairro'] . ', ' . 
                                                                    $row['nome_cidade'] . ' - ' . 
                                                                    $row['sigla_estado'] . ', CEP: ' . 
                                                                    $row['cep']
                                                                );
                                                            } else {
                                                                echo 'Retirada no local';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?php echo htmlspecialchars($row['quantidade_total'] ?? 0); ?></td>
                                                        <td class="text-center"><?php echo date('d/m/Y', strtotime($row['emissao'])); ?></td>
                                                        <td class="text-center">R$ <?php echo number_format($row['valor_total'], 2, ',', '.'); ?></td>
                                                        <td class="text-center"><?php echo htmlspecialchars($row['tipo_entrega'] === 'entrega' ? 'Entrega' : 'Retirada'); ?></td>
                                                        <!-- Dentro do loop da tabela em pedidos_admin.php -->
                                                        <td class="text-center">
                                                            <a href="../carrinho/pedidos/detalhes_pedidos.php?id=<?php echo htmlspecialchars($row['id_pedido']); ?>&admin=1" class="btn btn-info btn-sm">
                                                                <i class="bi bi-eye"></i> Detalhes
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">Nenhum pedido encontrado.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <!--end::Card Body-->
                </div>
                <!--end::Card-->
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>

<?php
// Fecha a conexão
mysqli_close($conexao);
?>