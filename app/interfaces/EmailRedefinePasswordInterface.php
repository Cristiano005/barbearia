<?php

namespace app\interfaces;

interface EmailRedefinePasswordInterface {
    public function content(string $token, bool $isHtml = true);
}