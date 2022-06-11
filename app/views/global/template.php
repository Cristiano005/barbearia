<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $title; ?> </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <main>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                <div class="container-fluid">
                    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand text-light mx-auto" href="/">Barbearia</a>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-light active" aria-current="page" href="/services">Serviços</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="/contact">Contato</a>
                            </li>
                            <li class="nav-item">
                                <a href="/about" class="nav-link text-light">Sobre</a>
                            </li>
                        </ul>
                    </div>
                </div>
        </header>
        <?php require_once VIEW_PATH . $this->controller->view; ?>
        <footer class="bg-primary p-4 d-flex justify-content-around align-items-center flex-wrap">
                <span class="bg-light text-light rounded"> 
                    <a href="/login" class="text-decoration-none p-4"> Is admin? </a>     
                </span>
                <span class="text-light"> Erisvaldo - Todos os direitos reservados  </span>
            <div class="bg-light rounded p-1">
                <a href="#">
                    <img class="me-2 pe-auto" src="assets/img/facebook.svg" alt="Icone Facebook">
                </a>
                <a href="#">
                    <img class="me-2 pe-auto" src="assets/img/whatsapp.svg" alt="Icone Whatsapp">
                </a>
                <a href="#">
                    <img class="me-2 pe-auto" src="assets/img/instagram.svg" alt="Icone Instagram">
                </a>
            </div>
        </footer>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>