<?php

use core\classes\Store;
?>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <h3>Lista clientes</h3>
            <hr>
            <?php if (count($lista_clientes) == 0): ?>
                <hr>
                <p>Não existem clientes registados.</p>
                <hr>
            <?php else: ?>
                <small>
                    <table class=" table table-striped table-sm" id="tabela_clientes">
                        <thead class="table-dark ">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Encomendas</th>
                                <th class="text-end">Ativo</th>
                                <th class="text-end">Eliminado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_clientes as $cliente): ?>
                                <tr>
                                    <td><a href="?q=detalhes_cliente&id=<?= Store::aesEncriptar($cliente->id_cliente) ?>"><?= $cliente->nome_completo ?></a></td>
                                    <td><?= $cliente->email ?></td>
                                    <td><?= $cliente->telefone ?></td>
                                    <td class="text-center">
                                        <?php if ($cliente->total_encomendas == 0): ?>
                                            <span class="text-danger"><?= $cliente->total_encomendas ?></span>
                                        <?php else: ?>
                                            <a href="?q=lista_encomendas&c=<?= Store::aesEncriptar($cliente->id_cliente) ?>" class=" text-success" style="text-decoration: none"><?= $cliente->total_encomendas ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php if ($cliente->ativo == 1): ?>
                                            <a href="?q=desativar_cliente&id=<?= Store::aesEncriptar($cliente->id_cliente) ?>"><i class="fa-solid fa-circle-check" style="color: green"></i></a>
                                        <?php else: ?>
                                            <a href="?q=ativar_cliente&id=<?= Store::aesEncriptar($cliente->id_cliente) ?>"><i class="fa-solid fa-circle-xmark" style="color: red"></i></a>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center"><?php if ($cliente->deleted_at != null): ?>
                                            <?= $cliente->deleted_at ?>
                                        <?php else: ?>
                                            <span>-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <small>
                    <?php endif; ?>
        </div>
    </div>
</section>