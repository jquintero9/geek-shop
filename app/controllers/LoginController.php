<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once FORMS . "LoginForm.php";
require_once CORE . "ModelManager.php";

use app\forms\LoginForm;
use app\core\ModelManager;

/**
 * Description of Login
 *
 * @author JHON
 */
class LoginController extends Controller {
    
    public $loginAJAX;
    
    public function __construct() {
        parent::__construct("Login");
        $this->templateName = "login.php";
    }

    protected function get() {
        $this->loginAJAX = "<script src='". URL . "public/js/loginAJAX.js" ."'></script>";
        if (!isset($_SESSION["user"])) {
            $this->render();
        }
        else {
            header("Location: " . URL . "admin");
        }
    }

    protected function post() {

        $AJAX = true;

        if (empty($_POST)) {
            $data = file_get_contents('php://input');
            $jsonData = json_decode($data, JSON_FORCE_OBJECT);
            $POST = ["username" => $jsonData["username"], "password" => $jsonData["password"]];
        }
        else {
            $AJAX = false;
            $POST = $_POST;
        }

        $form = new LoginForm($POST);

        if ($form->isValid()) {
            $modelManager = ModelManager::getInstance();
            $this->response = $modelManager->login($form->cleanedData["username"], $form->cleanedData["password"]);

            if ($AJAX) {
                header("Content-Type: application/json; charset=UTF-8");
                return print($this->response);
            } else {
                $this->response = json_decode($this->response);
                if ($this->response->state == "success") {
                    header("Location: " . URL . "admin");
                }
            }
        }

        $this->context["form"] = $POST;
        $this->context["error"] = $form->response;
        $this->render();
    }
}
