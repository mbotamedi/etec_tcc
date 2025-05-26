<?php
include '../includes/conexao.php';

$sql = "SELECT 
          c.id_caixa,
          c.data_abertura,
          c.data_fechamento,
          c.valor_abertura,
          c.valor_fechamento,
          c.observacoes,
          c.diferenca,
          SUM(CASE WHEN m.tipo = 'ENTRADA' THEN m.valor ELSE 0 END) AS total_entradas,
          SUM(CASE WHEN m.tipo = 'SAIDA' THEN m.valor ELSE 0 END) AS total_saidas
        FROM tb_caixa c
        LEFT JOIN tb_movimentacoes_caixa m ON m.id_caixa = c.id_caixa
        GROUP BY c.id_caixa
        ORDER BY c.id_caixa DESC";

$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Relatório de Caixa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-5 bg-light">
  <h2 class="mb-4">Relatório de Caixa</h2>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Abertura</th>
        <th>Valor Abertura</th>
        <th>Entradas</th>
        <th>Saídas</th>
        <th>Fechamento</th>
        <th>Valor Fechamento</th>
        <th>Saldo Final</th>
        <th>Diferença</th>
        <th>Observações</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): 
        $saldo = $row['valor_abertura'] + $row['total_entradas'] - $row['total_saidas'];
      ?>
        <tr>
          <td><?= $row['id_caixa'] ?></td>
          <td><?= $row['data_abertura'] ?></td>
          <td>R$ <?= number_format($row['valor_abertura'], 2, ',', '.') ?></td>
          <td>R$ <?= number_format($row['total_entradas'], 2, ',', '.') ?></td>
          <td>R$ <?= number_format($row['total_saidas'], 2, ',', '.') ?></td>
          <td><?= $row['data_fechamento'] ?? '-' ?></td>
          <td>R$ <?= $row['valor_fechamento'] !== null ? number_format($row['valor_fechamento'], 2, ',', '.') : '-' ?></td>
          <td>R$ <?= number_format($saldo, 2, ',', '.') ?></td>
          <td>R$ <?= $row['diferenca'] !== null ? number_format($row['diferenca'], 2, ',', '.') : '-' ?></td>
          <td><?= $row['observacoes'] ?? '-' ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>

<?php $conexao->close(); ?>