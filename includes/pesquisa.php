<?php
   // Inclui o arquivo de conexão com o banco de dados
   include("conexao.php");
   
   // Verifica se o formulário foi enviado e se o campo "consulta" está presente
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["consulta"])) {
       $consulta = $_POST["consulta"]; // Recebe o valor do campo "consulta"
       
    } else {
    $consulta = null; // Define como null se não houver consulta
    }

    // Executa a consulta usando MySQLi
    if ($consulta == null){
        $pesquisa = mysqli_query($conexao,"SELECT * FROM tb_produtos order by descricao");

    }else {
        // Se houver consulta, usa UPPER para buscar sem diferenciar maiúsculas e minúsculas
        $pesquisa = mysqli_query($conexao, "SELECT * FROM tb_produtos WHERE descricao LIKE UPPER ('%$consulta%') ");
    }

     // Verifica se a consulta foi bem-sucedida
     if (!$pesquisa) {
        die("Erro na consulta: " . mysqli_error($conexao));
    }

    // Busca todos os produtos
    $produtos = mysqli_fetch_all($pesquisa, MYSQLI_ASSOC);
?>

