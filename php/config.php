<?php
// Verifica se a sessão já foi iniciada antes de chamar session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'usuario') {
    header("Location: ../php/login.php");
    exit();
}
?>