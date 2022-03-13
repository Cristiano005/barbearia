<?php 

require_once '../app/helpers/pages.php'; 
require_once '../app/models/validation.php';

use App\Models\Validation;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso de PHP - Clube Full Stack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
                    <a class="navbar-brand text-light mx-auto" href="?page=home">Barbearia</a>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-light active" aria-current="page" href="?page=home">Página inicial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="?page=contact">Contato</a>
                            </li>
                            <li class="nav-item">
                                <a href="?page=about" class="nav-link text-light">Sobre</a>
                            </li>
                        </ul>
                    </div>
                </div>
        </header>
        <?php Validation::validarLoad(); ?>
    </main>
</body>
</html>