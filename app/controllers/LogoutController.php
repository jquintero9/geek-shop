<?php

namespace app\controllers;

require_once CONTROLLERS . "controller.php";

use app\controllers\Controller;

/**
 * Description of LogoutController
 *
 * @author JHON
 */
class LogoutController extends Controller {
    
    public function __construct() {
        parent::__construct("");
    }

    protected function get() {
        session_destroy();
        
        header("Location: " . URL);
    }

    protected function post() {}
}
