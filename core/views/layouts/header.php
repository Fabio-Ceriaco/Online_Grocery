 <?php

    use core\classes\Store;



    $total_produtos = 0;
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $quantidade) {
            $total_produtos += $quantidade;
        }
    }
    ?>
 <nav>
     <!--Logo-->
     <a href="?q=home" class="logo">
         <span>M</span>ercearia
     </a>
     <!--navBar-btn-->
     <input type="checkbox" class="navBar-btn" id="navBar-btn">
     <label for="navBar-btn" class="navBar-icon">
         <span class="nav-icon"></span>
     </label>
     <!--Menu de navegação-->
     <ul class="nav-Bar" id="navBar">
         <li><a href="?q=home" class="<?= $_GET['q'] == 'home' ? 'active' : '' ?>">Home</a></li>
         <li><a href="?q=produtos" class="<?= $_GET['q'] == 'produtos' ? 'active' : '' ?>">Produtos</a></li>
         <li><a href="?q=comentarios_clientes&page=1" class="<?= $_GET['q'] == 'comentarios_clientes' ? 'active' : '' ?>">Comentários</a></li>

     </ul>

     <!--cart-->
     <div class="cart">
         <a href="?q=carrinho" class="cart"><i class="fa-solid fa-cart-shopping"></i><span id="count"><?= $total_produtos ?></span>

     </div>

     <!-- verifica se existe cliente na sessão -->
     <?php if (Store::clienteLogado(true)): ?>
         <div class="user-info">
             <a href="#" class="user-info-btn">
                 <span> <i class="fa-solid fa-user"></i><?= $_SESSION['username'] ?></span>
             </a>
             <!--<a href="./pages/logs/logout.php"></a>-->
         </div>
         <div class="area-cliente">
             <h2>Area Cliente</h2>
             <a href="?q=dados_pessoais" class="cliente-info"><i class="fa-solid fa-user-pen"></i>Dados Pessoais</a>
             <a href="?q=alterar_password" class="cliente-info"><i class="fa-solid fa-lock"></i>Alterar a password</a>
             <a href="?q=historico_encomendas" class="cliente-info"><i class="fa-solid fa-boxes-stacked"></i>Encomendas</a>
             <a href="?q=logout" class="cliente-info"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
         </div>

     <?php else: ?>
         <div class="login">
             <a href="?q=login" class="log-btn">Login</a>
         </div>
     <?php endif; ?>

 </nav>