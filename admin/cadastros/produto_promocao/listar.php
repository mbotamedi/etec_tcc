<?php
include("../../../includes/conexao.php");

// Verifica se o parâmetro consulta foi enviado
$consulta = isset($_POST['consulta']) ? trim($_POST['consulta']) : null;


if ($consulta == null) {
    $listar = mysqli_query($conexao, "SELECT 
                        pro.id, pro.id_produto,pr.descricao,pro.desconto
                    FROM 
                        tb_produtos pr
                    LEFT JOIN 
                        tb_produto_pro pro ON pr.id = pro.id_produto  where pro.desconto <> 'null' order by descricao");
} else {
    $listar = mysqli_query($conexao, "SELECT 
                        pro.id, pr.descricao,pro.desconto, pro.id_produto
                    FROM 
                        tb_produtos pr
                    LEFT JOIN 
                        tb_produto_pro pro ON pr.id = pro.id_produto  WHERE pro.desconto <> 'null' AND pr.descricao LIKE UPPER ('%$consulta%') order by descricao");
}

echo '<table class="table table-striped">';
echo '<thead>
            <tr>
                <th>ID</th>
                <th>Codigo_Produto</th>
                <th>Descrição</th>
                <th>Desconto</th>
                <th>Ações</th></thead><tbody>';

// Verifica se a consulta foi bem-sucedida
while ($lista = mysqli_fetch_assoc($listar)) {

    $desconto_formatado = ($lista["desconto"] * 100) . '%';
    echo '<tr class="align-middle">
                    <td>' . $lista["id"] . '</td>
                    <td>' . $lista["id_produto"] . '</td>
                    <td>' . $lista["descricao"] . '</td>
                    <td>' . $desconto_formatado . '</td>
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
        var cod = $(this).closest("tr").find("td").eq(1).text();
        var descricao = $(this).closest("tr").find("td").eq(2).text();
        var desconto = $(this).closest("tr").find("td").eq(3).text();



        //Carrego a descricao no Campo txtcategoria 

        $("#txtprodutos").val(descricao);
        $("#txtdesconto").val(desconto);
        $("#txtcod").val(cod);
        $("#id").val(id);

        $.ajax({
            url: 'http://localhost/etec_tcc/assets/fotos/' + cod + '.png',
            type: 'HEAD',
            success: function() {
                //arquivo existe
                $('#produto_foto').attr("src", '../assets/fotos/' + cod + '.png');
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
                $.post("cadastros/produto_promocao/apagar.php", {
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