<?php
        // Inclui o arquivo de conexão
        include("conexao.php");

        // Executa a consulta usando MySQLi
        $query = "SELECT pr.id,pr.descricao ,pr.valor - (pr.valor * pro_pro.desconto) as valor, pr.estoque FROM tb_produto_pro pro_pro left join tb_produtos pr on pro_pro.id_produto = pr.id limit 3";
        $resultado = mysqli_query($conexao, $query);

        // Verifica se a consulta foi bem-sucedida
        if (!$resultado) {
            die("Erro na consulta: " . mysqli_error($conexao));
        }

        // Busca todos os produtos
        $produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
?>

<?php
        // Inclui o arquivo de conexão
        include("conexao.php");

        // Executa a consulta usando MySQLi
        $query = "SELECT * FROM tb_usuarios";
        $resultado = mysqli_query($conexao, $query);

        // Verifica se a consulta foi bem-sucedida
        if (!$resultado) {
            die("Erro na consulta: " . mysqli_error($conexao));
        }

        // Busca todos os produtos
        $usuario = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        if ($usuario === true){
            return("Cliente Logado");
        

        }
?>
        
        