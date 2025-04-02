<!-- Pesquisa de produtos -->
<section class="search-banner">

    <img src="./assets/img/bg-img-favicon/bg-1.png" class="bg-1" alt="bg">
    <img src="./assets/img/bg-img-favicon/bg-2.png" class="bg-2" alt="bg-2">

    <!--Text-->
    <div class="search-banner-text">
        <h1>Encomende as suas Compras</h1>
        <strong>#Entrega Grátis</strong>


        <!--search-box-->
        <form action="?q=pesquisa_produto" class="search-box" method="post">
            <!--search-icon-->
            <i class="fas fa-search"></i>
            <!--input-->
            <input type="text" class="search-input" placeholder="Pesquise o seu produto" name="search">
            <!--btn-->
            <input type="submit" class="search-btn" value="Search">
        </form>
        <?php if (isset($_SESSION['erro'])): ?>
            <span class="text-danger ms-3" style="font-size: .8rem;"><?= $_SESSION['erro'];
                                                                        unset($_SESSION['erro']) ?></span>
        <?php endif; ?>
    </div>
</section>
<!--categorias produtos-->
<section class="categorias">
    <!--heading-->
    <div class="categorias-heading">
        <h2>Categorias</h2>

    </div>
    <!--box-container-->
    <div class="categorias-container container-fluid ">
        <?php foreach ($categorias as $categoria): ?>
            <!--box-->
            <a href="?q=produtos&c=<?= $categoria->nome_categoria ?>" class="categorias-box me-2">
                <img src="./admin/<?= $categoria->imagem_categoria ?>" alt="<?= $categoria->nome_categoria ?>">
                <span><?= $categoria->nome_categoria ?></span>
            </a>
        <?php endforeach; ?>

    </div>
</section>
<!--Produtos-Populares-->
<section class="produtos-populares ">
    <!--heading-->
    <div class="produtos-heading">
        <h3>Os Nossos Produtos</h3>

    </div>
    <!--produtos-box-container-->
    <div class="produtos-container">
        <!--box-->
        <?php foreach ($produtos_home as $produto): ?>
            <div class="produtos-box">
                <img src="./admin/<?= $produto->imagem_produto ?>" alt="apple">
                <strong><?= $produto->nome_produto ?></strong>
                <span class="quantidade">1 Kg</span>
                <span class="preco"><?= number_format($produto->preco, 2, ',', '.') . '€' ?></span>
                <!--cart-btn--->
                <a onclick="adicionar_carrinho(<?= $produto->id_produto ?>)" class="cart-btn"><i class="fas fa-shopping-bag"></i>Add To Cart</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Clients-->

<section class="clientes">

    <!--heading-->
    <div class="clientes-heading">
        <h3>O que dizem os nossos clientes</h3>
    </div>

    <!--box-container-->

    <div class="box-cliente-container">
        <!--box-->
        <?php foreach ($comentarios_home as $comentario): ?>
            <div class="box-cliente">
                <!--profile-->
                <div class="prefil-cliente">

                    <!--text-->
                    <div class="texto-prefil">
                        <strong><?= $comentario->nome_cliente ?></strong>

                    </div>
                </div>

                <!--Rating-->
                <!--Rating-->
                <div class="classificacao">
                    <?php for ($i = 0; $i < $comentario->avaliacao; $i++): ?>
                        <i class="fas fa-star"></i>

                    <?php endfor; ?>
                </div>

                <!--comments-->
                <p><?= $comentario->comentario ?></p>
            </div>
        <?php endforeach; ?>


</section>

<!--Partnre-logo-->
<section class="parceiros">

    <!--heading-->
    <div class="parceiros-heading">
        <h3>Os nossos parceiros de confiança</h3>
    </div>

    <!--logo-container-->
    <div class="logo-container">
        <img src="./assets/img/parceiros/logo-1.png" alt="logo">
        <img src="./assets/img/parceiros/logo-2.png" alt="logo">
        <img src="./assets/img/parceiros/logo-3.png" alt="logo">
        <img src="./assets/img/parceiros/logo-4.png" alt="logo">
    </div>

</section>