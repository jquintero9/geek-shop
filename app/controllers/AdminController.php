<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";

use app\controllers\Controller;

/**
 * Description of Admin
 *
 * @author JHON
 */
class AdminController extends Controller {
    
    public function __construct() {
        parent::__construct("Admin - Home");
        $this->templateName = "admin.php";
        $this->context["action"] = "admin-index.php";
    }
    
    protected function get() {
        $this->render();
    }
    
    protected function post() {
        
    }
    
}
