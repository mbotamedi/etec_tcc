<?php
include("../../includes/conexao.php");

if (!$conexao) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erro na conexão com o banco de dados']);
    exit;
}

if (isset($_GET['codigo_estado'])) {
    $codigo_estado = mysqli_real_escape_string($conexao, $_GET['codigo_estado']);
    
    $query_cidades = "SELECT codigo_cidade, nome_cidade 
                     FROM tb_cidades 
                     WHERE codigo_estado = '$codigo_estado' 
                     ORDER BY nome_cidade";
    $result_cidades = mysqli_query($conexao, $query_cidades);
    
    if (!$result_cidades) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erro na consulta: ' . mysqli_error($conexao)]);
        exit;
    }
    
    $cidades = [];
    while ($cidade = mysqli_fetch_assoc($result_cidades)) {
        $cidades[] = [
            'codigo_cidade' => $cidade['codigo_cidade'],
            'nome_cidade' => $cidade['nome_cidade']
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($cidades);
    exit;
}
?>