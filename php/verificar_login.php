<?php
session_start();

// Verifica se o usuário está logado
$response = array(
    'logado' => false,
    'nome' => null
);

if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nome'])) {
    $response['logado'] = true;
    $response['nome'] = $_SESSION['usuario']['nome'];
}



// Retorna a resposta em formato JSON
echo json_encode($response);
