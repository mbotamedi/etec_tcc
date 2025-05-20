<?php
include '../includes/conexao.php';
$query = "SELECT * FROM tb_produtos";
$resultado = mysqli_query($conexao, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        /* Adjustments for alignment and spacing */
        .align-items-center {
            align-items: center !important;
        }
        .image-container {
            text-align: center;
        }
        .image-placeholder {
            height: 150px; /* Consistent height for image placeholder */
            /*background-color: #fff;
            border: 1px solid #ddd;*/
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .but_adicionar {
            
            display: block;
            margin-left: 150px;
        } 
    </style>
</head>
<body>
    <form method="POST" action="">
        <div class="container mt-4">
            <!-- Product Selector (Full Width) -->
            <div class="row">
                <div class="col-12">
                    <label for="single-select-field" class="form-label">Produto</label>
                    <select class="form-select" id="single-select-field" name="produto">
                        <option value="" disabled selected>Selecione um produto</option>
                        <?php 
                            if (mysqli_num_rows($resultado) > 0) {
                                while($row = mysqli_fetch_assoc($resultado)) {
                                    echo '<option value="' . $row["id"] . '">' . $row["descricao"] . '</option>';
                                }
                            } else {
                                echo '<option disabled>Nenhum produto encontrado</option>';
                            }
                        ?>
                    </select>
                    <input type="hidden" name="id_produto" id="id_produto" value="">
                </div>
            </div>

            <!-- Image and Inputs Side by Side -->
            <div class="row mt-3 align-items-center">
                <!-- Image -->
                <div class="col-md-4 image-container">
                    <label class="form-label">Imagem</label><br>
                    <div class="image-placeholder">
                        <img id="imagem-produto" src="" alt="Imagem do produto" style="max-width: 100%; max-height: 95px; display: none;">
                    </div>
                </div>

                <!-- Quantidade -->
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">Qtd</label>
                        <input type="number" name="quantidade" id="quantidade" class="form-control" value="1" min="1" required>
                    </div>
                </div>

                <!-- Valor Unitário -->
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Preço</label>
                        <input type="number" name="valor-produto" id="valor-produto" class="form-control" step="0.01" readonly>
                    </div>
                </div>

                <!-- SubTotal -->
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">SubTotal</label>
                        <input type="number" name="subtotal" id="subtotal" class="form-control" step="0.01" readonly>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="row mt-3">
                <div class="col-5 but_adicionar">
                    <button type="submit" name="adicionar" class="btn btn-primary w-100">Adicionar</button>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#single-select-field').select2({
                theme: 'bootstrap-5',
                placeholder: "Selecione um produto",
                allowClear: true
            });

            // Function to calculate subtotal
            function calculateSubtotal() {
                var quantity = parseFloat($('#quantidade').val()) || 1; // Default to 1 if invalid
                var unitPrice = parseFloat($('#valor-produto').val()) || 0; // Default to 0 if invalid
                var subtotal = quantity * unitPrice;
                $('#subtotal').val(subtotal.toFixed(2)); // Set subtotal with 2 decimal places
            }

            // Update product details when a product is selected
            $('#single-select-field').on('change', function() {
                var produtoId = $(this).val();
                $('#id_produto').val(produtoId); // Update hidden field with product ID
                if (produtoId) {
                    $.ajax({
                        url: '/etec_tcc/admin/gerenciamento/get_valor_imagem_produto.php',
                        type: 'GET',
                        data: { id: produtoId },
                        dataType: 'json',
                        success: function(response) {
                            console.log('Resposta AJAX:', response); // For debugging
                            if (response.error) {
                                $('#valor-produto').val('');
                                $('#imagem-produto').hide().attr('src', '');
                                $('#subtotal').val('');
                            } else {
                                $('#valor-produto').val(parseFloat(response.valor).toFixed(2));
                                $('#imagem-produto').attr('src', response.imagem).show();
                                calculateSubtotal(); // Calculate subtotal after setting the unit price
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro AJAX:', status, error); // For debugging
                            $('#valor-produto').val('');
                            $('#imagem-produto').hide().attr('src', '');
                            $('#subtotal').val('');
                        }
                    });
                } else {
                    $('#valor-produto').val('');
                    $('#imagem-produto').hide().attr('src', '');
                    $('#id_produto').val(''); // Clear hidden field
                    $('#subtotal').val('');
                }
            });

            // Recalculate subtotal when quantity changes
            $('#quantidade').on('input', function() {
                calculateSubtotal();
            });
        });
    </script>
</body>
</html>