<?php
include("conexao.php");

// Pega apenas o primeiro usuário (adaptação mínima do seu código)
$resultado = mysqli_query($conexao, "SELECT data_registro FROM tb_usuarios ");

if ($resultado && $usuario = mysqli_fetch_assoc($resultado)) {
    $dataRegistro = new DateTime($usuario['data_registro']);
    $diferenca = (new DateTime())->diff($dataRegistro);
    
    // Formatação super simples
    if ($diferenca->y > 0) {
        echo "Usuário deste {$diferenca->y} ano".($diferenca->y > 1 ? 's' : '');
    } elseif ($diferenca->m > 0) {
        echo "Usuário deste  {$diferenca->m} mes".($diferenca->m > 1 ? 'es' : '');
    } else {
        echo "Usuário deste  {$diferenca->d} dia".($diferenca->d > 1 ? 's' : '');
    }
} else {
    echo "Novo Usuário";
}
?>