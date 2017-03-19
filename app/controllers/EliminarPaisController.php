<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once CONTROLLERS . "PageNotFoundController.php";
require_once MODELS . "PaisModel.php";

use app\controllers\Controller;
use app\controllers\PageNotFoundController;
use app\models\PaisModel;

/**
 * Description of EliminarPaisController
 *
 * @author JHON
 */
class EliminarPaisController extends Controller {
    
    private $paisModel;
    private $nombrePais;
    
    public function __construct() {
        parent::__construct("Eliminar País");
        $this->templateName = "admin.php";
        $this->context["action"] = "delete-form.php";
        $this->context["url_back"] = URL . "admin/pais";
        $this->paisModel = new PaisModel();
    }
    
    protected function get() {
        $this->response = $this->paisModel->getObject($this->pk);
        
        if (isset($this->response["state"])) {
            if ($this->response["state"] == PaisModel::SUCCESS) {
                $this->nombrePais = $this->response["object"]["nombre"];
                $this->context["form_title"] = "¿Está seguro que quiere eliminar el registro " .
                         $this->nombrePais . "?";
                
                $this->render();
            }
            elseif ($this->response["state"] == PaisModel::NO_RESULTS) {
                $error404 = new PageNotFoundController();
                $error404->httpRequestProcess();
            }
            
        }
    }
    
    protected function post() {
        print("Nombre: ".$this->nombrePais);
        $this->response = $this->paisModel->delete($this->pk, $this->nombrePais);
        
        if (isset($this->response["state"])) {
            if ($this->response["state"] == PaisModel::SUCCESS) {
                header("Location: " . URL . "admin/pais");
            }
            else {
                $this->render();
            }
        }
    }
    
}
