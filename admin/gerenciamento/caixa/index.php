<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Controle de Caixa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card-disabled {
            opacity: 0.6;
            pointer-events: none;
        }
        .status-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }
        .status-aberto {
            background-color: #28a745;
        }
        .status-fechado {
            background-color: #dc3545;
        }
        .card-header {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Controle de Caixa</h1>
        
        <!-- Status do Caixa -->
        <div class="alert alert-info" id="statusCaixa">
            <strong>Status:</strong> <span id="statusTexto">Verificando...</span>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4" id="cardAbertura">
                    <div class="card-header">
                        Abertura de Caixa
                        <div class="status-indicator status-fechado" id="indicadorAbertura"></div>
                    </div>
                    <div class="card-body">
                        <form id="abrirCaixaForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="valor_abertura" class="form-label">Valor de Abertura (R$)</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="valor_abertura" name="valor_abertura" required>
                                <div class="invalid-feedback">
                                    Por favor, insira um valor de abertura.
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btnAbrirCaixa">Abrir Caixa</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4" id="cardMovimento">
                    <div class="card-header">
                        Registrar Movimento
                        <div class="status-indicator status-fechado" id="indicadorMovimento"></div>
                    </div>
                    <div class="card-body">
                        <form id="registrarMovimentoForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="tipo_entrada" name="tipo" value="ENTRADA" required>
                                    <label class="form-check-label" for="tipo_entrada">Entrada</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="tipo_saida" name="tipo" value="SAIDA">
                                    <label class="form-check-label" for="tipo_saida">Saída</label>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor, selecione um tipo.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="valor" class="form-label">Valor (R$)</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="valor" name="valor" required>
                                <div class="invalid-feedback">
                                    Por favor, insira um valor.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao" required>
                                <div class="invalid-feedback">
                                    Por favor, insira uma descrição.
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" id="btnRegistrarMovimento">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card" id="cardFechamento">
                    <div class="card-header">
                        Fechamento do Caixa
                        <div class="status-indicator status-fechado" id="indicadorFechamento"></div>
                    </div>
                    <div class="card-body">
                        <form id="fecharCaixaForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label>📊 Resumo do Caixa</label>
                                <div id="resumoCaixa">
                                    <p>Valor Abertura: R$ <span id="valor_abertura_resumo">0,00</span></p>
                                    <p>Entradas: R$ <span id="total_entradas">0,00</span></p>
                                    <p>Saídas: R$ <span id="total_saidas">0,00</span></p>
                                    <p><strong>SubTotal: R$ <span id="subTotal">0,00</span></strong></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="valor_fechamento" class="form-label">💰 Valor Real em Caixa (R$)</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="valor_fechamento" name="valor_fechamento" required>
                                <div class="invalid-feedback">
                                    Por favor, insira o valor real em caixa.
                                </div>
                            </div>
                            <div class="mb-3">
                                <p><strong>📈 Diferença: R$ <span id="diferenca">0,00</span></strong></p>
                            </div>
                            <div class="mb-3">
                                <label for="observacoes" class="form-label">📝 Observações</label>
                                <textarea class="form-control" id="observacoes" name="observacoes"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger" id="btnFecharCaixa">Fechar Caixa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let caixaAberto = false;
            let idCaixaAtual = null;

            // Função para verificar o status do caixa
            function verificarStatusCaixa() {
                $.ajax({
                    url: 'gerenciamento/caixa/verificar_status_caixa.php',
                    method: 'GET',
                    dataType: 'json',
                    timeout: 10000, // 10 segundos de timeout
                    success: function(response) {
                        console.log('Status do caixa:', response);
                        
                        if (response.caixa_aberto) {
                            caixaAberto = true;
                            idCaixaAtual = response.id_caixa;
                            configurarCaixaAberto();
                            atualizarResumoCaixa();
                        } else {
                            caixaAberto = false;
                            idCaixaAtual = null;
                            configurarCaixaFechado();
                        }
                        
                        atualizarStatusVisual(response.caixa_aberto);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao verificar status do caixa:', error);
                        $('#statusTexto').text('Erro ao verificar status - ' + error);
                    }
                });
            }

            // Configura interface quando caixa está aberto
            function configurarCaixaAberto() {
                // Desabilita abertura
                $('#cardAbertura').addClass('card-disabled');
                $('#abrirCaixaForm input, #abrirCaixaForm button').prop('disabled', true);
                $('#indicadorAbertura').removeClass('status-aberto').addClass('status-fechado');
                
                // Habilita movimentação
                $('#cardMovimento').removeClass('card-disabled');
                $('#registrarMovimentoForm input, #registrarMovimentoForm button').prop('disabled', false);
                $('#indicadorMovimento').removeClass('status-fechado').addClass('status-aberto');
                
                // Habilita fechamento
                $('#cardFechamento').removeClass('card-disabled');
                $('#fecharCaixaForm input, #fecharCaixaForm textarea, #fecharCaixaForm button').prop('disabled', false);
                $('#indicadorFechamento').removeClass('status-fechado').addClass('status-aberto');
                
                console.log('Caixa configurado como ABERTO');
            }

            // Configura interface quando caixa está fechado
            function configurarCaixaFechado() {
                // Habilita abertura
                $('#cardAbertura').removeClass('card-disabled');
                $('#abrirCaixaForm input, #abrirCaixaForm button').prop('disabled', false);
                $('#indicadorAbertura').removeClass('status-fechado').addClass('status-aberto');
                
                // Desabilita movimentação
                $('#cardMovimento').addClass('card-disabled');
                $('#registrarMovimentoForm input, #registrarMovimentoForm button').prop('disabled', true);
                $('#indicadorMovimento').removeClass('status-aberto').addClass('status-fechado');
                
                // Desabilita fechamento
                $('#cardFechamento').addClass('card-disabled');
                $('#fecharCaixaForm input, #fecharCaixaForm textarea, #fecharCaixaForm button').prop('disabled', true);
                $('#indicadorFechamento').removeClass('status-aberto').addClass('status-fechado');
                
                // Limpa resumo
                $('#resumoCaixa span').text('0,00');
                $('#diferenca').text('0,00');
                
                console.log('Caixa configurado como FECHADO');
            }

            // Atualiza indicadores visuais de status
            function atualizarStatusVisual(caixaAberto) {
                if (caixaAberto) {
                    $('#statusCaixa').removeClass('alert-danger').addClass('alert-success');
                    $('#statusTexto').text('Caixa ABERTO - Movimentações habilitadas');
                } else {
                    $('#statusCaixa').removeClass('alert-success').addClass('alert-danger');
                    $('#statusTexto').text('Caixa FECHADO - Abra o caixa para registrar movimentações');
                }
            }

            // Função para atualizar o resumo do caixa
            function atualizarResumoCaixa() {
                if (!caixaAberto) return;
                
                $.ajax({
                    url: 'gerenciamento/caixa/buscar_resumo_caixa.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Resumo do caixa:', response);
                        
                        if (response.status === 'success') {
                            $('#valor_abertura_resumo').text(formatarMoeda(response.data.valor_abertura));
                            $('#total_entradas').text(formatarMoeda(response.data.total_entradas));
                            $('#total_saidas').text(formatarMoeda(response.data.total_saidas));
                            $('#subTotal').text(formatarMoeda(response.data.subTotal));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao atualizar resumo:', error);
                    }
                });
            }

            // Função para calcular diferença em tempo real
            function calcularDiferenca() {
                const valorFechamento = parseFloat($('#valor_fechamento').val()) || 0;
                const subTotal = parseFloat($('#subTotal').text().replace(',', '.')) || 0;
                const diferenca = valorFechamento - subTotal;
                $('#diferenca').text(formatarMoeda(diferenca));
            }

            // Função para formatar valores monetários
            function formatarMoeda(valor) {
                return parseFloat(valor).toFixed(2).replace('.', ',');
            }

            // Event listener para calcular diferença em tempo real
            $('#valor_fechamento').on('input', calcularDiferenca);

            // Verifica o status ao carregar a página
            verificarStatusCaixa();

            // Recarrega o status a cada 10 segundos
            setInterval(verificarStatusCaixa, 10000);

            // Submissão do formulário de abertura
            $('#abrirCaixaForm').submit(function(e) {
                e.preventDefault();
                
                const valorAbertura = parseFloat($('#valor_abertura').val());
                
                if (!valorAbertura || valorAbertura < 0) {
                    alert('Por favor, insira um valor de abertura válido.');
                    return;
                }

                $.ajax({
                    url: 'gerenciamento/caixa/abrir_caixa.php',
                    method: 'POST',
                    data: {
                        valor_abertura: valorAbertura
                    },
                    dataType: 'json',
                    success: function(response) {
                        alert(response.message);
                        $('#valor_abertura').val(''); // Limpa o campo
                        verificarStatusCaixa(); // Atualiza o status
                    },
                    error: function(xhr, status, error) {
                        alert('Erro ao abrir caixa: ' + error);
                    }
                });
            });

            // Submissão do formulário de movimentação
            $('#registrarMovimentoForm').submit(function(e) {
                e.preventDefault();
                
                const valor = parseFloat($('#valor').val());
                const tipo = $('input[name="tipo"]:checked').val();
                const descricao = $('#descricao').val().trim();
                
                if (!valor || valor <= 0) {
                    alert('Por favor, insira um valor válido.');
                    return;
                }
                
                if (!tipo) {
                    alert('Por favor, selecione o tipo de movimento.');
                    return;
                }
                
                if (!descricao) {
                    alert('Por favor, insira uma descrição.');
                    return;
                }

                $.ajax({
                    url: 'gerenciamento/caixa/registrar_movimento.php',
                    method: 'POST',
                    data: {
                        tipo: tipo,
                        valor: valor,
                        descricao: descricao
                    },
                    dataType: 'json',
                    success: function(response) {
                        alert(response.message);
                        // Limpa o formulário
                        $('#registrarMovimentoForm')[0].reset();
                        // Atualiza o resumo
                        atualizarResumoCaixa();
                    },
                    error: function(xhr, status, error) {
                        alert('Erro ao registrar movimento: ' + error);
                    }
                });
            });

            // Submissão do formulário de fechamento
            $('#fecharCaixaForm').submit(function(e) {
                e.preventDefault();
                
                const valorFechamento = parseFloat($('#valor_fechamento').val());
                
                if (valorFechamento === undefined || valorFechamento < 0) {
                    alert('Por favor, insira um valor de fechamento válido.');
                    return;
                }

                if (!confirm('Tem certeza que deseja fechar o caixa? Esta ação não pode ser desfeita.')) {
                    return;
                }

                $.ajax({
                    url: 'gerenciamento/caixa/fechar_caixa.php',
                    method: 'POST',
                    data: {
                        valor_fechamento: valorFechamento,
                        observacoes: $('#observacoes').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        alert(response.message);
                        if (response.diferenca !== undefined) {
                            $('#diferenca').text(formatarMoeda(response.diferenca));
                        }
                        // Limpa o formulário
                        $('#fecharCaixaForm')[0].reset();
                        // Atualiza o status
                        verificarStatusCaixa();
                    },
                    error: function(xhr, status, error) {
                        alert('Erro ao fechar caixa: ' + error);
                    }
                });
            });
        });
    </script>
</body>
</html>