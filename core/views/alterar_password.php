<section class="registo-section">
    <h2>Alterar password</h2>

    <form method="post" enctype="multipart/form-data" id="registoForm" class="registo-form" action="?q=alterar_password_submit">

        <?php if (isset($_SESSION['erro'])): ?>
            <span class="error mb-3" style="color: red; font-size: 0.8rem"><?php echo $_SESSION['erro'];
                                                                            unset($_SESSION['erro']); ?></span>
        <?php endif; ?>

        <div class="grupo-registo">
            <input type="password" maxlength="32" id="password_atual" name="password_atual" required>
            <label for="password_atual">Password:</label><br>
            <span class="errorRegisto" id="passwordError"></span>
        </div>

        <div class="grupo-registo">
            <input type="password" maxlength="32" id="nova_password" name="nova_password" required>
            <label for="nova_password">Password:</label><br>
            <span class="errorRegisto" id="passwordError"></span>
        </div>


        <div class="grupo-registo">
            <input type="password" maxlength="32" id="confirmar_password" name="confirmar_password" required>
            <label for="confirmar_password">Confirmar Password:</label><br>
            <span class="errorRegisto" id="cpasswordError"></span>
        </div>
        <div class="row">
            <div class="col-sm-6"><input type="submit" class="editarDadosBtn" value="Alterar Password"></div>
            <div class="col-sm-6"><a href="?q=home" class="editarDadosBtn btn btn-success">Cancelar</a></div>
        </div>


    </form>
</section>