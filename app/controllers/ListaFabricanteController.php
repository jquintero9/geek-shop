<?php


namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "FabricanteModel.php";

use app\controllers\Controller;
use app\models\FabricanteModel;

/**
 * Description of ListaFabricanteController
 *
 * @author JHON
 */
class ListaFabricanteController extends Controller {
    
    public function __construct() {
        parent::__construct("Lista de Fabricantes");
        $this->templateName = "admin.php";
        $this->context["action"] = "to-list.php";
        $this->indexes = FabricanteModel::INDEXES;
    }
    
    
    protected function get() {
        $fabricanteModel = new FabricanteModel();
        $this->response = json_decode($fabricanteModel->select());
        
        $this->render();
    }
    
    protected function post() {}
    
}
