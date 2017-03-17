<?php


namespace app\controllers;

require_once CONTROLLERS . "Controller.php";

use app\controllers\Controller;

/**
 * Este controlador se encarga de denegar el acceso a los
 * usuarios que no se han autenticado en el sistema.
 *
 * @author JHON
 */
class ForbiddenController extends Controller {
    
    public function __construct($title = "Acceso Denegado") {
        parent::__construct($title);
        $this->templateName = "403.php";
    }
    
    protected function get() {
        $this->render();
    }
    
    protected function post() {}
    
}
