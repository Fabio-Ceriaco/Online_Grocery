<section class="container-fluid">
    <h2 class="text-center">A sua encomenda - resumo</h2>


    <div class="container mt-4 encomenda-resumo">
        <table class="table table-striped">
            <thead class="table-dark ">
                <tr>

                    <th class="text-start">Nome</th>
                    <th class="text-center">Quantidade</th>
                    <th class="text-end">Preço/uni.</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                $total_rows = count($carrinho); ?>
                <?php foreach ($carrinho as $produto) : ?>
                    <?php if ($index < $total_rows - 1) : ?>
                        <!--Lista dos produtos-->
                        <tr>
                            <td class="text-start"><?= $produto['nome'] ?></td>
                            <td class="text-center"><?= $produto['quantidade'] ?></td>
                            <td class="text-end"><?= number_format($produto['preco'], 2, ',', '.') . '€' ?></td>
                        </tr>
                    <?php else: ?>
                        <!--Total-->
                        <tr class="text-end">
                            <td></td>
                            <td></td>
                            <td><strong>Total : </strong><?= number_format($produto, 2, ',', '.') . "€" ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php $index++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-4">
            <h4 class="text-center">Dados do Cliente</h4>
            <hr>
            <div class="text-start">

                <p><strong>Nome :</strong><?= $cliente->nome_completo ?> </p>
                <p><strong>Morada :</strong><?= $cliente->morada ?> </p>
                <p><strong>Localidade :</strong><?= $cliente->localidade ?> </p>
                <p><strong>Código Postal :</strong> <?= $cliente->cod_postal ?> </p>
                <p><strong>Telefone :</strong> <?= $cliente->telefone ?></p>
                <p><strong>E-mail :</strong> <?= $cliente->email ?> </p>
                <p><strong>NIF :</strong> <?= $cliente->nif ?></p>

            </div>

        </div>
        <!-- Dados de Pagamento-->

        <div class="mt-4">
            <h4 class="text-center">Dados de Pagamento</h4>
            <hr>
            <div>
                <p>Conta bancária: 1234567890</p>
                <p>Código da encomenda: <strong><?= $_SESSION['codigo_encomenda'] ?></strong></p>
                <p>Total : <strong><?= number_format($_SESSION['total_encomenda'], 2, ',', '.') . "€" ?></strong></p>
            </div>
        </div>

        <div class="mt-4 text-center">
            <h5>Morada alternativa de entrega</h5>
            <hr>

            <input type="checkbox" name="check_morada_alternativa" onchange="usar_morada_alternativa()" id="check_morada_alternativa" class="form-check-input">
            <label for="check_morada_alternativa" class="form-check-label">Definir uma morada alternativa</label>


        </div>
        <div id="morada_alternativa" class="mt-3">

            <div class="row ">
                <div class="grupo-alt">
                    <input type="text" name="nova_morada" id="nova_morada" class="form-control">
                    <label for="nova_morada" class="form-label">Morada:</label>
                </div>
                <div class="grupo-alt">
                    <input type="text" name="nova_localidade" id="nova_localidade" class="form-control">
                    <label for="nova_localidade" class="form-label">Localidade:</label>
                </div>
                <div class="grupo-alt">
                    <input type="text" name="novo_codPostal" id="novo_codPostal" class="form-control">
                    <label for="novo_codPostal" class="form-label">Codigo Postal:</label>
                </div>
                <div class="grupo-alt">
                    <input type="text" name="novo_email" id="novo_email" class="form-control">
                    <label for="novo_email" class="form-label">Email:</label>
                </div>
                <div class="grupo-alt">
                    <input type="text" name="novo_telefone" id="novo_telefone" class="form-control">
                    <label for="novo_telefone" class="form-label">Telefone:</label>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-6 text-start">
                <a href="?q=carrinho" class="continuar btn btn-success">Cancelar</a>
            </div>
            <div class="col-6 text-end">
                <a href="?q=confirmar_encomenda" onclick="morada_alternativa()" class="finalizar btn btn-success">Comprar</a>
            </div>
        </div>
    </div>
</section>