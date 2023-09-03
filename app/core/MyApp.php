<?php

namespace app\core;

use app\classes\Block;
use app\interfaces\AppInterface;
use Exception;

class MyApp {

    private $controller;
    private bool $block;

    public function __construct(private AppInterface $appInterface) {}

    public function controller() {

        $controller = $this->appInterface->controller();
        $method = $this->appInterface->method($controller);
        $params = $this->appInterface->parameters();

        $this->block = Block::block($method);

        if($this->block && $_SERVER['REQUEST_METHOD'] === "GET") {
            http_response_code(405);
            die;
        }
         
        $this->controller = new $controller; // está instanciando o controller que vem da função controller...  
        $this->controller->$method($params);
    }

    public function view() {

        if(!isAjax()) {
        
            if(!isset($this->controller->data)) {
                throw new Exception("the 'data' attribute is required");
            }

            if(!array_key_exists('title', $this->controller->data)) {
                throw new Exception("the title propried is required");
            }
    
            $latte = new \Latte\Engine;
            $latte->render("../app/views/{$this->controller->view}", $this->controller->data);
        
        }
    }

}