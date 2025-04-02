<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <h1>Editar Produto</h1>

            <?php if (isset($_SESSION['erro'])): ?>
                <span class="text-danger mb-3" style="color: red; font-size: 0.8rem">
                    <?=
                    $_SESSION['erro'];
                    unset($_SESSION['erro']);
                    ?>
                </span>
            <?php endif; ?>
            <div class="row">
                <form action="?q=atualaizar_produto" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_produto" value="<?= $dados_produto[0]->id_produto ?>">
                    <label for="produto-nome" class="form-label mt-3">Nome Porduto:</label>
                    <input type="text" name="produto-nome" id="produto-nome" class="form-control" value="<?= $dados_produto[0]->nome_produto ?>">
                    <hr>
                    <label for="produto-categoria" class="form-label">Categoria Porduto:</label>
                    <select name="produto-categoria" id="produto-categoria" class="form-select">
                        <option value="0" selected>Categorias</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria->id_categoria ?>"><?= $categoria->nome_categoria ?></option>
                        <?php endforeach; ?>
                    </select>
                    <hr>
                    <label for="produto-descricao" class="form-label ">Descricao:</label>
                    <input type="text" name="produto-descricao" id="produto-descricao" class="form-control" value="<?= $dados_produto[0]->descricao ?>">
                    <hr>
                    <label for="produto-preco" class="form-label ">Preço Unitário:</label>
                    <input type="text" name="produto-preco" id="produto-preco" class="form-control" value="<?= $dados_produto[0]->preco ?>">
                    <hr>
                    <label for="produto-stock" class="form-label ">Stock:</label>
                    <input type="text" name="produto-stock" id="produto-stock" class="form-control" value="<?= $dados_produto[0]->stock ?>">
                    <hr>
                    <label for="produto-visivel" class="form-label ">Estado Produto:</label>
                    <select name="produto-visivel" id="produto-visivel" class="form-select">
                        <option value="0" selected>Não visível</option>
                        <option value="1">Visível</option>
                    </select>

                    <input type="submit" value="Guardar Produto" class="btn btn-success my-5">
                </form>
            </div>
        </div>
    </div>
</section>