<?php
@session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'usuario') {
    header("Location: ../php/login.php");
    exit();
}
?>