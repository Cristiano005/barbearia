<?php

function load() {

    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
    $page = (!$page) ? "views/home.php" : "views/{$page}.php";

    if(!file_exists($page)) {
        throw new \Exception('opa, alguma coisa de errada aconteceu.');
    }

    return $page;
}