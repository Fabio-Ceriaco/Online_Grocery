<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use core\classes\Store;
?>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <h3>Detalhes do cliente</h3>
            <hr>
            <div class="row mt-3">
                <div class="col-3 text-end fw-bold">
                    Nome Completo:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->nome_completo ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Morada:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->morada ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Localidade:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->localidade ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Código Postal:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->cod_postal ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Telefone:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->telefone ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Email:
                </div>
                <div class="col-9">
                    <a href="mailto:<?= $detalhes_cliente->email ?>"><?= $detalhes_cliente->email ?></a>
                </div>
                <div class="col-3 text-end fw-bold">
                    Data de Nascimento:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->data_nascimento ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Nº Fiscal:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->nif ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Estado:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->ativo ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>' ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Cliente desde:
                </div>
                <div class="col-9">
                    <?= substr($detalhes_cliente->created_at, 0, 10) ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Ultima atualização:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->updated_at ?>
                </div>
                <div class="col-3 text-end fw-bold">
                    Eliminado em:
                </div>
                <div class="col-9">
                    <?= $detalhes_cliente->deleted_at ? $detalhes_cliente->deleted_at : '-' ?>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col text-center">
                    <?php if ($total_encomendas == 0): ?>
                        <p class="text-muted">Não existem encomendas deste cliente.</p>
                    <?php else: ?>
                        <a href="?q=cliente_historico_encomendas&id=<?= Store::aesEncriptar($detalhes_cliente->id_cliente) ?>" class="btn btn-success">Ver encomendas do cliente</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>
</section>