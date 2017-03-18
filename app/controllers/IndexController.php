<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";

use app\controllers\Controller;

/**
 * Description of Index
 *
 * @author JHON
 */
class IndexController extends Controller {
    
    public function __construct() {
        parent::__construct("Bienvenido a Geek Shop");
        $this->templateName = "home.php";
    }
    
    
    protected function get() {
        if (!isset($_SESSION["user"])) {
            $this->render();
        }
        else {
            header("Location: " . URL . "admin");
        }
        
    }

    protected function post() {}

}
