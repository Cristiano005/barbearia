<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $title; ?> </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">  
</head>
<body>
    <main style="height: 100vh;">  
        <header style="max-width: 100%;">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                <div class="container-fluid">
                    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand text-light mx-auto" href="/">Barbearia</a>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-light active" aria-current="page" href="/">Página inicial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light active" aria-current="page" href="Services">Serviços</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Contact">Contato</a> <!--- Só funciona com C maiúsculo --->
                            </li>
                            <li class="nav-item">
                                <a href="/about" class="nav-link text-light">Sobre</a>
                            </li>
                        </ul>
                    </div>
                </div>
        </header>
        <?php require_once VIEW_PATH.$this->controller->view; ?> 
        <footer class="bg-primary p-5">
            <h5>
                Erisvaldo silva 
            </h5>
        </footer>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>