async function detalhesPedido(idPedido, event) {
  event.preventDefault();
  try {
    console.log("Carregando detalhes do pedido ID:", idPedido);
    const floatingWindow = document.getElementById("floatingWindow");
    const floatingWindowBody = document.getElementById("detalhesPedidoContent");

    // Remover qualquer backdrop existente
    const existingBackdrops = document.querySelectorAll(
      ".floating-window-backdrop"
    );
    existingBackdrops.forEach((backdrop) => backdrop.remove());

    // Criar novo backdrop
    const backdrop = document.createElement("div");
    backdrop.className = "floating-window-backdrop";
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
    floatingWindow.style.display = "block";
    backdrop.style.display = "block";

    // Requisição AJAX
    const url = `detalhes_pedidos.php?id=${idPedido}`;
    console.log("Requisição para:", url);
    const response = await fetch(url, {
      cache: "no-store",
    });

    console.log("Status da resposta:", response.status);
    if (!response.ok) {
      throw new Error(`Erro HTTP ${response.status}: ${response.statusText}`);
    }

    const data = await response.text();
    console.log(
      "Conteúdo retornado (primeiros 1000 caracteres):",
      data.substring(0, 1000)
    );

    if (!data.trim()) {
      throw new Error("Resposta vazia do servidor");
    }

    floatingWindowBody.innerHTML = data;

    // Ajustar visibilidade das linhas
    setTimeout(() => {
      const rows = floatingWindowBody.querySelectorAll(".table tbody tr");
      console.log("Número de <tr> renderizados:", rows.length);
      rows.forEach((row, index) => {
        row.style.display = "table-row";
        row.style.visibility = "visible";
        row.style.opacity = "1";
        console.log(
          `Linha ${index + 1} visível:`,
          window.getComputedStyle(row).display !== "none" &&
            window.getComputedStyle(row).visibility !== "hidden"
        );
        console.log(
          `Conteúdo da linha ${index + 1}:`,
          row.innerHTML.substring(0, 200)
        );
      });
    }, 100);

    // Ajustar padding para barra de rolagem
    if (floatingWindowBody.scrollHeight > floatingWindowBody.clientHeight) {
      floatingWindowBody.style.paddingRight = "1rem";
    }

    // Adicionar evento de clique no backdrop
    backdrop.addEventListener("click", function (e) {
      if (e.target === backdrop) {
        closeFloatingWindow();
      }
    });
  } catch (error) {
    console.error("Erro detalhado:", error);
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