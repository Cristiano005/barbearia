<?php

function session(string $key, string $value): string {

    if(isset($_SESSION[$key])) {
        return $_SESSION[$key][$value];
    }

    return redirect("/");
} 