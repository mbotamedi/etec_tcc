<?php
        // Inclui o arquivo de conexão
        include("conexao.php");

        // Executa a consulta usando MySQLi
        $query = "SELECT * FROM tb_produtos order by descricao limit 3";
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
        
        