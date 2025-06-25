<?php


@session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

// Incluindo os arquivos necessários.
require_once '../includes/conexao.php';
require_once 'config.php';
require_once 'api_helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['payment_method'])) {
    header('Location: index.php');
    exit;
}

// Limpa a sessão para evitar que o mesmo pedido seja pago duas vezes
unset($_SESSION['pagamento_id_pedido']);

// --- COLETA E LIMPEZA DOS DADOS ---
$payment_method = $_POST['payment_method'];
$id_pedido = (int)$_POST['id_pedido'];
$valor_total_centavos = (int) ((float)$_POST['valor_total'] * 100);
$reference_id = 'PEDIDO_' . $id_pedido . '_' . time();

// ... (todo o resto da preparação dos dados continua igual) ...
$customer_data = [
    'name'   => htmlspecialchars($_POST['customer_name']),
    'email'  => filter_var($_POST['customer_email'], FILTER_SANITIZE_EMAIL),
    'tax_id' => preg_replace('/[^0-9]/', '', $_POST['customer_tax_id']),
];
$item_data = [
    'name'        => 'Pedido #' . $id_pedido,
    'quantity'    => 1,
    'unit_amount' => $valor_total_centavos,
];
$request_data = [
    'reference_id'      => $reference_id,
    'customer'          => $customer_data,
    'items'             => [$item_data],
    'notification_urls' => [PAGSEGURO_NOTIFICATION_URL],
];

if ($payment_method === 'pix') {
    $request_data['qr_codes'] = [[
        'amount' => ['value' => $valor_total_centavos],
        'expiration_date' => date('Y-m-d\TH:i:s-03:00', strtotime('+1 hour')),
    ]];
} elseif ($payment_method === 'credit_card') {
    $card_data = [
        'number' => preg_replace('/[^0-9]/', '', $_POST['card_number']),
        'exp_month' => (int)$_POST['card_exp_month'],
        'exp_year' => (int)$_POST['card_exp_year'],
        'security_code' => $_POST['card_security_code'],
        'holder' => ['name' => htmlspecialchars($_POST['card_holder'])],
    ];
    $request_data['charges'] = [[
        'reference_id' => $reference_id,
        'description' => 'Pagamento do ' . $reference_id,
        'amount' => ['value' => $item_data['unit_amount'], 'currency' => 'BRL'],
        'payment_method' => ['type' => 'CREDIT_CARD', 'installments' => 1, 'capture' => true, 'card' => $card_data],
    ]];
}

// --- BLOCO 1 E 2 (sem alterações) ---
$sql_insert_payment = "INSERT INTO tb_payments (id_pedidos, reference_id, status) VALUES (?, ?, 'PENDING') ON DUPLICATE KEY UPDATE reference_id = ?, status = 'PENDING', updated_at = NOW()";
$stmt1 = mysqli_prepare($conexao, $sql_insert_payment);
mysqli_stmt_bind_param($stmt1, "iss", $id_pedido, $reference_id, $reference_id);
mysqli_stmt_execute($stmt1);
mysqli_stmt_close($stmt1);

$api_response = callPagSeguroAPI($request_data);

$json_response = json_encode($api_response);
$sql_update_response = "UPDATE tb_payments SET response_data = ? WHERE reference_id = ?";
$stmt2 = mysqli_prepare($conexao, $sql_update_response);
mysqli_stmt_bind_param($stmt2, "ss", $json_response, $reference_id);
mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);


// ########## ALTERAÇÃO 1: REDIRECIONAMENTO CONDICIONAL ##########
// Agora, só redireciona se o pagamento for com Cartão de Crédito.
if ($payment_method === 'credit_card') {
    header('Location: ../carrinho/pedidos/confirmacao_pedido.php?id_pedido=' . $id_pedido);
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Pagamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 550px; }
        .card { border-radius: 0.75rem; }
    </style>
</head>
<?php include("../php/navbar_pag.php"); ?>
<body class="py-5">
    <div class="container" style="padding: 20px;">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5 text-center">

            <?php if (isset($api_response['error_messages'])): ?>
                <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                <h2 class="h4 fw-bold mt-3">Falha no Pagamento</h2>
                <p class="text-muted">A API retornou um erro. Por favor, verifique os dados e tente novamente.</p>
                <?php elseif ($payment_method === 'pix' && isset($api_response['qr_codes'][0])): ?>
                <i class="bi bi-qr-code text-dark" style="font-size: 4rem;"></i>
                <h2 class="h4 fw-bold mt-3">Finalize com PIX</h2>
                <p class="text-muted">Seu pedido <strong><?php echo htmlspecialchars($reference_id); ?></strong> foi criado. Escaneie o QR Code abaixo para pagar.</p>
                <img src="<?php echo htmlspecialchars($api_response['qr_codes'][0]['links'][0]['href']); ?>" class="img-fluid rounded my-3" alt="QR Code PIX" style="max-width: 220px;">
                <div class="text-start">
                    <label for="pix-code" class="form-label fw-semibold">PIX Copia e Cola:</label>
                    <div class="input-group">
                        <input type="text" id="pix-code" class="form-control" value="<?php echo htmlspecialchars($api_response['qr_codes'][0]['text']); ?>" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard()" id="copy-btn"><i class="bi bi-clipboard"></i></button>
                    </div>
                </div>
                <div class="d-grid mt-4">
                     <a href="../carrinho/pedidos/confirmacao_pedido.php?id_pedido=<?php echo $id_pedido; ?>" class="btn btn-primary">Já Paguei, Verificar Status</a>
                </div>
            <?php else: ?>
                <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                <h2 class="h4 fw-bold mt-3">Resposta Inesperada</h2>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <script>
        function copyToClipboard() {
            const input = document.getElementById('pix-code');
            const button = document.getElementById('copy-btn');
            navigator.clipboard.writeText(input.value).then(() => {
                button.innerHTML = '<i class="bi bi-check-lg"></i>';
                setTimeout(() => {
                    button.innerHTML = '<i class="bi bi-clipboard"></i>';
                }, 2000);
            }).catch(err => {
                console.error('Falha ao copiar o texto: ', err);
            });
        }
    </script>
    <?php include("../php/footer_pag.php"); ?>
</body>
</html>