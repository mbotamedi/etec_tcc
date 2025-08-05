<?php
@session_start();

// Verifica se algum filtro está ativo para o botão de limpar
$is_filtered = !empty($_GET['subCategoria']) || !empty($_GET['consulta']) || !empty($_GET['valor_min']) || !empty($_GET['valor_max']);
?>

<div class="container px-4 px-lg-5 my-4">
    <div class="d-flex flex-column flex-md-row gap-3">

        <div class="flex-grow-1">
            <form action="produtos.php" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="consulta"
                        placeholder="Buscar pelo nome do produto..."
                        aria-label="Buscar produtos"
                        value="<?= isset($_GET['consulta']) ? htmlspecialchars($_GET['consulta']) : '' ?>">
                    <button class="btn btn-dark" type="submit" title="Buscar">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="flex-shrink-0">
            <button class="btn btn-outline-dark w-100 w-md-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFiltros" aria-controls="offcanvasFiltros">
                <i class="bi bi-filter-left me-1"></i>
                Filtros e Categorias
            </button>
        </div>
    </div>
</div>


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFiltros" aria-labelledby="offcanvasFiltrosLabel">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasFiltrosLabel">Filtros</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <form action="produtos.php" method="GET">
            <?php if (!empty($_GET['consulta'])): ?>
                <input type="hidden" name="consulta" value="<?= htmlspecialchars($_GET['consulta']) ?>">
            <?php endif; ?>

            <div class="mb-4">
                <label class="form-label fw-bold">Faixa de Preço</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" name="valor_min" class="form-control" placeholder="Mínimo"
                        value="<?= isset($_GET['valor_min']) ? htmlspecialchars($_GET['valor_min']) : '' ?>"
                        step="0.01">
                    <span class="input-group-text">-</span>
                    <input type="number" name="valor_max" class="form-control" placeholder="Máximo"
                        value="<?= isset($_GET['valor_max']) ? htmlspecialchars($_GET['valor_max']) : '' ?>"
                        step="0.01">
                </div>
            </div>

            <div class="mb-4">
                <p class="fw-bold">Categorias</p>
                <div class="accordion" id="accordionCategorias">
                    <?php
                    if (!isset($conexao)) {
                        include("../includes/conexao.php");
                    }

                    $categorias = mysqli_query($conexao, "SELECT id, descricao FROM tb_categorias WHERE descricao <> 'Promoção do dia' AND descricao <> 'teste' ORDER BY descricao");

                    while ($cat = mysqli_fetch_assoc($categorias)):
                        $subcategorias = mysqli_query($conexao, "SELECT id, descricao FROM tb_subcategorias WHERE id_categoria = " . $cat["id"] . " ORDER BY descricao");

                        if (mysqli_num_rows($subcategorias) > 0):
                    ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-<?= $cat['id'] ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $cat['id'] ?>" aria-expanded="false" aria-controls="collapse-<?= $cat['id'] ?>">
                                        <?= htmlspecialchars(strtoupper($cat['descricao'])) ?>
                                    </button>
                                </h2>
                                <div id="collapse-<?= $cat['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $cat['id'] ?>" data-bs-parent="#accordionCategorias">
                                    <div class="list-group list-group-flush">
                                        <?php while ($sub = mysqli_fetch_assoc($subcategorias)): ?>
                                            <a href="?subCategoria=<?= $sub['id'] ?>" class="list-group-item list-group-item-action">
                                                <?= htmlspecialchars($sub['descricao']) ?>
                                            </a>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endif;
                    endwhile;
                    ?>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel-fill me-1"></i>
                    Aplicar Filtros
                </button>
                <?php if ($is_filtered): ?>
                    <a href="produtos.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i>
                        Limpar Filtros
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>