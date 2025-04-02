<?php

use core\classes\Store;
?>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <h1>Consultar Categorias</h1>
            <hr class="my-5">
            <table class="table table-striped" id="tabela_produtos">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Id Categoria</th>
                        <th class="text-center">Imagem</th>
                        <th class="text-center">Nome Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td class="text-center"><?= $categoria->id_categoria ?></td>
                            <td class="text-center"><img src="<?= $categoria->imagem_categoria ?>" alt="<?= $categoria->nome_categoria ?>" style="widht: 40px; height: 40px;"></td>
                            <td class="text-center"><?= $categoria->nome_categoria ?></td>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</section>