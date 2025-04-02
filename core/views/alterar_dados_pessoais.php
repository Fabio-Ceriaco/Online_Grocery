<section class="registo-section">
    <h2>Alterar dados pessoais</h2>


    <?php if (isset($_SESSION['erro'])): ?>
        <span class="error mb-3" style="color: red; font-size: 0.8rem">
            <?php echo $_SESSION['erro'];
            unset($_SESSION['erro']); ?></span>
    <?php endif; ?>


    <form method="post" class="registo-form" action="?q=alterar_dados_pessoais_submit">

        <div class="grupo-registo">
            <input type="text" maxlength="50" id="nome_completo" name="nome_completo" value="<?= $dados_pessoais->nome_completo ?>" required>
            <label for="nome_completo">Nome:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="text" id="username" maxlength="50" name="username" value="<?= $dados_pessoais->username ?>" required>
            <label for="username">Username:</label>
        </div>

        <div class="grupo-registo">
            <input type="text" id="emailcliente" maxlength="100" name="email" value="<?= $dados_pessoais->email ?>" required>
            <label for="emailcliente">Email:</label><br>
        </div>

        <div class="grupo-registo">
            <input type="text" id="morada" maxlength="100" name="morada" value="<?= $dados_pessoais->morada ?>" required>
            <label for="morada">Morada:</label><br>
        </div>

        <div class="grupo-registo">
            <input type="text" id="localidade" maxlength="50" name="localidade" value="<?= $dados_pessoais->localidade ?>" required>
            <label for="localidade">Localidade:</label><br>
        </div>

        <div class="grupo-registo">
            <input type="text" id="cod-postal" maxlength="10" name="cod-postal" value="<?= $dados_pessoais->cod_postal ?>" required>
            <label for="cod-postal">Codigo Postal:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="tel" id="telefone" maxlength="14" name="telefone" value="<?= $dados_pessoais->telefone ?>" required>
            <label for="telefone">Telefone:</label><br>
        </div>

        <div class="grupo-registo">
            <input type="text" id="data_nascimento" maxlength="10" name="data_nascimento" value="<?= $dados_pessoais->data_nascimento ?>" required>
            <label for="data_nascimento">Data de Nascimento:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="text" id="nif" name="nif" maxlength="10" value="<?= $dados_pessoais->nif ?>" required>
            <label for="nif">NIF:</label><br>
        </div>


        <div class="row">
            <div class="col-sm-6"><input type="submit" class="editarDadosBtn" value="Alterar Password"></div>
            <div class="col-sm-6"><a href="?q=dados_pessoais" class="editarDadosBtn btn btn-success">Cancelar</a></div>
        </div>


    </form>
</section>