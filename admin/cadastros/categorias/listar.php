<?php   
    include("../../../includes/conexao.php");
    $listar = mysqli_query($conexao, 
    "SELECT * FROM tb_categorias order by descricao");

    echo '<table class="table table-striped">';
    echo '<thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Ações</th></thead><tbody>';

    while ($lista = mysqli_fetch_assoc($listar)){
        echo '<tr class="align-middle">
                <td>'.$lista["id"].'</td>
                <td>'.$lista["descricao"].'</td>
                <td><i class="bi bi-pencil-square altera"></i> |
                    <i class="bi bi-trash deleta"></i></td>
            </tr>';
    }

    echo '</tbody>
        </table>';
?>


<script>
    $(".altera").click(function(){ 
        var id        = $(this).closest("tr").find("td").eq(0).text();
        var descricao = $(this).closest("tr").find("td").eq(1).text();

        //Carrego a descricao no Campo txtcategoria
        $("#txtcategoria").val(descricao);
        $("#id")          .val(id);

    });


    $(".deleta").click(function(){ 
        var id = $(this).closest("tr").find("td").eq(0).text();

        modalPergunta("Confirma Exclusão", "Deseja realmente excluir a categoria?").then((resposta) => {
        if (resposta) {
            $.post("cadastros/categorias/apagar.php",{id : id},function(resultado){   
                mostraDialogo(resultado, 'info', 3000);
                $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
                $("#listar").load("cadastros/categorias/listar.php");
            })           
        } 
    });

    })
</script>