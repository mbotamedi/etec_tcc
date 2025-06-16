<!--begin::App Content-->
<div class="app-content" style="padding-left: 20px;padding-right: 20px;">

  <div class="card card-warning card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header">
      <div class="card-title">Cadastro de Promoção</div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form name="FrmCadastro" id="FrmCadastro" action="cadastros/produto_promocao/salvar.php" method="post">
      <!--begin::Body-->
      <div class="card-body">
        
        <div class="row mb-2">
          <label for="txtprodutos" class="col-sm-2 col-form-label">Produtos</label>
          <div class="col-sm-10">
            <input type="text" name="txtprodutos" id="txtprodutos" class="form-control">
          </div>
        </div>

        <div class="row mb-2">
          <label for="txtdesconto" class="col-sm-2 col-form-label">Desconto</label>
          <div class="col-sm-10">
            <input type="text" name="txtdesconto" id="txtdesconto" class="form-control">
          </div>
        </div>
        
        <div class="row mb-2">
          <div class="col-sm-2">
            <img id="produto_foto" src="../assets/fotos/sem-foto.png" class="img-fluid">
          </div>
          <div class="col-sm-10">
            <label for="inputEmail13" class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control">
          </div>
        </div>
      </div>
  </div>
  <!--end::Body-->
  <!--begin::Footer-->
  <div class="card-footer">
    <input type="hidden" name="id" id="id" value="0">
    <button type="submit" class="btn btn-success float-end" id="btnSalvar">Salvar</button>
  </div>
  <!--end::Footer-->
  </form>
  <!--end::Form-->
</div>

<div class="card card-primary card-outline mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div class="card-title">Produtos Cadastrados</div>
    <form id="pesquisa" class="d-flex align-items-center" style="gap: 10px;" method="post">
      <div class="input-group">
        <input type="text" name="consulta" id="consulta" class="form-control pesquisa-input" placeholder="Buscar produtos...">
        <button id="btnpesquisa" type="submit" class="btn btn-outline-secondary">
          <img src="../assets/img/lupa (1).png" style="width: 20px; height: 20px;" alt="Pesquisar">
        </button>
      </div>
    </form>
  </div>
  <div class="card-body" id="listar">
    <!-- Conteúdo será carregado aqui -->
  </div>
</div>



</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../js/funcoes.js"></script>
<script>
  $(document).ready(function() {

    $("#btnpesquisa").click(function(e) {
      e.preventDefault();
      var pesquisa = $('#consulta').val();
      //alert(pesquisa);
      $.post('cadastros/produtos_promocao/listar.php', {
        consulta: pesquisa
      }, function(retorno) {
        $("#listar").html(retorno);
      });
    })


    $("#btnSalvar").click(function() {
      $("#txtSubCategoria").css("border-color", "#CCC");

      /*if ($("#txtSubCategoria").val() == '') {
        $("#txtSubCategoria").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtSubCategoria").focus();
        return false;
      }*/


      if ($("#txtprodutos").val() == '') {
        $("#txtprodutos").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtprodutos").focus();
        return false;
      }

      if ($("#txtdesconto").val() == '') {
        $("#txtdesconto").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtdesconto").focus();
        return false;
      }

      /*if ($("txtquantidade").val() == '') {
        $("txtquantidade").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("txtquantidade").focus();
        return false;
      }*/



      $('#FrmCadastro').ajaxForm(function(retorno) {
        // alert(retorno);
        mostraDialogo(retorno, 'info', 3000);
        $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
        $("#listar").load("cadastros/produtos_promocao/listar.php");
        $("#id").val(0);
        $('#FrmCadastro')[0].reset();
        /*$("#txtsubcategoria").focus();*/
      });

    })


    $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
    $("#listar").load("cadastros/produtos_promocao/listar.php");

  });
</script>