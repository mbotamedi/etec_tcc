<?php
// Inclui o arquivo de verificação de login
@session_start();
$tipo = isset($_SESSION['usuario']['tipo']) ? $_SESSION['usuario']['tipo'] : 'cliente';
?>

<head>
    <link rel="stylesheet" href="../css/mediaQuery.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mediaQuery.css">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="display: flex;">

    <div class="menuNAVBAR" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php
            include("../includes/conexao.php");
            $categorias = mysqli_query($conexao, "select id, upper(descricao) as descricao from tb_categorias  where descricao <> 'Promoção do dia' and descricao <> 'teste' order by upper(descricao)");
            while ($listaCategoria = mysqli_fetch_assoc($categorias)) {
                $subcategoria = mysqli_query($conexao, "select * from tb_subcategorias 
                where id_categoria = " . $listaCategoria["id"] . " order by descricao");
                $possuiSubmenu = mysqli_num_rows($subcategoria); //vai retornar a quantidade de linhas retornadas na consultas
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
                        <a class="nav-link ' . $dropdown_toggle . '" href="#" ' . $parametros . '>' . $listaCategoria["descricao"] . '</a>                                
                ';
                //Listo as subCategorias se existirem                            
                if ($possuiSubmenu > 0) {
                    echo '<div class="dropdown-menu">';
                    while ($listaSubcategoria = mysqli_fetch_assoc($subcategoria)) {
                        echo '<a class="dropdown-item" href="?pg=Produtos&subCategoria=' . $listaSubcategoria["id"] . '">
                        ' . $listaSubcategoria["descricao"] . '</a>';
                    }
                    echo '</div>';
                }
                echo '</li>';
            }
            ?>
        </ul>
        <div class="filtroPreco">
            <div class="containerPreco" style="display: flex; justify-content: center;">
                <!-- <p style="color: black ;">FILTRAR</p> -->
                <form action="?pg=Produtos" method="post" style="display: flex; justify-content: center; height: 20%; gap: 5px;">
                    <input type="number" name="precoMinimo" placeholder="R$ Mínimo" class="form-control">
                    <input type="number" name="precoMaximo" placeholder="R$ Máximo" class="form-control">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
        </div>

    </div>


</nav>