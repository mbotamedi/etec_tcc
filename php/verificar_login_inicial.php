<?php
session_start();

// Verifica se o usuário está logado
$usuario_logado = isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);
$nome_usuario = '';

// Se estiver logado, obtém o nome do usuário
if ($usuario_logado) {
    // Verifica se $_SESSION['usuario'] é um array ou uma string
    if (is_array($_SESSION['usuario'])) {
        // Se for um array, tenta obter o nome do usuário
        if (isset($_SESSION['usuario']['nome'])) {
            $nome_usuario = $_SESSION['usuario']['nome'];
        } elseif (isset($_SESSION['usuario']['usuario'])) {
            $nome_usuario = $_SESSION['usuario']['usuario'];
        } else {
            // Se não encontrar o nome, usa o primeiro valor do array
            $nome_usuario = reset($_SESSION['usuario']);
        }
    } else {
        // Se for uma string, usa diretamente
        $nome_usuario = $_SESSION['usuario'];
    }
}

// Define variáveis globais para uso em todas as páginas
$GLOBALS['usuario_logado'] = $usuario_logado;
$GLOBALS['nome_usuario'] = $nome_usuario;
