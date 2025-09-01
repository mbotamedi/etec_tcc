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

//CASO O CAMPO DE VALOR MÍNIMO FOR MENOR, ESTOURA ERRO

$erro_filtro = ''; // Variável para armazenar a mensagem de erro

// Verifica se os valores foram enviados e faz a validação
if (isset($_GET['valor_min']) && isset($_GET['valor_max'])) {

    // Converte os valores para números
    // A coerção de tipo (float) é uma boa prática mesmo para inputs "number"
    $valor_min = (float) $_GET['valor_min'];
    $valor_max = (float) $_GET['valor_max'];

    // Agora, faça a validação
    if ($valor_min > $valor_max) {
        $erro_filtro = 'O valor mínimo não pode ser maior que o valor máximo.';
    }
}

// =======================================================
// Verifica se qualquer filtro está ativo para mostrar o botão de limpar
// =======================================================
$filtros_ativos = !empty($_GET['subCategoria']) || !empty($_GET['valor_min']) || !empty($_GET['valor_max']) || !empty($_GET['consulta']) || isset($_GET['promocao']);


?>

<head>
    <link rel="stylesheet" href="../css/mediaQuery.css">
    <link rel="stylesheet" href="../css/pesquisa.css">

    <style>
        .nav-link {
            color: white;
        }

        .nav-link:hover {
            color: #ffcc00;
            /* Nova cor quando o mouse está sobre o elemento */
        }

        .nav-item>a {
            color: white;
        }

        .gap-1 {
            gap: 10px !important;
        }

        .navbar-toggler {
            margin-top: 10px;
        }

        .text-promo {
            font-size: 15px;
        }

        /* --- Início das Alterações para campos e botões menores --- */
        .form-control {
            font-size: 12px;
            /* Reduz o tamanho da fonte */
            padding: 0.25rem 0.5rem;
            /* Reduz o preenchimento */
            height: calc(1.5em + 0.5rem + 2px);
            /* Ajusta a altura com base no padding e border */
            max-width: 65px;
            /* Deixa o campo mais estreito */
        }

        .btn {
            /* Seletor genérico para todos os botões, se precisar ser mais específico use .btn-primary, .btn-danger */
            font-size: 12px;
            /* Reduz o tamanho da fonte dos botões */
            padding: 0.25rem 0.5rem;
            /* Reduz o preenchimento dos botões */
            height: calc(1.5em + 0.5rem + 2px);
            /* Garante que os botões tenham altura similar aos inputs */
            /* width: auto; Removido para que o padding ajuste o width naturalmente */
        }

        .navbar-text {
            font-size: 16px !important;
            /* Reduz o tamanho da fonte do texto "Valor:" e "até" */
            margin-right: 5px !important;
            /* Diminui a margem direita para economizar espaço */
        }

        .navbar-text strong {
            font-size: 15px !important;
            /* Reduz o tamanho da fonte do texto "Valor:" em negrito */
        }

        /* --- Fim das Alterações para campos e botões menores --- */
        /* --- Início das Alterações para Dispositivos Móveis --- */
        @media (max-width: 768px) {
            .d-flex.align-items-center {
                flex-direction: column;
                align-items: flex-start;
            }

            .d-flex.align-items-center .navbar-text,
            .d-flex.align-items-center .form-control {
                margin-right: 0 !important;
                margin-bottom: 5px;
                width: 100% !important;
                /* Volta a ocupar 100% em telas menores */
                max-width: unset !important;
                /* Remove o max-width em telas menores */
            }

            .d-flex.align-items-center .navbar-text strong {
                width: 100%;
                display: block;
                margin-bottom: 5px;
            }

            .d-flex.align-items-center .btn {
                width: 100%;
                margin-top: 10px;
            }
        }

        /* --- Fim das Alterações para Dispositivos Móveis --- */
    </style>
</head>

<nav class="navbar navbar-expand-lg navbar-dark" style=" margin-bottom: 0 !important;">

    <div class=" search-bar">
        <form method="get" action="index.php" class="barra-pesquisa">
            <input type="text" name="consulta" id="consulta" class="pesquisa-input"
                placeholder="Digite o Nome do Produto">
            <button type="submit" class="botao-pesquisa">
                <img src="../assets/img/lupa (3).png" alt="Pesquisar">
            </button>
        </form>
    </div>
    <div class="controla-ul">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="text-promo">Promoções e Consulta</span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" style="font-weight: bold; font-size: 20px;
                     background-color: rgba(252, 217, 20, 0.59); border-radius: 5px; 
                     margin-right: 15px; padding: 5px; margin-top: 20px;" href="index.php?promocao">PROMOÇÕES</a>
                </li>


                <?php
                include("../includes/conexao.php");
                $categorias = mysqli_query(mysql: $conexao, query: "select id, upper(descricao) as descricao from tb_categorias  where descricao <> 'Promoção do dia' and descricao <> 'teste' order by upper(descricao)");
                while ($listaCategoria = mysqli_fetch_assoc(result: $categorias)) {
                    $subcategoria = mysqli_query(mysql: $conexao, query: "select * from tb_subcategorias 
                 where id_categoria = " . $listaCategoria["id"] . " order by descricao");
                    $possuiSubmenu = mysqli_num_rows(result: $subcategoria);
                    $dropdown = "";
                    $parametros = '';
                    $dropdown_toggle = "";
                    if ($possuiSubmenu > 0) {
                        $dropdown = "dropdown";
                        $dropdown_toggle = "dropdown-toggle";
                        $parametros = 'role="button" data-bs-toggle="dropdown" aria-expanded="false"';
                    }
                    echo '
                    <li class="nav-item  ' . $dropdown . '">
                        <a class="nav-link" style="font-weight: bold; font-size: 15px;" ' . $dropdown_toggle . ' href="#" ' . $parametros . '>' . $listaCategoria["descricao"] . '</a>
                ';
                    if ($possuiSubmenu > 0) {
                        echo '<div class="dropdown-menu">';
                        while ($listaSubcategoria = mysqli_fetch_assoc(result: $subcategoria)) {
                            echo '<a class="dropdown-item" href="?subCategoria=' . $listaSubcategoria["id"] . $parametros_adicionais . '">
                        ' . $listaSubcategoria["descricao"] . '</a>';
                        }
                        echo '</div>';
                    }
                    echo '</li>';
                }
                ?>

            </ul>

            <form action="index.php" method="GET" class="d-flex g" style="padding: 5px;gap: 10px !important;  align-items: center; margin-bottom: 5px ">
                <span class="navbar-text" style="margin-right: 10px;">
                    <strong style=" font-weight:bold; font-size: 16px; color: #ffffffff;">Valor:</strong>
                </span>

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
                    value="<?= isset($_GET['valor_min']) ? htmlspecialchars($_GET['valor_min']) : '' ?>" step="0.01"
                    style="width: 75px;">
                <span class="navbar-text" style="font-weight: bold; font-size: 16px; color: #ffffffff">até</span>
                <input type="number" name="valor_max" class="form-control" placeholder="Máx"
                    value="<?= isset($_GET['valor_max']) ? htmlspecialchars($_GET['valor_max']) : '' ?>" step="0.01"
                    style="width: 75px;">
                <button type="submit" class="btn btn-primary ">Filtrar</button>

                <?php if ($filtros_ativos): ?>
                    <a href="index.php" class="btn btn-danger">Limpar</a>
                <?php endif; ?>

            </form>
        </div>
    </div>
</nav>