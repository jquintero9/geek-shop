<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";

use app\controllers\Controller;

/**
 * Description of PageNotFoundController
 *
 * @author JHON
 */
class PageNotFoundController extends Controller {
    
    public function __construct() {
        parent::__construct("404 - Página no encontrada.");
        $this->templateName = "404.php";
    }
    
    protected function get() {
        $this->render();
    }
    
    protected function post() {
        $this->render();
    }
    
}
