<?php

namespace app\interfaces;

interface ControllerInterface {

    public function index();
    public function store();
    public function destroy(array $args);

}