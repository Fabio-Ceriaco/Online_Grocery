<section class="container-fluid">
    <div class="container" style="min-height: 650px;">
        <h4 class="mt-3 text-center">Dados da Encomenda</h4>
        <hr style="height: 3px; background-color: #000;">
        <div class="row">
            <p>Código Encomenda : <strong><?= $dados_encomenda['dados_encomenda']->codigo_encomenda ?></strong></p>
            <hr>
            <p>Status : <strong><?= $dados_encomenda['dados_encomenda']->status ?></strong></p>
            <hr>
            <p>Data da Encomenda : <strong><?= substr($dados_encomenda['dados_encomenda']->data_encomenda, 0, 10)  ?></strong></p>
            <hr>

        </div>
        <h5 class="text-center mt-3">Produtos da Encomenda</h5>
        <table class="table table-striped mt-3">
            <thead class="table-dark justify-content-center">
                <tr>
                    <th class="text-start">Designação Produto</th>
                    <th class="text-center">Quantidade</th>
                    <th class="text-end">Preço Unitário</th>
                </tr>
            </thead>
            <tbody>
                <?php

                use core\classes\Store;

                foreach ($dados_encomenda['produtos_encomenda'] as $produtos): ?>
                    <tr>
                        <td class="text-start"><?= $produtos->designacao_produto ?></td>
                        <td class="text-center"><?= $produtos->quantidade ?></td>
                        <td class="text-end"><?= number_format($produtos->preco_unidade, 2, ',', '.') . ' €' ?></td>
                    </tr>

                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-end"><strong>Total : <?= number_format($total_encomenda, 2, ',', '.') . ' €' ?></strong></td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <h2 class="text-center">Formas de Pagamento</h2>
        </div>
        <div class="row">
            <div class="col-6 text-end"><a href="?q=pagamento_tranferencia&codigo=<?= Store::aesEncriptar($dados_encomenda['dados_encomenda']->codigo_encomenda) ?>"><img class="img-thumbnail" style="width: 70px; height: 70px" src="./assets/img/formas_pagamento/transferencia_bancaria.webp" alt="tranferencia"></a></div>
            <div class="col-6 text-start"><a href="?q=pagamento_mbway&codigo=<?= Store::aesEncriptar($dados_encomenda['dados_encomenda']->codigo_encomenda) ?>"><img class="img-thumbnail" style="width: 70px; height: 70px" src="./assets/img/formas_pagamento/mbway.png" alt="mbway"></a></div>
        </div>

    </div>
</section>