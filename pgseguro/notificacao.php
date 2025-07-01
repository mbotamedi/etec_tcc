<?php


require_once '../includes/conexao.php';
require_once 'config.php';

// Captura o corpo da requisição POST (webhook)
$json_data = file_get_contents('php://input');

// Loga a notificação crua para fins de depuração
file_put_contents('notificacoes.log', $json_data . "\n\n", FILE_APPEND);

$notification = json_decode($json_data, true);

// Verifica se a notificação é válida e contém os dados necessários
if (isset($notification['reference_id']) && isset($notification['charges'][0]['status'])) {
    
    $reference_id = $notification['reference_id'];
    $status = $notification['charges'][0]['status'];
    
    // Inicia a transação com mysqli para garantir a integridade dos dados
    mysqli_begin_transaction($conexao);

    try {
        // 1. Atualiza o status na tabela de pagamentos
        $sql1 = "UPDATE tb_payments SET status = ? WHERE reference_id = ?";
        $stmt1 = mysqli_prepare($conexao, $sql1);
        mysqli_stmt_bind_param($stmt1, "ss", $status, $reference_id);
        if (!mysqli_stmt_execute($stmt1)) {
            throw new Exception("Falha ao atualizar tb_payments: " . mysqli_stmt_error($stmt1));
        }
        mysqli_stmt_close($stmt1);
        
        // 2. Se o pagamento foi aprovado, atualiza a tabela principal de pedidos
        if ($status === 'PAID') {
            $id_pedido = null;

            // Primeiro, busca o id do pedido associado a esta referência
            $sql2 = "SELECT id_pedidos FROM tb_payments WHERE reference_id = ?";
            $stmt2 = mysqli_prepare($conexao, $sql2);
            mysqli_stmt_bind_param($stmt2, "s", $reference_id);
            mysqli_stmt_execute($stmt2);
            $result = mysqli_stmt_get_result($stmt2);
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $id_pedido = $row['id_pedidos'];
            }
            mysqli_stmt_close($stmt2);

            if ($id_pedido) {
                // Agora, atualiza a tabela tb_pedidos
                $sql3 = "UPDATE tb_pedidos SET status_pagamento = 'PAGO' WHERE id = ?";
                $stmt3 = mysqli_prepare($conexao, $sql3);
                mysqli_stmt_bind_param($stmt3, "i", $id_pedido);
                if (!mysqli_stmt_execute($stmt3)) {
                    throw new Exception("Falha ao atualizar tb_pedidos: " . mysqli_stmt_error($stmt3));
                }
                mysqli_stmt_close($stmt3);
            }
        }

        // Se tudo deu certo, confirma as alterações no banco
        mysqli_commit($conexao);

        http_response_code(200);
        echo "Notificação recebida com sucesso.";

    } catch (Exception $e) {
        // Se algo deu errado, desfaz todas as alterações
        mysqli_rollback($conexao);
        
        http_response_code(500); // Erro interno do servidor
        error_log('Webhook Error - DB Update Failed: ' . $e->getMessage());
        echo "Erro ao processar a notificação (banco de dados).";
    }

} else {
    // A notificação não continha os dados esperados
    http_response_code(400); // Bad Request
    echo "Notificação inválida.";
}

?>