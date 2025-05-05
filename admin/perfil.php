<?php 
 
 $id = $_SESSION['usuario']['nome'];
//echo $id;
include('../includes/conexao.php'); 

$query = "Select * from tb_usuarios where nome = '$id'";

$resultado = mysqli_query($conexao,$query);

$dados = mysqli_fetch_assoc($resultado);

//print_r($dados);

?>


<div class="px-3 py-2">
    <?php if (isset($_SESSION['usuario'])): ?>
    <div class="mb-2">
        <strong>CPF:</strong>
        <span class="float-end"><?= htmlspecialchars($dados['CPF'] ?? 'Não informado') ?></span>
    </div>
    <div class="mb-2">
        <strong>E-mail:</strong>
        <span class="float-end"><?= htmlspecialchars($dados['email'] ?? 'Não informado') ?></span>
    </div>
    <div class="mb-2">
        <strong>Celular:</strong>
        <span class="float-end"><?= htmlspecialchars($dados['Celular'] ?? 'Não informado') ?></span>
    </div>
    <?php endif; ?>
</div>

 
        
             

              
           