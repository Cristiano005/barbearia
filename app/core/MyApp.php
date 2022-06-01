<?php

namespace app\core;

use app\interfaces\AppInterface;
use Exception;

class MyApp {

    private $controller;

    public function __construct(private AppInterface $appInterface) {}

    public function controller() {

        $controller = $this->appInterface->controller();
        $method = $this->appInterface->method($controller);
        $params = $this->appInterface->parameters();
    
        $this->controller = new $controller; // está instanciando o controller que vem da função controller...
        $this->controller->$method($params);
    
    }

    public function view() {
        
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
    
            if(!isset($this->controller->data)) {
                throw new Exception("the 'data' attribute is required");
            }

            if(!isset($this->controller->template)) {
                throw new Exception("the 'template' attribute is required");
            }
    
            if(!array_key_exists('title', $this->controller->data)) {
                throw new Exception("the title propried is required");
            }
    
            extract($this->controller->data);
            require_once "../app/views/{$this->controller->template}";
        }
    }

}