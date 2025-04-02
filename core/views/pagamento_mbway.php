<?php

use core\classes\Store;

?>

<section class="container-fluid">

    <div class="container text-center" style="min-height: 700px; max-width: 300px">
        <img class="img-thumbnail mt-3" src="./assets/img/formas_pagamento/mbway.png" style="width: 70px; height: 70px" alt="mbway">
        <form action="?q=pagamento_mbway_submit" method="post" class="mt-5">

            <input type="hidden" name="codigo_encomenda" value="<?= Store::aesEncriptar($codigo_encomenda) ?>">
            <label for="contacto" class="form-label">Por favor introduza o seu contacto movél.</label>
            <input class="form-control mt-3" type="text" id="contacto" name="contacto" placeholder="nº movél">
            <input type="submit" class="btn btn-success mt-3" value="Pagar">

        </form>
    </div>

</section>