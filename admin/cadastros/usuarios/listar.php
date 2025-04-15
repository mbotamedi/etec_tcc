<?php
include("../../../includes/conexao.php");

// Verifica se o parâmetro consulta foi enviado
$consulta = isset($_POST['consulta']) ? trim($_POST['consulta']) : null;

echo ($consulta);
if ($consulta == null) {
    $listar = mysqli_query($conexao, "SELECT us.id, us.nome, us.CPF, us.email, us.senha, n.cargo, us.celular FROM tb_usuarios as us Inner Join tb_nivel_usuario as n WHERE us.id_cargo = n.id order by upper(us.nome)");
} else {
    $listar = mysqli_query($conexao, "SELECT us.id, us.nome, us.CPF, us.email, us.senha, n.cargo, us.celular FROM tb_usuarios as us Inner Join  tb_nivel_usuario as n WHERE us.id_cargo = n.id UPPER(us.nome) LIKE UPPER('%$consulta%')");
}

echo '<table class="table table-striped">';
echo '<thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Cargo</th>
                <th>Celular</th>
                <th>Ações</th></thead><tbody>';

// Verifica se a consulta foi bem-sucedida
while ($lista = mysqli_fetch_assoc($listar)) {
    echo '<tr class="align-middle">
                    <td>' . $lista["id"] . '</td>
                    <td>' . $lista["nome"] . '</td>
                    <td>' . $lista["CPF"] . '</td>
                    <td>' . $lista["email"] . '</td>
                    <td>' . $lista["cargo"] . '</td>
                    <td>' . $lista["celular"] . '</td>
                    <td style="display:none">' . $lista["senha"] . '</td>
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
        var nome = $(this).closest("tr").find("td").eq(1).text();
        var cpf = $(this).closest("tr").find("td").eq(2).text();
        var email = $(this).closest("tr").find("td").eq(3).text();
        var cargo = $(this).closest("tr").find("td").eq(4).text();
        var celular = $(this).closest("tr").find("td").eq(5).text();
        var senha = $(this).closest("tr").find("td").eq(6).text();
        //Carrego a descricao no Campo txtcategoria 
        $("#txtnome").val(nome);
        $("#txtcpf").val(cpf);
        $("#txtemail").val(email);
        $("#txtsenha").val(senha);
        $("#txtcargo").val(cargo);
        $("#txtcelular").val(celular);
        $("#id").val(id);

    });


    $(".deleta").click(function() {
        var id = $(this).closest("tr").find("td").eq(0).text();

        modalPergunta("Confirma Exclusão", "Deseja realmente excluir esse produto?").then((resposta) => {
            if (resposta) {
                $.post("cadastros/usuarios/apagar.php", {
                    id: id
                }, function(resultado) {
                    mostraDialogo(resultado, 'info', 3000);
                    $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
                    $("#listar").load("cadastros/usuarios/listar.php");
                })
            }
        });

    })
</script>