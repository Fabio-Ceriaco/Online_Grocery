<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php require(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <!--apresenta informação sobre as encomendas PENDENTES -->
            <h4>Encomendas Pendentes</h4>
            <?php if ($total_encomendas_pendentes != 0): ?>
                <div class="alert alert-warning p-2 mt-2">
                    <span class="me-3">Existem encomendas PENDENTES: <strong><?= $total_encomendas_pendentes ?></strong></span>
                    <a href="?q=lista_encomendas&f=pendente">Ver</a>
                </div>
            <?php else: ?>

                <span class="text-muted">Não existem encomendas PENDENTES </span>

            <?php endif; ?>
            <hr>
            <!--apresenta informação sobre as encomendas EM PROCESSAMENTO -->
            <h4>Encomendas em Processamento</h4>
            <?php if ($total_encomendas_em_processamento != 0): ?>
                <div class="alert alert-info p-2  mt-2">
                    <span class="me-3">Existem encomendas EM PROCESSAMENTO: <strong><?= $total_encomendas_em_processamento ?></strong></span>
                    <a href="?q=lista_encomendas&f=em_processamento">Ver</a>
                </div>
            <?php else: ?>

                <span class="text-muted">Não existem encomendas EM PROCESSAMENTO </span>

            <?php endif; ?>
            <hr>
            <!--apresenta informação sobre as encomendas EM PROCESSAMENTO -->
            <h4>Encomendas enviadas</h4>
            <?php if ($total_encomendas_enviadas != 0): ?>
                <div class="alert alert-primary p-2  mt-2">
                    <span class="me-3">Existem encomendas ENVIADAS: <strong><?= $total_encomendas_enviadas ?></strong></span>
                    <a href="?q=lista_encomendas&f=enviada">Ver</a>
                </div>
            <?php else: ?>

                <span class="text-muted">Não existem encomendas ENVIADAS </span>

            <?php endif; ?>
            <hr>
            <!--apresenta informação sobre as encomendas EM PROCESSAMENTO -->
            <h4>Encomendas canceladas</h4>
            <?php if ($total_encomendas_canceladas != 0): ?>
                <div class="alert alert-danger p-2  mt-2">
                    <span class="me-3">Existem encomendas CANCELADAS: <strong><?= $total_encomendas_canceladas ?></strong></span>
                    <a href="?q=lista_encomendas&f=cancelada">Ver</a>
                </div>
            <?php else: ?>

                <span class="text-muted">Não existem encomendas CANCELADAS </span>

            <?php endif; ?>
            <hr>
            <!--apresenta informação sobre as encomendas EM PROCESSAMENTO -->
            <h4>Encomendas entregues</h4>
            <?php if ($total_encomendas_entregues != 0): ?>
                <div class="alert alert-success p-2  mt-2">
                    <span class="me-3">Existem encomendas ENTREGUES: <strong><?= $total_encomendas_entregues ?></strong></span>
                    <a href="?q=lista_encomendas&f=entregue">Ver</a>
                </div>
            <?php else: ?>

                <span class="text-muted">Não existem encomendas ENTREGUES </span>

            <?php endif; ?>
        </div>
    </div>

</section>