<?php
include("../../../includes/conexao.php");

// Verifica se o parâmetro consulta foi enviado
$consulta = isset($_POST['consulta']) ? trim($_POST['consulta']) : null;


if ($consulta == null) {
    $listar = mysqli_query($conexao, "SELECT 
                        it.id, it.id_produto,it.quantidade, it.id_promocao, it.Vl_pro, pr.descricao
                    FROM 
                        tb_produtos pr
                    LEFT JOIN 
                        tb_promocao_itens it ON pr.id = it.id_produto  Where it.id_promocao <> 'null' order by it.id_promocao");
} else {
    $listar = mysqli_query($conexao, "SELECT 
                        it.id, it.id_produto,it.quantidade, it.id_promocao it.Vl_pro, pr.descricao
                    FROM 
                        tb_produtos pr
                    LEFT JOIN 
                        tb_promocao_itens it ON pr.id = it.id_produto  pr.descricao Where it.id_promocao <> 'null' LIKE UPPER ('%$consulta%') order by it.id_promocao");
}

echo '<table class="table table-striped">';
echo '<thead>
            <tr>
                <th>ID</th>
                <th>Codigo_Produto</th>
                <th>Codigo_Promoção</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Ações</th></thead><tbody>';

// Verifica se a consulta foi bem-sucedida
while ($lista = mysqli_fetch_assoc($listar)) {


    echo '<tr class="align-middle">
                    <td>' . $lista["id"] . '</td>
                    <td>' . $lista["id_produto"] . '</td>
                    <td>' . $lista["id_promocao"] . '</td>
                    <td>' . $lista["descricao"] . '</td>
                    <td>' . $lista["quantidade"] . '</td>
                    <td>R$ ' . number_format($lista["Vl_pro"], 2, ',', '.') . '</td>
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
        var cod_produto = $(this).closest("tr").find("td").eq(1).text();
        var cod_promocao = $(this).closest("tr").find("td").eq(2).text();
        var descricao = $(this).closest("tr").find("td").eq(3).text();
        var qtd = $(this).closest("tr").find("td").eq(4).text();
        var valor_formatado = $(this).closest("tr").find("td").eq(5).text();
        var valor = valor_formatado.replace('R$', '').replace(',', '.');


        //Carrego a descricao no Campo txtcategoria 
        $("#txtcod").val(cod_produto);
        $("#txtpro").val(cod_promocao);
        $("#txtqtd").val(qtd);
        $("#txtvl").val(valor);
        $("#txtprodutos").val(descricao);
        $("#id").val(id);

        $.ajax({
            url: 'http://localhost/etec_tcc/assets/fotos/' + cod_produto + '.png',
            type: 'HEAD',
            success: function() {
                //arquivo existe
                $('#produto_foto').attr("src", '../assets/fotos/' + cod_produto + '.png');
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
                $.post("cadastros/banner/apagar.php", {
                    id: id
                }, function(resultado) {
                    mostraDialogo(resultado, 'info', 3000);
                    $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
                    $("#listar").load("cadastros/produto_promocao/listar.php");
                })
            }
        });

    })
</script>