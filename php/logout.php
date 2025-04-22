<?php
session_start();

// Destrói a sessão
session_destroy();

// Redireciona para a página inicial
header('Location: index.php');
exit;

