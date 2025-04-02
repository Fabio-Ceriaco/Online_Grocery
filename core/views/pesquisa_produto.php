<!--Produtos-Populares-->
<section class="produtos-populares">
    <!--heading-->
    <div class="produtos-heading">
        <h3>Produtos</h3>

    </div>
    <!--produtos-box-container-->
    <div class="produtos-container">
        <?php
        if (!empty($pesquisa)):
            //ciclo de apresentação dos produtos
            foreach ($pesquisa as $produto): ?>
                <!--box-->
                <div class="produtos-box">

                    <input type="hidden" name="id" value="<?= $produto->id_produto ?>">
                    <img src="./admin/<?= $produto->imagem_produto ?>" alt="<?= $produto->nome_produto ?>">
                    <strong><?= $produto->nome_produto ?></strong>
                    <span class="quantidade">1Kg</span>
                    <span class="preco"><?= preg_replace("/\./", ",", $produto->preco) . '€' ?></span>

                    <!--cart-btn--->
                    <?php if ($produto->stock > 0): ?>
                        <a onclick="adicionar_carrinho(<?= $produto->id_produto ?>)" class="cart-btn"><i class="fas fa-shopping-bag"></i>Add To Cart</a>
                    <?php else: ?>
                        <a class="cart-btn" style="pointer-events: none; "><i class="fas fa-shopping-bag"></i>Sem stock</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Não existem produtos disponivéis</p>
        <?php endif; ?>
    </div>
</section>