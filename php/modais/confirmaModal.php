<div class="modal fade" id="modalLogout" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar ação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja sair?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="btnConfirmarLogout">Sair</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
    // Abre o modal quando clicar no link Sair
    document.querySelector('.btn-logout').addEventListener('click', function(e) {
        // e.preventDefault();
    });
    
    // Configura ação do botão Cancelar (já está configurado via data-bs-dismiss)
    
    // Configura ação do botão Sair
    document.getElementById('btnConfirmarLogout').addEventListener('click', function() {
        window.location.href = '../../php/logout.php';
    });
});
</script>