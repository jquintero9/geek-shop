<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";

use app\controllers\Controller;

/**
 * Description of ServerErrorController
 *
 * @author JHON
 */
class ServerErrorController extends Controller {
    
    public function __construct() {
        parent::__construct("500 - Error en el servidor");
        $this->templateName = "500.php";    
    }
    
    protected function get() {
        $this->render();
    }
    
    protected function post(){}
    
}
