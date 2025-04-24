function mostraDialogo(mensagem, tipo, tempo){
    
    // se houver outro alert desse sendo exibido, cancela essa requisição
    if($("#message").is(":visible")){
        return false;
    }

    // se não setar o tempo, o padrão é 3 segundos
    if(!tempo){
        var tempo = 3000;
    }

    // se não setar o tipo, o padrão é alert-info
    if(!tipo){
        var tipo = "info";
    }  
    // monta o css da mensagem para que fique flutuando na frente de todos elementos da página
    var cssMessage = "display: block; position: fixed; top: 0; left: 20%; right: 20%; width: 60%; padding-top: 10px; z-index: 9999";
    var cssInner = "margin: 0 auto; box-shadow: 1px 1px 5px black;";

    // monta o html da mensagem com Bootstrap
    var dialogo = "";
    dialogo += '<div id="message" style="'+cssMessage+'">';
    dialogo += '    <div id="message" class="alert alert-'+tipo+' alert-dismissable" style="'+cssInner+'">';
   // dialogo += '    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>';
    dialogo +=          mensagem;
    dialogo += '    </div>';
    dialogo += '</div>';

    // adiciona ao body a mensagem com o efeito de fade
    $("body").append(dialogo);
    $("#message").hide();
    $("#message").fadeIn(200);

    // contador de tempo para a mensagem sumir
    setTimeout(function() {
        $('#message').fadeOut(300, function(){
            $(this).remove();
        });
    }, tempo); // milliseconds

}	


function modalPergunta(titulo, pergunta) {
    return new Promise((resolve) => {
        // Remover qualquer modal existente
        $('#dynamicModal').remove();

        // Criar o modal dinamicamente
        var modalHtml = `
            <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dynamicModalLabel">${titulo}</h5>
                            <!----<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>---->
                        </div>
                        <div class="modal-body">
                            ${pergunta}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="modalCancel" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="modalOk">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>`;

        // Adicionar o modal ao body
        $('body').append(modalHtml);

        // Exibir o modal
        $('#dynamicModal').modal('show');

        // Evento para o botão "OK"
        $('#modalOk').on('click', function () {
            resolve(true); // Retorna true
            $('#dynamicModal').modal('hide'); // Fecha o modal
        });

        // Evento para o botão "Cancelar"
        $('#modalCancel, .close').on('click', function () {
            resolve(false); // Retorna false
            $('#dynamicModal').modal('hide'); // Fecha o modal
        });

        // Remover o modal da DOM após fechar
        $('#dynamicModal').on('hidden.bs.modal', function () {
            $(this).remove();
        });
    });
}