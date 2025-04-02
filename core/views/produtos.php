<section class="produtos-populares">
    <div class="nav-produtos">
        <?php if (isset($_SESSION['erro'])): ?>
            <span><?= $_SESSION['erro'];
                    unset($_SESSION['erro']); ?></span>
        <?php endif; ?>
        <a href="?q=produtos&c=todos" class="<?= $_GET['c'] == 'todos' ? 'nav-produtos-active' : '' ?>">Todos</a>
        <?php

        foreach ($categorias_produtos as $categoria): ?>
            <a href="?q=produtos&c=<?= $categoria ?>" class="<?= $_GET['c'] == $categoria ? 'nav-produtos-active' : '' ?>"><?= ucfirst($categoria) ?></a>
        <?php endforeach; ?>
    </div>

    <!--produtos-box-container-->
    <div class="produtos-container">
        <?php
        if (!empty($conteudo_produtos)):
            //ciclo de apresentação dos produtos
            foreach ($conteudo_produtos as $produto): ?>
                <!--box-->
                <div class="produtos-box">

                    <input type="hidden" name="id" value="<?= $produto->id_produto ?>">
                    <img src="./admin/<?= $produto->imagem_produto ?>" alt=" <?= $produto->nome_produto ?>">
                    <strong><?= $produto->nome_produto ?></strong>
                    <span class="quantidade">1Kg</span>
                    <span class="preco"><?= number_format($produto->preco, 2, ',', '.') . '€' ?></span>

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