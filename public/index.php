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
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
        <header>
            <nav class="navbar navbar-light bg-primary fixed-top">
                <div class="container-fluid">
                        <a class="navbar-brand text-light" href="index.php">Barbearia</a>
                        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    <div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title text-primary" id="offcanvasNavbarLabel">Offcanvas</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active text-dark" aria-current="page" href="<?= "views/services.php" ?>">Serviços</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active text-dark" aria-current="page" href="views/contact.php">Contato</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="views/about.php">Sobre</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    <main>  
        <?php require Validation::validarLoad(); ?>
    </main>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>