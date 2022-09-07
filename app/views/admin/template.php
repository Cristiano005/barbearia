<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {$title} </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-light bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand text-light" href="/admin/home/clients">Painel Admin.</a>
                <button class="navbar-toggler bg-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Perfil</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <p class="fw-bold"> Nome: <?= $name ?> </p>
                            </li>
                            <li class="nav-item">
                                <p class="fw-bold" type="submit"> E-mail: <?= $email ?> </p>
                            </li>
                            <li>
                                <p class="fw-bold"> Permissões:  
                                    <a class="text-decoration-none" href="/admin/register"> Cadastrar novos dados? </a> 
                                </p>
                            </li>
                            <li class="nav-item">
                               <p>
                                    <a href="/admin/redeem" class="text-primary text-decoration-none pe-auto"> 
                                        Deseja trocar de senha? 
                                    </a>
                               </p> 
                            </li>
                        <a href="/login/destroy" class="btn btn-outline-danger" type="submit">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        {block main}{/block}
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>