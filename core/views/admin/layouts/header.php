 <?php

    use core\classes\Store;

    ?>

 <section class="container-fluid navegacao">
     <div class="row">
         <div class="col-6 p-3">
             <!--Logo-->
             <a href="?q=home" class="logo" id="logo">
                 <span>M</span>ercearia
             </a>
         </div>
         <div class="col-6 p-3 text-end align-self-center">
             <?php if (Store::adminLogado()): ?>
                 <span class="me-3"><i class="fa-solid fa-user-tie me-2"></i><?= $_SESSION['admin_email'] ?></span>
                 <a href="?q=admin_logout" class="btn btn-success">Logout</a>
             <?php endif; ?>
         </div>
     </div>

 </section>