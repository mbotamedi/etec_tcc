  function resetHeaderStyles() {
    document.querySelector('#secaoPedidos .card-header').classList.remove('card-header-active');
    document.querySelector('#secaoEnderecos .card-header').classList.remove('card-header-active');
    document.querySelector('#conta .card-header').classList.remove('card-header-active');
}

function mostrarPedidos() {
    resetHeaderStyles();
    document.getElementById('secaoPedidos').style.display = 'block';
    document.getElementById('secaoEnderecos').style.display = 'none';
    document.getElementById('conta').style.display = 'none';
    document.querySelector('#secaoPedidos .card-header').classList.add('card-header-active');
    document.querySelector('.list-group-item.active').classList.remove('active');
    document.querySelector('.list-group-item[href="javascript:void(0);"][onclick="mostrarPedidos()"]').classList.add('active');
}
function mostrarEnderecos() {
    resetHeaderStyles();
    document.getElementById('secaoPedidos').style.display = 'none';
    document.getElementById('secaoEnderecos').style.display = 'block';
    document.getElementById('conta').style.display = 'none';
    document.querySelector('#secaoEnderecos .card-header').classList.add('card-header-active');
    document.querySelector('.list-group-item.active').classList.remove('active');
    document.querySelector('.list-group-item[href="javascript:void(0);"][onclick="mostrarEnderecos()"]').classList.add('active');
    carregarEnderecos();
}



 function carregarEnderecos() {
   fetch("carregar_enderecos.php")
     .then((response) => response.json())
     .then((data) => {
       const enderecosContent = document.getElementById("enderecosContent");
       if (data.error) {
         enderecosContent.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
         return;
       }
       if (data.length === 0) {
         enderecosContent.innerHTML = `<div class="alert alert-info">Nenhum endereço cadastrado.</div>`;
         return;
       }
       let html = '<ul class="list-group">';
       data.forEach((endereco) => {
         html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${endereco.descricao}</strong><br>
                                    ${endereco.endereco}, ${endereco.numero}<br>
                                    ${endereco.bairro}, ${
           endereco.nome_cidade
         }/${endereco.sigla_estado}<br>
                                    CEP: ${endereco.cep}
                                    ${
                                      endereco.complemento
                                        ? "<br>Complemento: " +
                                          endereco.complemento
                                        : ""
                                    }
                                </div>
                                <button class="btn btn-sm btn-danger" onclick="excluirEndereco(${
                                  endereco.id
                                })">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </li>`;
       });
       html += "</ul>";
       enderecosContent.innerHTML = html;
     })
     .catch((error) => {
       console.error("Erro ao carregar endereços:", error);
       document.getElementById("enderecosContent").innerHTML =
         '<div class="alert alert-danger">Erro ao carregar endereços.</div>';
     });
 }

 function excluirEndereco(id_endereco) {
    if (confirm('Tem certeza que deseja excluir este endereço?')) {
        fetch('../../includes/excluir_endereco.php', {  // Ajuste o caminho
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_endereco=${encodeURIComponent(id_endereco)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
            }
            return response.text().then(text => {
                console.log('Resposta bruta:', text); // Log para depuração
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error('Resposta não é JSON válido: ' + text);
                }
            });
        })
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload(); // Ou atualizar a lista de endereços dinamicamente
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Erro ao excluir endereço:', error);
            alert('Erro ao excluir endereço: ' + error.message);
        });
    }
}

function mostrarConta() {
    resetHeaderStyles();
    document.getElementById('secaoPedidos').style.display = 'none';
    document.getElementById('secaoEnderecos').style.display = 'none';
    document.getElementById('conta').style.display = 'block';
    document.querySelector('#conta .card-header').classList.add('card-header-active');
    document.querySelector('.list-group-item.active').classList.remove('active');
    document.querySelector('.list-group-item[href="javascript:void(0);"][onclick="mostrarConta()"]').classList.add('active');
}



 function closeFloatingWindow() {
   console.log("Função closeFloatingWindow chamada");
   const floatingWindow = document.getElementById("floatingWindow");
   const backdrop = document.querySelector(".floating-window-backdrop");
   if (floatingWindow && backdrop) {
     floatingWindow.style.display = "none";
     backdrop.style.display = "none";
   } else {
     console.log("Erro: Elementos não encontrados.");
   }
 }

 