<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <h3>Histórico encomendas de : <?= $historico_encomendas[0]->nome_completo ?></h3>
            <hr>
            <?php if (count($historico_encomendas) == 0): ?>
                <hr>
                <p>Não existem encomendas registadas.</p>
                <hr>
            <?php else: ?>
                <small>
                    <table class=" table table-striped" id="tabela_encomendas">
                        <thead class=" text-center table-dark ">
                            <tr>
                                <th>Código Encomenda</th>
                                <th>Data Encomenda</th>
                                <th>Status</th>
                                <th>Atualizado em</th>
                            </tr>
                        </thead>
                        <tbody class=" text-center">
                            <?php foreach ($historico_encomendas as $encomenda): ?>
                                <tr>
                                    <td><strong><?= $encomenda->codigo_encomenda ?></strong></td>
                                    <td><?= substr($encomenda->data_encomenda, 0, 10) ?></td>
                                    <td><?= $encomenda->status ?></td>
                                    <td><?= $encomenda->updated_at ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <small>
                    <?php endif; ?>
        </div>
    </div>
</section>