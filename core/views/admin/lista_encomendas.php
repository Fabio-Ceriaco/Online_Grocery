<?php

use core\classes\Store;
?>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <h3>Lista de encomendas <?= $filtro != '' ? $filtro : '' ?></h3>
            <hr>
            <div class="d-inline-flex align-items-center ">
                <div>
                    <a href="?q=lista_encomendas" class="btn btn-success ">Ver todas as encomendas</a>
                </div>
                <!--processo de selected da tag select-->
                <?php
                $f = '';
                if (isset($_GET['f'])) {
                    $f = $_GET['f'];
                } ?>
                <div>
                    <select id="select-status" class="form-select ms-3" onchange="definir_filtro()">
                        <option <?= $f == '' ? 'selected' : '' ?>>Estado das encomendas:</option>
                        <option value="pendente" <?= $f == 'pendente' ? 'selected' : '' ?>>Pendentes</option>
                        <option value="em_processamento" <?= $f == 'em_processamento' ? 'selected' : '' ?>>Em processamento</option>
                        <option value="enviada" <?= $f == 'enviada' ? 'selected' : '' ?>>Enviadas</option>
                        <option value="cancelada" <?= $f == 'cancelada' ? 'selected' : '' ?>>Canceladas</option>
                        <option value="entregue" <?= $f == 'entregue' ? 'selected' : '' ?>>Entregues</option>
                    </select>
                </div>
            </div>
            <hr>

            <?php if (count($lista_encomendas) == 0): ?>
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
                                <th>Nome Cliente</th>
                                <th>Email Cliente</th>
                                <th>Telefone Cliente</th>
                                <th>Status</th>
                                <th>Atualizado em</th>
                            </tr>
                        </thead>
                        <tbody class=" text-center">
                            <?php foreach ($lista_encomendas as $encomenda): ?>
                                <tr>
                                    <td><strong><?= $encomenda->codigo_encomenda ?></strong></td>
                                    <td><?= substr($encomenda->data_encomenda, 0, 10) ?></td>
                                    <td><?= $encomenda->nome_completo ?></td>
                                    <td><?= $encomenda->email ?></td>
                                    <td><?= $encomenda->telefone ?></td>
                                    <td><a href="?q=detalhe_encomenda&id=<?= Store::aesEncriptar($encomenda->id_encomenda) ?>"><?= $encomenda->status ?></td></a>
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
<script>

</script>