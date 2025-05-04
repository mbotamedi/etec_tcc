async function detalhesPedido(idPedido, event) {
    event.preventDefault();
    try {
        console.log('Carregando detalhes do pedido ID:', idPedido);
        const floatingWindow = document.getElementById('floatingWindow');
        const floatingWindowBody = document.getElementById('detalhesPedidoContent');

        // Remover qualquer backdrop existente
        const existingBackdrops = document.querySelectorAll('.floating-window-backdrop');
        existingBackdrops.forEach(backdrop => backdrop.remove());

        // Criar novo backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'floating-window-backdrop';
        document.body.appendChild(backdrop);

        // Configurar conteúdo inicial com spinner
        floatingWindowBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-warning" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p>Carregando detalhes...</p>
            </div>
        `;

        // Exibir janela e backdrop
        floatingWindow.style.display = 'block';
        backdrop.style.display = 'block';

        // Requisição AJAX
        const url = `detalhes_pedidos.php?id=${idPedido}`;
        console.log('Requisição para:', url);
        const response = await fetch(url, {
            cache: 'no-store'
        });

        console.log('Status da resposta:', response.status);
        const data = await response.text();
        console.log('Conteúdo retornado (primeiros 1000 caracteres):', data.substring(0, 1000));
        console.log('Número de linhas <tr> no HTML retornado:', (data.match(/<tr>/g) || []).length);

        if (!response.ok) {
            throw new Error(`Erro HTTP ${response.status}: ${response.statusText}`);
        }

        if (!data.trim()) {
            throw new Error('Resposta vazia do servidor');
        }

        floatingWindowBody.innerHTML = data;

        // Ajustar visibilidade das linhas
        setTimeout(() => {
            const rows = floatingWindowBody.querySelectorAll('.table tbody tr');
            console.log('Número de <tr> renderizados:', rows.length);
            rows.forEach((row, index) => {
                row.style.display = 'table-row';
                row.style.visibility = 'visible';
                row.style.opacity = '1';
                console.log(`Linha ${index + 1} visível:`, window.getComputedStyle(row).display !== 'none' && window.getComputedStyle(row).visibility !== 'hidden');
                console.log(`Conteúdo da linha ${index + 1}:`, row.innerHTML.substring(0, 200));
            });
            console.log('Forçando exibição das linhas');
        }, 100);

        // Ajustar padding para barra de rolagem
        if (floatingWindowBody.scrollHeight > floatingWindowBody.clientHeight) {
            floatingWindowBody.style.paddingRight = '1rem';
        }

        // Adicionar evento de clique no backdrop para fechar
        backdrop.addEventListener('click', function(e) {
            if (e.target === backdrop) {
                closeFloatingWindow();
            }
        });

    } catch (error) {
        console.error('Erro:', error);
        floatingWindowBody.innerHTML = `
            <div class="alert alert-danger">
                <h5>Erro ao carregar detalhes</h5>
                <p>${error.message}</p>
                <p>URL: ${url}</p>
                <button onclick="detalhesPedido(${idPedido}, event)" class="btn btn-warning btn-sm mt-2">
                    Tentar novamente
                </button>
            </div>
        `;
    }
}

function closeFloatingWindow() {
    const floatingWindow = document.getElementById('floatingWindow');
    const backdrops = document.querySelectorAll('.floating-window-backdrop');
    
    if (floatingWindow) {
        floatingWindow.style.display = 'none';
    }
    
    backdrops.forEach(backdrop => backdrop.remove());
}

function mostrarPedidos() {
    document.getElementById('secaoPedidos').style.display = 'block';
    document.getElementById('secaoEnderecos').style.display = 'none';
    
    document.querySelector('a[href="javascript:void(0);"][onclick="mostrarPedidos()"]').classList.add('active');
    document.querySelector('a[href="javascript:void(0);"][onclick="mostrarEnderecos()"]').classList.remove('active');
}

function mostrarEnderecos() {
  document.getElementById("secaoPedidos").style.display = "none";
  document.getElementById("secaoEnderecos").style.display = "block";

  document
    .querySelector('a[href="javascript:void(0);"][onclick="mostrarPedidos()"]')
    .classList.remove("active");
  document
    .querySelector(
      'a[href="javascript:void(0);"][onclick="mostrarEnderecos()"]'
    )
    .classList.add("active");

  const contentDiv = document.getElementById("enderecosContent");
  contentDiv.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-warning" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>
    `;

  fetch("../../includes/consulta_enderecos.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        contentDiv.innerHTML = `
                    <div class="alert alert-danger">
                        ${data.error}
                    </div>
                `;
        return;
      }

      let html = `
                <div class="mb-3">
                    <a href="cadastro_endereco.php" class="btn btn-primary">Cadastrar Novo Endereço</a>
                </div>
            `;

      if (data.enderecos.length === 0) {
        html += `
                    <div class="alert alert-info">
                        Você ainda não cadastrou nenhum endereço.
                        <a href="cadastro_endereco.php" class="alert-link">Cadastrar endereço</a>
                    </div>
                `;
        contentDiv.innerHTML = html;
        return;
      }

      html += `
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Endereço</th>
                                <th>Complemento</th>
                                <th>Bairro</th>
                                <th>Cidade/UF</th>
                                <th>CEP</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

      data.enderecos.forEach((endereco) => {
        html += `
                    <tr>
                        <td>${endereco.descricao}</td>
                        <td>${endereco.endereco}, ${endereco.numero}</td>
                        <td>${
                          endereco.complemento ? endereco.complemento : ""
                        }</td>
                        <td>${endereco.bairro}</td>
                        <td>${endereco.nome_cidade}/${
          endereco.sigla_estado
        }</td>
                        <td>${endereco.cep}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="excluirEndereco(${
                              endereco.id
                            })">Excluir</button>
                        </td>
                    </tr>
                `;
      });

      html += `
                        </tbody>
                    </table>
                </div>
            `;

      contentDiv.innerHTML = html;
    })
    .catch((error) => {
      contentDiv.innerHTML = `
                <div class="alert alert-danger">
                    Erro ao carregar endereços: ${error.message}
                </div>
            `;
    });
}

async function excluirEndereco(idEndereco) {
  if (!confirm("Tem certeza que deseja excluir este endereço?")) {
    return;
  }

  try {
    const response = await fetch("../../includes/excluir_endereco.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `id_endereco=${idEndereco}`,
    });

    const data = await response.json();

    if (data.success) {
      alert("Endereço excluído com sucesso!");
      // Recarregar a lista de endereços
      mostrarEnderecos();
    } else {
      alert("Erro: " + data.error);
    }
  } catch (error) {
    alert("Erro ao excluir endereço: " + error.message);
  }
}