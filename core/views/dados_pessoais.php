<section class="dados-section">
    <h2>Os meus dados</h2>

    <!--<img src="<?= $user['imagem_path'] ?>" alt="Imagem de Perfil" class="imagem-perfil">-->

    <?php if (isset($_SESSION['sucesso'])): ?>
        <span class="sucesso mb-3" style="color: green; font-size: 0.8rem;">
            <?php echo $_SESSION['sucesso'];
            unset($_SESSION['sucesso']); ?></span>
    <?php endif; ?>
    <div class="container-lg">
        <?php foreach ($dados_cliente as $key => $value): ?>
            <div class="row mt-2">
                <div class="col-6 text-end"><strong><?= ucwords($key) ?>:</strong></div>
                <div class="col-6"><?= $value ?></div>
                <hr>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="?q=alterar_dados_pessoais" class="editarDadosBtn">Alterar Dados Pessoais</a>

</section>