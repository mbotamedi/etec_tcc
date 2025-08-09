<?php

// Inclui o arquivo de verificação de login
@session_start();
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';

$parametros_adicionais = '';
if (!empty($_GET['valor_min'])) {
    $parametros_adicionais .= '&valor_min=' . urlencode($_GET['valor_min']);
}
if (!empty($_GET['valor_max'])) {
    $parametros_adicionais .= '&valor_max=' . urlencode($_GET['valor_max']);
}
if (!empty($_GET['consulta'])) {
    $parametros_adicionais .= '&consulta=' . urlencode($_GET['consulta']);
}

// =======================================================
// Verifica se qualquer filtro está ativo para mostrar o botão de limpar
// =======================================================
$filtros_ativos = !empty($_GET['subCategoria']) || !empty($_GET['valor_min']) || !empty($_GET['valor_max']) || !empty($_GET['consulta']) || isset($_GET['promocao']);


?>

<head>
    <link rel="stylesheet" href="../css/mediaQuery.css">
    <link rel="stylesheet" href="../css/pesquisa.css">
</head>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #dad7cd; margin-top: 2px;">

    <div class=" search-bar">
        <form method="get" action="index.php" class="barra-pesquisa">
            <input type="text" name="consulta" id="consulta" class="pesquisa-input" placeholder="Digite o Nome do Produto">
            <button type="submit" class="botao-pesquisa">
                <img src="../assets/img/lupa (3).png" alt="Pesquisar">
            </button>
        </form>
    </div>
    <div>
        <button class="navbar-toggler"
            type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span>Promoções e Consulta</span>
        </button>
        <div style="margin-top: 10px;" class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <img style=" padding-right: 5px" src="../assets/img/megaphone.jpg" alt="" width="38" height="30">
                <li class="nav-item">
                    <a class="nav-link" style="font-weight: bold; font-size: 15x; color: #000000;background-color: rgba(245, 226, 117, 0.59); border-radius: 5px; padding: 5px;" href="index.php?promocao">PROMOÇÕES</a>
                </li>


                <?php
                include("../includes/conexao.php");
                $categorias = mysqli_query($conexao, "select id, upper(descricao) as descricao from tb_categorias  where descricao <> 'Promoção do dia' and descricao <> 'teste' order by upper(descricao)");
                while ($listaCategoria = mysqli_fetch_assoc($categorias)) {
                    $subcategoria = mysqli_query($conexao, "select * from tb_subcategorias 
                where id_categoria = " . $listaCategoria["id"] . " order by descricao");
                    $possuiSubmenu = mysqli_num_rows($subcategoria);
                    $dropdown = "";
                    $parametros = '';
                    $dropdown_toggle = "";
                    if ($possuiSubmenu > 0) {
                        $dropdown = "dropdown";
                        $dropdown_toggle = "dropdown-toggle";
                        $parametros = 'role="button" data-bs-toggle="dropdown" aria-expanded="false"';
                    }
                    echo '
                    <li class="nav-item ' . $dropdown . '">
                        <a class="nav-link" style="font-weight: bold; font-size: 15x; color: #000000;" ' . $dropdown_toggle . '" href="#" ' . $parametros . '>' . $listaCategoria["descricao"] . '</a>                                
                ';
                    if ($possuiSubmenu > 0) {
                        echo '<div class="dropdown-menu">';
                        while ($listaSubcategoria = mysqli_fetch_assoc($subcategoria)) {
                            echo '<a class="dropdown-item" href="?subCategoria=' . $listaSubcategoria["id"] . $parametros_adicionais . '">
                        ' . $listaSubcategoria["descricao"] . '</a>';
                        }
                        echo '</div>';
                    }
                    echo '</li>';
                }
                ?>

            </ul>

            <span class="navbar-text" style="margin-right: 10px;">
                <strong style=" font-weight:bold; font-size: 16px; color: #000000">Valor:</strong>
            </span>
            <form action="index.php" method="GET" class="d-flex align-items-center gap-1">

                <!-- Campos ocultos para manter os filtros existentes ao filtrar por valor -->
                <?php if (!empty($_GET['consulta'])): ?>
                    <input type="hidden" name="consulta" value="<?= htmlspecialchars($_GET['consulta']) ?>">
                <?php endif; ?>
                <?php if (!empty($_GET['subCategoria'])): ?>
                    <input type="hidden" name="subCategoria" value="<?= htmlspecialchars($_GET['subCategoria']) ?>">
                <?php endif; ?>
                <?php if (isset($_GET['promocao'])): ?>
                    <input type="hidden" name="promocao" value="<?= htmlspecialchars($_GET['promocao']) ?>">
                <?php endif; ?>


                <input type="number" name="valor_min" class="form-control" placeholder="Mín"
                    value="<?= isset($_GET['valor_min']) ? htmlspecialchars($_GET['valor_min']) : '' ?>"
                    step="0.01" style="width: 75px;">
                <span class="navbar-text" style="font-weight: bold; font-size: 16px; color: #000000">até</span>
                <input type="number" name="valor_max" class="form-control" placeholder="Máx"
                    value="<?= isset($_GET['valor_max']) ? htmlspecialchars($_GET['valor_max']) : '' ?>"
                    step="0.01" style="width: 75px;">
                <button type="submit" class="btn btn-primary ">Filtrar</button>

                <?php if ($filtros_ativos): ?>
                    <a href="index.php" class="btn btn-danger">Limpar</a>
                <?php endif; ?>

            </form>
        </div>
    </div>
</nav>