<section class="container">
    <div class="row my-5">
        <div class="col-sm-4 offset-sm-4">
            <div>
                <h3 class="text-center"> LOGIN DE ADMIN</h3>
                <?php if (isset($_SESSION['erro'])): ?>
                    <span class="error" style="color: red"><?php echo $_SESSION['erro'];
                                                            unset($_SESSION['erro']); ?></span>
                <?php endif; ?>
                <form action="?q=admin_login_submit" method="post">
                    <div class="mb-3">
                        <label for="admin_email" class="form-label">Administrador: </label>
                        <input type="email" class="form-control" name="admin_email" id="admin_email" placeholder="E-mail">
                    </div>
                    <div class="mb-3">
                        <label for="admin_password" class="form-label">Password: </label>
                        <input type="password" class="form-control" name="admin_password" id="admin_password"" placeholder=" Password">
                    </div>
                    <div class="mb-3 text-center ">
                        <input type="submit" value="Entrar" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>

    </div>

</section>