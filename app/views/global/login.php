<section class="d-flex justify-content-center p-3">
    <div class="card" style="width: 18rem;">
        <a href="/login">
            <img src="assets/img/image-login.jpg" class="card-img-top" alt="Imagem de ferramentas de uma barbearia">
        </a>
        <div class="card-body card d-flex justify-content-center">
            <h4 class="card-title text-center">Login - Admin</h4>
            <form action="/login/store" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Digite aqui o seu e-mail" name="email">
                    <?php echo message("email"); ?>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Digite aqui a sua senha" name="password">
                    <?php echo message("password"); ?>
                </div>
            </form>
            <a href="/login/store" class="btn btn-primary">Logar</a>
        </div>
    </div>
</section>