<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use core\classes\Store;
?>
<section class="container-fluid">
    <div class="row mt-3 mb-5">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <?php
            if (isset($_SESSION['erro'])): ?>
                <span class="text-danger"><?= $_SESSION['erro'];
                                            unset($_SESSION['erro']) ?></span>
            <?php elseif (isset($_SESSION['sucesso'])): ?>
                <span class="text-success"><?= $_SESSION['sucesso'];
                                            unset($_SESSION['sucesso']) ?></span>
            <?php endif; ?>

            <div class="row">
                <div class="col">
                    <h3>DETALHE ENCOMENDA </h3><small><strong><?= $encomenda['dados_encomenda']->codigo_encomenda ?></strong></small>
                </div>
                <div class="col text-end">
                    <div class="text-center p-3 badge text-bg-success status-click" onclick="apresentarModal()"><?= $encomenda['dados_encomenda']->status ?></div>
                    <?php if ($encomenda['dados_encomenda']->status == 'EM PROCESSAMENTO'): ?>
                        <div class="m-1">
                            <a href="?q=criar_pdf_encomenda&e=<?= Store::aesEncriptar($encomenda['dados_encomenda']->id_encomenda) ?>" class="btn btn-success" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Criar pdf</a>
                            <a href="?q=enviar_pdf_encomenda&e=<?= Store::aesEncriptar($encomenda['dados_encomenda']->id_encomenda) ?>" class="btn btn-success" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Enviar pdf</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col">
                    <p><strong> Nome Cliente:</strong> <br> <?= $encomenda['dados_encomenda']->nome_completo ?></p>
                    <p><strong> Email:</strong> <br> <?= $encomenda['dados_encomenda']->email ?></p>
                    <p><strong> Telefone:</strong> <br> <?= $encomenda['dados_encomenda']->telefone ?></p>
                </div>
                <div class="col">
                    <p><strong> Data Encomenda:</strong> <br> <?= $encomenda['dados_encomenda']->data_encomenda ?></p>
                    <p><strong> Morada:</strong> <br> <?= $encomenda['dados_encomenda']->morada ?></p>
                    <p><strong> Localidade:</strong> <br> <?= $encomenda['dados_encomenda']->localidade ?></p>
                    <p><strong> Código Postal:</strong> <br> <?= $encomenda['dados_encomenda']->cod_postal ?></p>
                </div>
            </div>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th class="text-center">Quantidade</th>
                        <th class="text-end">Preco / uni.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($encomenda['produtos_encomenda'] as $produto): ?>
                        <tr>
                            <td><?= $produto->designacao_produto ?></td>
                            <td class="text-center"><?= $produto->quantidade ?></td>
                            <td class="text-end"><?= number_format($produto->preco_unidade, 2, ',', '.') . '€' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar estado da encomenda</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">


                <?php foreach (STATUS as $estado): ?>
                    <?php if ($encomenda['dados_encomenda']->status == $estado): ?>
                        <p><?= $estado ?></p>
                    <?php else: ?>
                        <p><a href="?q=encomenda_alterar_estado&id=<?= Store::aesEncriptar($encomenda['dados_encomenda']->id_encomenda) ?>&s=<?= $estado ?> "><?= $estado ?></a></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

            </div>
        </div>
    </div>
</div>