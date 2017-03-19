<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "FabricanteModel.php";

use app\controllers\Controller;
use app\models\FabricanteModel;


/**
 * Description of CrearFabricanteController
 *
 * @author JHON
 */
class CrearFabricanteController extends Controller {
    
    public function __construct() {
        parent::__construct("Crear Fabricante");
        $this->templateName = "admin.php";
        $this->context["action"] = "crear-fabricante.php";
    }
    
    protected function get() {
        $this->render();
    }
    
    protected function post() {
        $nombre = trim(filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING));
        
        
    }
    
}
