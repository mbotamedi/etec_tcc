<?php
@session_start();

// Usa a conexão MySQLi, que já cria a variável $conexao
require_once '../includes/conexao.php';

// Verifica se há um pedido pendente de pagamento na sessão
if (!isset($_SESSION['pagamento_id_pedido'])) {
    // Se não houver, redireciona para a página inicial para evitar acesso direto
    header('Location: ../../index.php');
    exit;
}

$id_pedido = $_SESSION['pagamento_id_pedido'];
$id_cliente = $_SESSION['usuario']['id'];

// --- BLOCO DE CÓDIGO MODIFICADO (DE PDO PARA MYSQLI) ---

// Monta a consulta SQL com placeholders (?) para segurança
$sql = "SELECT p.valor_total, c.nome, c.email, c.cnpj_cpf as cpf 
        FROM tb_pedidos p 
        JOIN tb_clientes c ON p.id_cliente = c.id 
        WHERE p.id = ? AND p.id_cliente = ?";

// Prepara a declaração
$stmt = mysqli_prepare($conexao, $sql);

if ($stmt) {
    // Vincula os parâmetros ($id_pedido e $id_cliente) à declaração
    // "ii" significa que os dois parâmetros são inteiros (integer)
    mysqli_stmt_bind_param($stmt, "ii", $id_pedido, $id_cliente);

    // Executa a consulta
    mysqli_stmt_execute($stmt);

    // Obtém o resultado
    $result = mysqli_stmt_get_result($stmt);

    // Busca os dados como um array associativo
    $order_details = mysqli_fetch_assoc($result);

    // Fecha a declaração
    mysqli_stmt_close($stmt);
} else {
    // Encerra o script se houver um erro na preparação da consulta
    die("Erro ao preparar a consulta ao banco de dados: " . mysqli_error($conexao));
}

// --- FIM DO BLOCO MODIFICADO ---


// if (!$order_details) {
//     // Se o pedido não for encontrado ou não pertencer ao usuário, encerra
//     unset($_SESSION['pagamento_id_pedido']);
//     die("Erro: Pedido não encontrado ou inválido para este usuário.");
// }

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Seguro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css//mediaQuery.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
        }

        .card {
            border-radius: 0.75rem;
        }

        .form-check-label {
            width: 100%;
        }

        .valor-total {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .form-control[readonly] {
            background-color: #e9ecef;
        }

        .py-5 {
            padding-top: 0px !important;
            padding-bottom: 3px !important;
        }

        .menu li a {
            font-size: 14px;
        }

        .botaoVoltar {
            text-decoration: none;
            color: red;
            font-weight: 400;
            border: 1px solid red;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<?php //include("../php/navbar.php"); 
?>

<body class="bg-light">
    <div class="container" style="padding: 20px; margin-top: 20px;">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="container-voltar">
                    <div class="buttonVoltar">
                        <a href="../carrinho/pedidos/finalizar_pedido.php" class="botaoVoltar">
                            ← Voltar ao Carrinho
                        </a>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-shield-lock-fill text-primary" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.52 1.52 0 0 0-1.042.87C.637 3.18.5 4.22.5 5.333v5.133a6.2 6.2 0 0 0 1.518 4.223c.996.996 2.296 1.503 3.482 1.756C6.157 16.5 7.31 16.5 8 16.5s1.843 0 2.928-.321c1.11-.302 2.229-.655 2.887-.87a1.52 1.52 0 0 0 1.042-.87c.637-1.18.75-2.22.75-3.333V5.333c0-1.113-.137-2.153-.75-3.333a1.52 1.52 0 0 0-1.042-.87c-.658-.215-1.777-.57-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915v.345a1.5 1.5 0 1 1-1 0v-.345A1.5 1.5 0 0 1 8 5" />
                    </svg>
                    <h1 class="h3 fw-bold mt-3 mb-2">Finalizar Pagamento</h1>
                    <p class="text-muted">Pedido #<?php echo htmlspecialchars($id_pedido); ?></p>
                    <p class="valor-total">Total: R$ <?php echo number_format($order_details['valor_total'], 2, ',', '.'); ?></p>
                </div>

                <form action="pagar.php" method="POST" id="payment-form">
                    <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($id_pedido); ?>">
                    <input type="hidden" name="valor_total" value="<?php echo htmlspecialchars($order_details['valor_total']); ?>">

                    <h2 class="h5 fw-semibold mb-3">Seus Dados</h2>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($order_details['nome']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($order_details['email']); ?>" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="customer_tax_id" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="customer_tax_id" name="customer_tax_id" value="<?php echo htmlspecialchars($order_details['cpf']); ?>" readonly>
                    </div>

                    <h2 class="h5 fw-semibold mb-3">Forma de Pagamento</h2>
                    <div class="row gx-2">
                        <div class="col">
                            <input type="radio" class="btn-check" name="payment_method" id="pix" value="pix" autocomplete="off" checked>
                            <label class="btn btn-outline-primary w-100" for="pix">PIX</label>
                        </div>
                        <div class="col">
                            <input type="radio" class="btn-check" name="payment_method" id="credit_card" value="credit_card" autocomplete="off">
                            <label class="btn btn-outline-primary w-100" for="credit_card">Cartão de Crédito</label>
                        </div>
                    </div>

                    <div id="credit-card-fields" class="mt-4" style="display: none;">
                        <h2 class="h5 fw-semibold mb-3">Dados do Cartão</h2>
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Número do Cartão</label>
                            <input type="text" class="form-control" id="card_number" name="card_number" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="mb-3">
                            <label for="card_holder" class="form-label">Nome no Cartão</label>
                            <input type="text" class="form-control" id="card_holder" name="card_holder">
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="card_exp_month" class="form-label">Mês</label>
                                <input type="number" class="form-control" id="card_exp_month" name="card_exp_month" placeholder="MM" min="1" max="12">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="card_exp_year" class="form-label">Ano</label>
                                <input type="number" class="form-control" id="card_exp_year" name="card_exp_year" placeholder="AAAA" min="<?php echo date('Y'); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="card_security_code" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="card_security_code" name="card_security_code" placeholder="123">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Realizar Pagamento de R$ <?php echo number_format($order_details['valor_total'], 2, ',', '.'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
            const creditCardFields = document.getElementById('credit-card-fields');
            const creditCardRadio = document.getElementById('credit_card');

            function toggleCreditCardFields() {
                const isCreditCard = creditCardRadio.checked;
                creditCardFields.style.display = isCreditCard ? 'block' : 'none';
                creditCardFields.querySelectorAll('input').forEach(input => {
                    input.required = isCreditCard;
                });
            }

            paymentMethodRadios.forEach(radio => {
                radio.addEventListener('change', toggleCreditCardFields);
            });

            toggleCreditCardFields();
        });
    </script>
    <!-- <?php include("../php/footer_pag.php"); ?> -->
</body>

</html>