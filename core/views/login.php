<section class="login-section">
    <div class="login-box">
        <a href="?=home"><i class="fas fa-times" id="closeLogin"></i></a>
        <br>
        <h3>Login</h3>
        <br>
        <?php if (isset($_SESSION['erro'])): ?>
            <span class="error mb-3" style="color: red; font-size: 0.8rem"><?php echo $_SESSION['erro'];
                                                                            unset($_SESSION['erro']); ?></span>


        <?php endif; ?>
        <form method="post" action="?q=login_submit">

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <a href="?q=recuperar_password">Recuperação de password</a>
            <p>Ainda não possui uma conta? <a href="?q=registar">Crie uma agora</a></p>
            <input type="submit" id="submitlogin" value="Entrar">
        </form>

    </div>
</section>
<!-- Pesquisa de produtos -->
<section class="search-banner">
    <!--bg-->
    <img src="./assets/img/bg-img-favicon/bg-1.png" class="bg-1" alt="bg">
    <img src="./assets/img/bg-img-favicon/bg-2.png" class="bg-2" alt="bg-2">

    <!--Text-->
    <div class="search-banner-text">
        <h1>Encomende as suas Compras</h1>
        <strong>#Entrega Grátis</strong>


        <!--search-box-->
        <form action="" class="search-box">
            <!--search-icon-->
            <i class="fas fa-search"></i>
            <!--input-->
            <input type="text" class="search-input" placeholder="Pesquise o seu produto" name="search" required>
            <!--btn-->
            <input type="submit" class="search-btn" value="Search">
        </form>
    </div>
</section>
<!--categorias produtos-->
<section class="categorias">
    <!--heading-->
    <div class="categorias-heading">
        <h2>Categorias</h2>

    </div>
    <!--box-container-->
    <div class="categorias-container">
        <!--box-->
        <a href="#" class="categorias-box">
            <img src="./assets/img/categorias/fish.png" alt="fish">
            <span>Peixe & Carne</span>
        </a>
        <!--box-->
        <a href="#" class="categorias-box">
            <img src="./assets/img/categorias/Vegetables.png" alt="fish">
            <span>Peixe & Carne</span>
        </a>
        <!--box-->
        <a href="#" class="categorias-box">
            <img src="./assets/img/categorias/medicine.png" alt="fish">
            <span>Peixe & Carne</span>
        </a>
        <!--box-->
        <a href="#" class="categorias-box">
            <img src="./assets/img/categorias/baby.png" alt="fish">
            <span>Peixe & Carne</span>
        </a>
        <!--box-->
        <a href="#" class="categorias-box">
            <img src="./assets/img/categorias/office.png" alt="fish">
            <span>Peixe & Carne</span>
        </a>
        <!--box-->
        <a href="#" class="categorias-box">
            <img src="./assets/img/categorias/beauty.png" alt="fish">
            <span>Peixe & Carne</span>
        </a>
        <!--box-->
        <a href="#" class="categorias-box">
            <img src="./assets/img/categorias/gardening.png" alt="fish">
            <span>Peixe & Carne</span>
        </a>
    </div>
</section>
<!--Produtos-Populares-->
<section class="produtos-populares">
    <!--heading-->
    <div class="produtos-heading">
        <h3>Produtos Populares</h3>

    </div>
    <!--produtos-box-container-->
    <div class="produtos-container">
        <!--box-->
        <div class="produtos-box">
            <img src="./assets/img/produtos/apple.png" alt="apple">
            <strong>Apple</strong>
            <span class="quantidade">1 Kg</span>
            <span class="preco">2€</span>
            <!--cart-btn--->
            <a href="#" class="cart-btn"><i class="fas fa-shopping-bag"></i>Add To Cart</a>
        </div>
        <!--box-->
        <div class="produtos-box">
            <img src="./assets/img/produtos/chili.png" alt="chili">
            <strong>Chili</strong>
            <span class="quantidade">1 Kg</span>
            <span class="preco">2€</span>
            <!--cart-btn--->
            <a href="#" class="cart-btn"><i class="fas fa-shopping-bag"></i>Add To Cart</a>
        </div>
        <!--box-->
        <div class="produtos-box">
            <img src="./assets/img/produtos/onion.png" alt="onion">
            <strong>Onion</strong>
            <span class="quantidade">1 Kg</span>
            <span class="preco">2€</span>
            <!--cart-btn--->
            <a href="#" class="cart-btn"><i class="fas fa-shopping-bag"></i>Add To Cart</a>
        </div>
        <!--box-->
        <div class="produtos-box">
            <img src="./assets/img/produtos/patato.png" alt="patato">
            <strong>Patato</strong>
            <span class="quantidade">1 Kg</span>
            <span class="preco">2€</span>
            <!--cart-btn--->
            <a href="#" class="cart-btn"><i class="fas fa-shopping-bag"></i>Add To Cart</a>
        </div>
        <!--box-->
        <div class="produtos-box">
            <img src="./assets/img/produtos/garlic.png" alt="garlic">
            <strong>Garlic</strong>
            <span class="quantidade">1 Kg</span>
            <span class="preco">2€</span>
            <!--cart-btn--->
            <a href="#" class="cart-btn"><i class="fas fa-shopping-bag"></i>Add To Cart</a>
        </div>
        <!--box-->
        <div class="produtos-box">
            <img src="./assets/img/produtos/tamato.png" alt="tamato">
            <strong>Tamato</strong>
            <span class="quantidade">1 Kg</span>
            <span class="preco">2€</span>
            <!--cart-btn--->
            <a href="#" class="cart-btn"><i class="fas fa-shopping-bag"></i>Add To Cart</a>
        </div>

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
        <div class="box-cliente">
            <!--profile-->
            <div class="prefil-cliente">
                <!--Img-->
                <img src="./assets/img/clientes/client-1.jpg" alt="client">
                <!--text-->
                <div class="texto-prefil">
                    <strong>James Mcavoy</strong>
                    <span>CEO</span>
                </div>
            </div>

            <!--Rating-->
            <div class="classificacao">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>

            <!--comments-->
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quam hic iure earum atque vero odit iste dolore tenetur, magnam excepturi unde, rem aperiam aut at perferendis. Incidunt minus dolorum hic?</p>
        </div>
        <!--box-->
        <div class="box-cliente">
            <!--profile-->
            <div class="prefil-cliente">
                <!--Img-->
                <img src="./assets/img/clientes/client-2.jpg" alt="client">
                <!--text-->
                <div class="texto-prefil">
                    <strong>James Mcavoy</strong>
                    <span>CEO</span>
                </div>
            </div>

            <!--Rating-->
            <div class="classificacao">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>

            <!--comments-->
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quam hic iure earum atque vero odit iste dolore tenetur, magnam excepturi unde, rem aperiam aut at perferendis. Incidunt minus dolorum hic?</p>
        </div>
        <!--box-->
        <div class="box-cliente">
            <!--profile-->
            <div class="prefil-cliente">
                <!--Img-->
                <img src="./assets/img/clientes/client-3.jpg" alt="client">
                <!--text-->
                <div class="texto-prefil">
                    <strong>James Mcavoy</strong>
                    <span>CEO</span>
                </div>
            </div>

            <!--Rating-->
            <div class="classificacao">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>

            <!--comments-->
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quam hic iure earum atque vero odit iste dolore tenetur, magnam excepturi unde, rem aperiam aut at perferendis. Incidunt minus dolorum hic?</p>
        </div>
    </div>


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