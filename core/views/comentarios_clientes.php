<section class="container-fluid" style="min-height: 650px; ">
    <h2 class="text-center">Comentários dos nosso clientes</h2>
    <div class="conatiner  text-center d-flex flex-column">
        <?php

        $init = 0;
        $total_pages = ceil($comentarios['total_comentarios'] / $comentarios['limit']);
        $previous = $comentarios['pagina'] - 1;
        $next = $comentarios['pagina'] + 1;

        //$total_pages = ceil(count());
        if (count($comentarios) ==  0): ?>
            <p>Não existem cometários dispovivéis.</p>
        <?php else: ?>
            <?php foreach ($comentarios['comentarios'] as $comentario): ?>
                <div class="row ">
                    <div class="col-12">
                        <!--box-->
                        <div class="box-cliente">
                            <!--profile-->
                            <div class="prefil-cliente">

                                <!--text-->
                                <div class="texto-prefil">
                                    <strong><?= $comentario->nome_completo ?></strong>

                                </div>
                            </div>

                            <!--Rating-->
                            <div class="classificacao">
                                <?php for ($i = 0; $i < $comentario->avaliacao; $i++): ?>
                                    <i class="fas fa-star"></i>

                                <?php endfor; ?>
                            </div>

                            <!--comments-->
                            <p><?= $comentario->comentario ?></p>
                        </div>
                    </div>
                </div>

            <?php $init++;
            endforeach; ?>
        <?php endif; ?>
    </div>
    <nav aria-label="..." class="justify-content-center mt-3">
        <ul class="pagination text-success">
            <?php if ($previous == 0): ?>
                <li class="page-item disabled">
                    <a class="page-link" href="?q=comentarios_clientes&page=<?= $previous ?>">Previous</a>
                </li>
            <?php else: ?>
                <li class="page-item " disabled>

                    <a class="page-link" href="?q=comentarios_clientes&page=<?= $previous ?>">Previous</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item"><a class="page-link" href="?q=comentarios_clientes&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <?php if ($total_pages == $next): ?>
                <li class="page-item">
                    <a class="page-link" href="?q=comentarios_clientes&page=<?= $next ?>">Next</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <a class="page-link" href="?q=comentarios_clientes&page=<?= $next ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php if (isset($_SESSION['cliente'])): ?>
        <hr>
        <div class="container my-5" style="max-width: 900px">
            <h5 class="text-center">Se gostou do nosso serviço deixe-nos o seu comentário.</h5>
            <div class="row comentarios-container">
                <form action="?q=comentarios_clientes_submit" method="post" id="frm-comentarios">
                    <div class="form-group">
                        <label for="">Rating</label>
                        <div id="rateYo"></div>
                    </div>
                    <div class="form-floating my-3">
                        <textarea class="form-control" name="comentario" id="cometario_cliente"></textarea>
                        <label for="comentario_cliente">Comentário</label>
                        <input type="hidden" name="rating" id="rating">
                    </div>
                    <input type="submit" value="Enviar" class="btn btn-success mb-5" id="enviar-comentario">
                </form>
            </div>
        </div>
    <?php endif; ?>
</section>