<section class="container-fluid" style="max-width: 700px;">
    <h2 class="text-center mt-3">Detalhes da Encomenda</h2>

    <h4 class="mt-3">Dados da Encomenda</h4>
    <hr style="height: 3px; background-color: #000;">
    <div class="row">
        <p>Código Encomenda : <strong><?= $dados_encomenda->codigo_encomenda ?></strong></p>
        <hr>
        <p>Status : <strong><?= $dados_encomenda->status ?></strong></p>
        <hr>
        <p>Data da Encomenda : <strong><?= substr($dados_encomenda->data_encomenda, 0, 10)  ?></strong></p>
        <hr>
        <p>Morada : <strong><?= $dados_encomenda->morada ?></strong></p>
        <hr>
        <p>Localidade : <strong><?= $dados_encomenda->localidade ?></strong></p>
        <hr>
        <p>Código Postal : <strong><?= $dados_encomenda->cod_postal ?></strong></p>
        <hr>
        <p>Telefone : <strong><?= $dados_encomenda->telefone ? $dados_encomenda->telefone : '&nbsp;' ?></strong></p>
        <hr>
    </div>
    <h5 class="text-center mt-3">Produtos da Encomenda</h5>
    <table class="table table-striped">
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

            foreach ($produtos_encomenda as $produtos): ?>
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
    <div class="row my-4">
        <div class="col-6"><a href="?q=historico_produtos" class="btn btn-success">Voltar</a></div>
        <?php if ($dados_encomenda->status == 'PENDENTE'): ?>
            <div class="col-6 text-end"><a href="?q=formas_pagamento&id=<?= Store::aesEncriptar($dados_encomenda->id_encomenda) ?>" class="btn btn-success">Pagar Encomenda</a></div>
        <?php endif; ?>

    </div>
</section>