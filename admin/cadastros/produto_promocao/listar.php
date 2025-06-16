<?php
include("../../../includes/conexao.php");

// Verifica se o parâmetro consulta foi enviado
$consulta = isset($_POST['consulta']) ? trim($_POST['consulta']) : null;


if ($consulta == null) {
    $listar = mysqli_query($conexao, "SELECT tp.id, tp.descricao, ts.descricao as subcategoria, tp.valor, tp.estoque FROM tb_produtos tp
INNER JOIN tb_subcategorias ts ON ts.id = tp.id_subcategoria order by tp.id");
} else {
    $listar = mysqli_query($conexao, "SELECT tp.id, tp.descricao, ts.descricao as subcategoria, tp.valor, tp.estoque FROM tb_produtos tp
INNER JOIN tb_subcategorias ts ON ts.id = tp.id_subcategoria WHERE tp.descricao LIKE UPPER ('%$consulta%') ");
}

echo '<table class="table table-striped">';
echo '<thead>
            <tr>
                <th>ID</th>
                <th>SubCategoria</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Quantidade</th>
                <th>Ações</th></thead><tbody>';

// Verifica se a consulta foi bem-sucedida
while ($lista = mysqli_fetch_assoc($listar)) {
    echo '<tr class="align-middle">
                    <td>' . $lista["id"] . '</td>
                    <td>' . $lista["subcategoria"] . '</td>
                    <td>' . $lista["descricao"] . '</td>
                    <td>R$ ' . number_format($lista["valor"], 2, ',', '.') . '</td>
                    <td>' . $lista["estoque"] . '</td>
                    <td><i class="bi bi-pencil-square altera"></i> |
                        <i class="bi bi-trash deleta"></i></td>
                </tr>';
}


echo '</tbody>
        </table>';
?>


<script>
    $(".altera").click(function() {
        var id = $(this).closest("tr").find("td").eq(0).text();
        var subcategoria = $(this).closest("tr").find("td").eq(1).text();
        var descricao = $(this).closest("tr").find("td").eq(2).text();
        var valor_formatado = $(this).closest("tr").find("td").eq(3).text();
        var valor = valor_formatado.replace('R$', '').replace(',', '.');
        var estoque = $(this).closest("tr").find("td").eq(4).text();

        //Carrego a descricao no Campo txtcategoria 
        $("#subcategoria").val($('option:contains("' + subcategoria + '")').val());
        $("#txtprodutos").val(descricao);
        $("#txtvalor").val(valor);
        $("#txtquantidade").val(estoque);
        $("#id").val(id);

        $.ajax({
            url: 'http://localhost/etec_tcc/assets/fotos/' + id + '.png',
            type: 'HEAD',
            success: function() {
                //arquivo existe
                $('#produto_foto').attr("src", '../assets/fotos/' + id + '.png');
            },
            error: function() {
                $('#produto_foto').attr("src", '../assets/fotos/semfoto.png');
            }
        });

    });


    $(".deleta").click(function() {
        var id = $(this).closest("tr").find("td").eq(0).text();

        modalPergunta("Confirma Exclusão", "Deseja realmente excluir esse produto?").then((resposta) => {
            if (resposta) {
                $.post("cadastros/produtos/apagar.php", {
                    id: id
                }, function(resultado) {
                    mostraDialogo(resultado, 'info', 3000);
                    $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
                    $("#listar").load("cadastros/produtos/listar.php");
                })
            }
        });

    })
</script>