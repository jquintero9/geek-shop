<?php


namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "ProveedorModel.php";

use app\controllers\Controller;
use app\models\ProveedorModel;

/**
 * Description of ListaProveedor
 *
 * @author JHON
 */
class ListaProveedorController extends Controller {
    
    public function __construct() {
        parent::__construct("Lista de Proveedores");
        $this->templateName = "admin.php";
        $this->context["action"] = "to-list.php";
        $this->indexes = ProveedorModel::INDEXES;
    }

    protected function get() {
    
        $proveedorModel = new ProveedorModel();
        $this->response = json_decode($proveedorModel->select());
        
        $this->render();
    }

    protected function post() {}

}
