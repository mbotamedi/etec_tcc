<?php
@session_start();

// Verifica se o usuário está logado
$response = array(
    'logado' => false,
    'nome' => null
);

// Verifica se a sessão existe e tem os dados necessários
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nome'])) {
    $response['logado'] = true;
    $response['nome'] = $_SESSION['usuario']['nome'];
    $response['tipo'] = $_SESSION['usuario']['tipo'];
    $nome = $_SESSION['usuario']['nome'];
} else {
    $nome = '';
}

// Retorna a resposta em formato JSON
echo json_encode($response);
