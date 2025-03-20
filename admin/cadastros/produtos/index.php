<!--begin::App Content-->
<div class="app-content" style="padding-left: 20px;padding-right: 20px;">

  <div class="card card-warning card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header"><div class="card-title">Cadastro de Produtos</div></div>
    <!--end::Header-->
    <!--begin::Form-->
    <form name="FrmCadastro" id="FrmCadastro" action="cadastros/produtos/salvar.php" method="post">
      <!--begin::Body-->
      <div class="card-body">
        <div class="row mb-2">
          <label for="txtprodutos" class="col-sm-2 col-form-label">Produtos</label>
          <div class="col-sm-10">
            <input type="text" name="txtprodutos" id="txtprodutos" class="form-control">
          </div>
        </div>   
        <div class="row mb-2">
          <label for="txtdescricao" class="col-sm-2 col-form-label">Produtos</label>
          <div class="col-sm-10">
            <input type="text" name="txtdescricao" id="txtdescricao" class="form-control">
          </div>
        </div> 
        <div class="row mb-2">
          <label for="txtvalor" class="col-sm-2 col-form-label">Valor</label>
          <div class="col-sm-10">
            <input type="text" name="txtvalor" id="txtvalor" class="form-control">
          </div>
        </div>  
        <div class="row mb-2">
          <label for="txtestoque" class="col-sm-2 col-form-label">Quantidade</label>
          <div class="col-sm-10">
            <input type="text" name="txtestoque" id="txtestoque" class="form-control">
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
    <div class="card-header"><div class="card-title">Produtos Cadastrados</div></div>
        <div class="card-body" id="listar"></div>
  </div>



</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../js/funcoes.js"></script>
<script>
  $( document ).ready(function() {

  $("#btnSalvar").click(function(){  
    $("#txtsubcategoria").css("border-color","#CCC");
    
    if ($("#txtsubcategoria").val() == ''){
      $("#txtsubcategoria").css("border-color","red");
      alert("Favor Preencha o campo SubCategoria");
      $("#txtsubcategoria").focus();      
      return false;
    }

    $('#FrmCadastro').ajaxForm(function(retorno) {
       // alert(retorno);
        mostraDialogo(retorno, 'info', 3000);
        $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
        $("#listar").load("cadastros/produtos/listar.php");
        $("#id").val(0);
        $('#FrmCadastro')[0].reset();
        $("#txtcategoria").focus();
    });
    
  })

  
  $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
  $("#listar").load("cadastros/produtos/listar.php");

});
</script>