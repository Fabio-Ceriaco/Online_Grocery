<?php

use core\classes\Store;

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <h1>Consultar Produtos</h1>
            <hr class="my-5">
            <table class="table table-striped" id="tabela_produtos">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Id produto</th>
                        <th class="text-center">Imagem</th>
                        <th class="text-center">Nome Produto</th>
                        <th class="text-center">Categoria</th>
                        <th class="text-center">Descrição</th>
                        <th class="text-center">Preço / uni.</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Visibilidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td class="text-start"><?= $produto->id_produto ?></td>
                            <td><img src="<?= $produto->imagem_produto ?>" alt="<?= $produto->nome_produto ?>" style="widht: 40px; height: 40px;"></td>
                            <td><a href="?q=editar_produto&id=<?= Store::aesEncriptar($produto->id_produto) ?>"><?= $produto->nome_produto ?></a></td>
                            <td><?= $produto->nome_categoria ?></td>
                            <td><?= $produto->descricao ?></td>
                            <td class="text-center"><?= $produto->preco ?></td>
                            <td class="text-center"><?= $produto->stock ?></td>
                            <td class="text-center">
                                <?php if ($produto->visivel == 0): ?>
                                    <i class="fa-solid fa-circle-xmark text-danger"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-circle-check text-success"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</section>