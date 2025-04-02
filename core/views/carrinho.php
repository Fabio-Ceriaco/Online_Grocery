<section class="container mb-3" style="min-height: 700px;">
    <h2 class="text-center mt-5">A sua encomenda</h2>

    <?php if ($carrinho == null): ?>
        <div class="carrinho-conteudo ">
            <h5 class="mb-5">Carrinho vazio</h5>

            <a href="?q=produtos" class="voltar btn btn-success">Voltar</a>
        </div>
    <?php else: ?>

        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col"></th>
                    <th scope="col">Nome</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Valor Total</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                $index = 0;
                $total_rows = count($carrinho);

                ?>
                <?php foreach ($carrinho as $produto) : ?>
                    <?php if ($index < $total_rows - 1) : ?>
                        <!--Lista dos produtos-->
                        <tr>
                            <td class="text-start"><img class="img-fluid" style="width: 50px" src="./admin/<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>"></td>
                            <td class="text-center"><?= $produto['nome'] ?></td>
                            <td><?= $produto['quantidade'] ?></td>
                            <td><?= number_format($produto['preco'], 2, ',', '.') . '€' ?></td>
                            <td><a href="?q=remover_produto_carrinho&id_produto=<?= $produto['id_produto'] ?>" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i class="fas fa-times"></a></i></td>
                        </tr>
                    <?php else: ?>
                        <!--Total-->
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-end"><strong>Total:</strong></td>
                            <td><?= number_format($produto, 2, ',', '.') . "€" ?></td>
                            <td></td>
                        </tr>
                    <?php endif; ?>
                    <?php $index++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row ">
            <div class="col-4 text-center"><a href="?q=produtos" class="continuar btn btn-success">Continuar a comprar</a></div>
            <div class="col-4 text-center">
                <a href="?q=limpar_carrinho" class="limpar-carrinho btn btn-success">Limpar Carrinho</a>
            </div>
            <div class="col-4 text-center"><a href="?q=finalizar_encomenda" class="finalizar btn btn-success">Finalizar Encomenda</a></div>
        </div>
    <?php endif; ?>

</section>