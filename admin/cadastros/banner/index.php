<!--begin::App Content-->
<div class="app-content" style="padding-left: 20px;padding-right: 20px;">

  <div class="card card-warning card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header">
      <div class="card-title">Cadastro de Promoção</div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form name="FrmCadastro" id="FrmCadastro" action="cadastros/banner/salvar.php" method="post" enctype="multipart/form-data">
      <!--begin::Body-->
      <div class="card-body">

        <div class="row mb-2">
          <label for="txtpro" class="col-sm-2 col-form-label">Código da Promoção</label>
          <div class="col-sm-10">
            <input type="text" name="txtpro" id="txtpro" class="form-control">
          </div>
        </div>
        <div class="row mb-2">
          <label for="txtcod" class="col-sm-2 col-form-label">Código do Produtos</label>
          <div class="col-sm-10">
            <input type="text" name="txtcod" id="txtcod" class="form-control">
          </div>
        </div>
        <div class="row mb-2">
          <label for="txtprodutos" class="col-sm-2 col-form-label">Descrição </label>
          <div class="col-sm-10">
            <input type="text" name="txtprodutos" id="txtprodutos" class="form-control">
          </div>
        </div>

        <div class="row mb-2">
          <label for="txtqtd" class="col-sm-2 col-form-label">Quantidade</label>
          <div class="col-sm-10">
            <input type="text" name="txtqtd" id="txtqtd" class="form-control">
          </div>
        </div>
        <div class="row mb-2">
          <label for="txtvl" class="col-sm-2 col-form-label">Valor</label>
          <div class="col-sm-10">
            <input type="text" name="txtvl" id="txtvl" class="form-control">
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-sm-2">
            <img id="produto_foto" src="../assets/fotos/sem-foto.png" class="img-fluid">
          </div>
          <div class="card-footer">
            <input type="hidden" name="id" id="id" value="0">
            <button type="submit" class="btn btn-success float-end" id="btnSalvar">Salvar</button>
          </div>
        </div>
      </div>
  </div>
  </form>
  <!--end::Form-->
</div>

<?php
include("../includes/conexao.php");
$query = "Select  ban.id from tb_promocoes_banner as ban";
$banner = mysqli_query($conexao, $query);

?>
<form name="Banner" id="Banner" action="cadastros/banner/banner_img.php" method="post" enctype="multipart/form-data">
  <div class="app-content" style="padding: 20px;">
    <div class="row">
      <!-- Select de Código do Banner -->
      <div class="col-md-6">
        <label for="cod_banner" class="form-label">Código do Banner</label>
        <select name="cod_banner" id="cod_banner" class="form-select">
          <option value="">Selecione Cod Banner</option>
          <?php
          include("../includes/conexao.php");
          $query = "SELECT ban.id FROM tb_promocoes_banner AS ban";
          $banner = mysqli_query($conexao, $query);

          while ($b = mysqli_fetch_assoc($banner)) :
          ?>
            <option value="<?php echo $b['id']; ?>"><?php echo $b['id']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <!-- Input de Foto -->
      <div class="col-md-6">
        <label for="foto" class="form-label">Foto do Banner</label>
        <input type="file" name="foto" id="foto" class="form-control">
      </div>
      <div class="card-footer" style="padding-top: 20px;padding-right: 20px;">
        <input type="hidden" name="id" id="id" value="0">
        <button type="submit" class="btn btn-success float-end" id="btnSalvar">Salvar</button>
      </div>
    </div>
  </div>
</form>


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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../js/funcoes.js"></script>
<script>
  $(document).ready(function() {

    $("#btnpesquisa").click(function(e) {
      e.preventDefault();
      var pesquisa = $('#consulta').val();
      //alert(pesquisa);
      $.post('cadastros/banner/listar.php', {
        consulta: pesquisa
      }, function(retorno) {
        $("#listar").html(retorno);
      });
    })


    $("#btnSalvar").click(function() {

      if ($("#txtpro").val() == '') {
        $("#txtpro").css("border-color", "red");
        alert("Favor Preencha o campo Código da Promoção");
        $("#txtpro").focus();
        return false;
      }

      if ($("#txtcod").val() == '') {
        $("#txtcod").css("border-color", "red");
        alert("Favor Preencha o campo Código do Produtos");
        $("#txtcod").focus();
        return false;
      }

      if ($("#txtprodutos").val() == '') {
        $("#txtprodutos").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtprodutos").focus();
        return false;
      }

      if ($("#txtqtd").val() == '') {
        $("#txtqtd").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtqtd").focus();
        return false;
      }

      if ($("#txtvl").val() == '') {
        $("#txtvl").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtvl").focus();
        return false;
      }

      $('#FrmCadastro').ajaxForm(function(retorno) {
        // alert(retorno);
        mostraDialogo(retorno, 'info', 3000);
        $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
        $("#listar").load("cadastros/banner/listar.php");
        $("#id").val(0);
        $('#FrmCadastro')[0].reset();
        $('#Banner')[0].reset();
        $("#txtqtd").focus();
      });

    })


    $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
    $("#listar").load("cadastros/banner/listar.php");

  });
</script>