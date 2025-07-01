<?php
include('../php/config.php');
include('../includes/conexao.php');

$nome = isset($_GET['nome']) ? mysqli_real_escape_string($conexao, trim($_GET['nome'])) : '';
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

if (empty($nome) && empty($data_inicio) && empty($data_fim)) {
    $mensagens = "select *from tb_contato";
} else {
    $mensagens = "select *from tb_contato where nome like '%".$nome."%' and created_at >= '$data_inicio' and created_at <='$data_fim' order by created_at desc";
}

$resultado = mysqli_query($conexao, $mensagens);

?>
<!-- Exibição da lista de pedidos -->
<form method="get" action="" style="margin-bottom: 20px;">
    <input type="hidden" name="pg" value="Mensagens">

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
                <th class="text-center">ID Mensagens</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">email</th>
                <th class="text-center">Mensagem</th>
                <th class="text-center">Data Recebimento</th>
                <!--<th class="text-center">Ações</th>--->
                
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['mensagem']); ?></td>
                        <td class="text-center"><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                        
                        <!--<td class="text-center">
                            <a href="?pg=Detalhes&id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Detalhes
                            </a>
                        </td>--->
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