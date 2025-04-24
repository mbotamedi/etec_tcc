<!--begin::App Content-->
<div class="app-content" style="padding-left: 20px;padding-right: 20px;">

  <div class="card card-warning card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header">
      <div class="card-title">Cadastro de Usuarios</div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form name="FrmCadastro" id="FrmCadastro" action="cadastros/usuarios/salvar.php" method="post">
      <!--begin::Body-->
      <div class="card-body">

        <div class="row mb-2">
          <label for="txtnome" class="col-sm-2 col-form-label">Nome</label>
          <div class="col-sm-10">
            <input type="text" name="txtnome" id="txtnome" class="form-control">
          </div>
        </div>

        <div class="row mb-2">
          <label for="txtcpf" class="col-sm-2 col-form-label">CPF</label>
          <div class="col-sm-10">
            <input type="text" name="txtcpf" id="txtcpf" class="form-control" oninput="this.value = formatarCPF(this.value)" maxlength="14">

          </div>
        </div>
        <div class="row mb-2">
          <label for="txtemail" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="email" name="txtemail" id="txtemail" class="form-control">
          </div>
        </div>
        <div class="row mb-2">
          <label for="txtsenha" class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-10">
            <input type="password" name="txtsenha" id="txtsenha" class="form-control">
          </div>
        </div>
        <div class="row mb-2">
          <label for="txtcelular" class="col-sm-2 col-form-label">Celular</label>
          <div class="col-sm-10">
            <input type="text" name="txtcelular" id="txtcelular" class="form-control" oninput="this.value = formatarCelular(this.value)"
              maxlength="15">
          </div>
        </div>

        <div class="row mb-2">
          <label for="txtcargo" class="col-sm-2 col-form-label">Cargo</label>
          <div class="col-sm-10">
            <select class="form-select" name="subcategoria" id="subcategoria" required="">
              <!-- Opção padrão (prompt) -->
              <?php
              include_once("../includes/conexao.php");
              $qryCargo = mysqli_query($conexao, "select * from tb_nivel_usuario;");
              while ($usuario = mysqli_fetch_assoc($qryCargo)) {
                echo '<option value="' . $usuario["id"] . '">' . $usuario["cargo"] . '</option>';
              }
              ?>
            </select>
            <br>
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
      <div class="card-title">Usuarios Cadastrados</div>
      <form id="pesquisa" class="d-flex align-items-center" style="gap: 10px;" method="post">
        <div class="input-group">
          <input type="text" name="consulta" id="consulta" class="form-control pesquisa-input" placeholder="Buscar Usuarios...">
          <button id="btnpesquisa" type="submit" class="btn btn-outline-secondary">
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

    $("#btnpesquisa").click(function(e) {
      e.preventDefault();
      var pesquisa = $('#consulta').val();
      //alert(pesquisa);
      $.post('cadastros/usuarios/listar.php', {
        consulta: pesquisa
      }, function(retorno) {
        $("#listar").html(retorno);
      });
    })


    $("#btnSalvar").click(function() {
      //$("#txtSubCategoria").css("border-color", "#CCC");

      if ($("#txtnome").val() == '') {
        $("#txtnome").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtnome").focus();
        return false;
      }


      if ($("#txtcpf").val() == '') {
        $("#txtcpf").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtcpf").focus();
        return false;
      }

      if ($("#txtemail").val() == '') {
        $("#txtemail").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("#txtemail").focus();
        return false;
      }

      if ($("txtsenha").val() == '') {
        $("txtsenha").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("txtsenha").focus();
        return false;
      }

      if ($("txtcelular").val() == '') {
        $("txtcelular").css("border-color", "red");
        alert("Favor Preencha o campo Descrição do Produtos");
        $("txtcelular").focus();
        return false;
      }



      $('#FrmCadastro').ajaxForm(function(retorno) {
        // alert(retorno);
        mostraDialogo(retorno, 'info', 3000);
        $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
        $("#listar").load("cadastros/usuarios/listar.php");
        $("#id").val(0);
        $('#FrmCadastro')[0].reset();
        $("#txtnome").focus();
      });

    })


    $("#listar").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
    $("#listar").load("cadastros/usuarios/listar.php");

  });

  function formatarCPF(cpf) {
    if (!cpf) return "";
    cpf = cpf.replace(/\D/g, "");
    cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    return cpf;
  }

  function formatarCelular(celular) {
    if (!celular) return "";
    celular = celular.replace(/\D/g, "");
    celular = celular.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
    return celular;
  }
</script>