<section class="registo-section">
    <h2>Registar como cliente</h2>

    <form method="post" class="registo-form" action="?q=submit_registo">

        <?php if (isset($_SESSION['erro'])): ?>
            <span class="error mb-3" style="color: red; font-size: 0.8rem">
                <?=
                $_SESSION['erro'];
                unset($_SESSION['erro']);
                ?>
            </span>
        <?php endif; ?>

        <div class="grupo-registo">
            <input type="text" id="nome" name="nome" required>
            <label for="nome">Nome:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="text" id="username" name="username" required>
            <label for="username">Username:</label>
        </div>

        <div class="grupo-registo">
            <input type="email" id="emailcliente" name="email" required>
            <label for="emailcliente">Email:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="password" id="passwordcliente" name="password" required>
            <label for="passwordcliente">Password:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="password" id="cpassword" name="cpassword" required>
            <label for="cpassword">Confirmar Password:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="tel" id="telefone" name="telefone" required>
            <label for="telefone">Telefone:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="text" id="morada" name="morada" required>
            <label for="morada">Morada:</label><br>
        </div>

        <div class="grupo-registo">
            <input type="text" id="localidade" name="localidade" required>
            <label for="localidade">Localidade:</label><br>
        </div>

        <div class="grupo-registo">
            <input type="text" id="cod-postal" name="cod-postal" required>
            <label for="cod-postal">Codigo Postal:</label><br>
        </div>

        <div class="grupo-registo">
            <input type="text" id="data_nascimento" name="data_nascimento" placeholder="aaaa-mm-dd">
            <label for="data_nascimento">Data de Nascimento:</label><br>
        </div>


        <div class="grupo-registo">
            <input type="text" id="nif" name="nif" required>
            <label for="nif">NIF:</label><br>
        </div>



        <label for="terms" class="terms-label"><input type="checkbox" id="terms" name="terms" required> Aceitar os Termos e Condições</label><br><br>
        <input type="submit" value="Registar" class="btn btn-success">
    </form>
</section>