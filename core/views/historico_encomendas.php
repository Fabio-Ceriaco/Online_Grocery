<?php

use core\classes\Store;
?>

<section class="container my-5" style="min-height: 700px;">
    <h2 class="text-center">Histórico encomendas</h2>
    <?php if (count($historico_encomendas) != 0): ?>
        <table class="table my-5 table-striped" id="tabela-historico-encomendas">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Código da Encomenda</th>
                    <th scope="col">Data da Encomenda</th>
                    <th scope="col">Status da Encomenda</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historico_encomendas as $encomendas): ?>
                    <tr>
                        <td><?= $encomendas->codigo_encomenda ?></td>
                        <td><?= $encomendas->data_encomenda ?></td>
                        <td><?= $encomendas->status ?></td>
                        <td><a href="?q=detalhe_encomenda&id=<?= Store::aesEncriptar($encomendas->id_encomenda) ?>"><i class="fa-solid fa-circle-info"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <div class="row >
            <p class=" text-center">Não existem encomendas registadas</p>
        </div>

    <?php endif; ?>


    <a href="?q=home" class="editarDadosBtn btn btn-success" id="editar">Voltar</a>



</section>