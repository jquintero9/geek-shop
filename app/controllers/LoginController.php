<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "LoginModel.php";

use app\controllers\Controller;
use app\models\LoginModel;

/**
 * Description of Login
 *
 * @author JHON
 */
class LoginController extends Controller {

    public function __construct() {
        parent::__construct("Login");
        $this->templateName = "login.php";
    }

    protected function get() {

        $this->render();
    }

    protected function post() {
        print("El login fue enviado por el método POST");
        
        $this->response = json_decode(LoginModel::login());

        
        print($this->response->message);
        print("<br/>");

        if ($this->response->state == LoginModel::SUCCESS) {
            header("Location: " . URL . "admin");
        }
        
        $this->render();
        
    }

}
