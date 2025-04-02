<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <h1>Adicionar Categoria</h1>

            <?php if (isset($_SESSION['erro'])): ?>
                <span class="text-danger mb-3" style="color: red; font-size: 0.8rem">
                    <?=
                    $_SESSION['erro'];
                    unset($_SESSION['erro']);
                    ?>
                </span>
            <?php endif; ?>
            <div class="row">
                <form action="?q=submeter_categoria" method="post" enctype="multipart/form-data">
                    <label for="categoria-nome" class="form-label mt-3">Nome Categoria:</label>
                    <input type="text" name="categoria-nome" id="categoria-nome" class="form-control">
                    <hr>

                    <label for="categoria-imagem" class="form-label">Imagem Produto:</label>
                    <input type="file" name="categoria-imagem" id="categoria-imagem" class="form-control">
                    <input type="submit" value="Guardar Categoria" class="btn btn-success my-5">
                </form>
            </div>
        </div>
    </div>
</section>