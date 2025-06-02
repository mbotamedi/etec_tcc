<?php
include('../php/config.php');
include('../includes/consulta_pedido_admin.php');
?>
<!-- Exibição da lista de pedidos -->
<form method="post" action="" style="margin-bottom: 20px;">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome">

    <label for="data_inicio">Data Início:</label>
    <input type="date" name="data_inicio" id="data_inicio">

    <label for="data_fim">Data Fim:</label>
    <input type="date" name="data_fim" id="data_fim">

    <button type="submit">Filtrar</button>
</form>

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
                        <td><?php echo htmlspecialchars($row['cliente'] ?? "PDV"); ?></td>
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
                        <td class="text-center">
                            <a href="?pg=Detalhes&id=<?php echo $row['id_pedido']; ?>" class="btn btn-info btn-sm">
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