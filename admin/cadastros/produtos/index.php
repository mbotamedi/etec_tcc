<!--begin::App Content-->
<div class="app-content" style="padding-left: 20px;padding-right: 20px;">

  <div class="card card-warning card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header">
      <div class="card-title">Cadastro de Produtos</div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form name="FrmCadastro" id="FrmCadastro" action="cadastros/produtos/salvar.php" method="post">
      <!--begin::Body-->
      <div class="card-body">
        <div class="row mb-2">
          <label for="subcategoria" class="col-sm-2 col-form-label">Subcategoria:</label>
          <div class="col-sm-7">
            <select class="form-select" name="subcategoria" id="subcategoria">
              <!-- Opção padrão (prompt) -->
              <option value="" disabled selected>Selecionar uma subcategoria para Cadastros de Produto Novo</option>
              <?php
              include_once("../includes/conexao.php");
              $qryprodutos = mysqli_query($conexao, "SELECT DISTINCT pr.id AS id, sub.id AS sub_id, sub.descricao AS des FROM tb_produtos pr INNER JOIN tb_subcategorias sub ON pr.id_subcategoria = sub.id GROUP BY sub.descricao ORDER BY sub.descricao");
              while ($listaCat = mysqli_fetch_assoc($qryprodutos)) {
                echo '<option value="' . $listaCat["sub_id"] . '">' . $listaCat["des"] . '</option>';
              }
              ?>
            </select>
          </div>
        </div>
        <div class="row mb-2">
          <label for="txtprodutos" class="col-sm-2 col-form-label">Produtos</label>
          <div class="col-sm-10">
            <input type="text" name="txtprodutos" id="txtprodutos" class="form-control">
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
            <input type="text" name="txtquantidade" id="txtquantidade" class="form-control">
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
      <form class="d-flex align-items-center" style="gap: 10px;" method="post">
        <div class="input-group">
          <input type="text" name="consulta" id="consulta" class="form-control pesquisa-input" placeholder="Buscar produtos...">
          <button type="submit" class="btn btn-outline-secondary">
            <img src="../imgs/lupa (1).png" style="width: 20px; height: 20px;" alt="Pesquisar">
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

    $("#btnSalvar").click(function() {
      $("#txtprodutos").css("border-color", "#CCC");

      if ($("#txtprodutos").val() == '') {
        $("#txtprodutos").css("border-color", "red");
        alert("Favor Preencha o campo SubCategoria");
        $("#txtprodutos").focus();
        return false;
      }

      $('#FrmCadastro').ajaxForm(function(retorno) {
        // alert(retorno);
        mostraDialogo(retorno, 'info', 3000);
        $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
        $("#listar").load("cadastros/produtos/listar.php");
        $("#id").val(0);
        $('#FrmCadastro')[0].reset();
        //$("#txtsubcategoria").focus();
      });

      $('#FrmCadastro1').ajaxForm(function(retorno) {
        // alert(retorno);
        mostraDialogo(retorno, 'info', 3000);
        $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
        $("#listar").load("cadastros/produtos/listar.php");
        $('#FrmCadastro')[0].reset();
        $('#consulta').val();
      });


    })


    $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
    $("#listar").load("cadastros/produtos/listar.php");

  });
</script>