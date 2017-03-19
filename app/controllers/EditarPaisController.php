<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "PaisModel.php";
require_once FORMS . "PaisForm.php";

use app\controllers\Controller;
use app\models\PaisModel;
use app\forms\PaisForm;


/**
 * Description of EditarPaisController
 *
 * @author JHON
 */
class EditarPaisController extends Controller {
    
    private $paisModel;
    
    public function __construct() {
        parent::__construct("Editar País");
        $this->templateName = "admin.php";
        $this->context["action"] = "pais-form.php";
        $this->context["form_title"] = "Editar País";
        $this->context["id_form"] = "editar-pais-form";
        $this->context["submit_value"] = "Editar";
        $this->paisModel = new PaisModel();
    }
    
    protected function get() {
        $this->response = $this->paisModel->getObject($this->pk);
        
        if ($this->response["state"] == PaisModel::SUCCESS) {
            $this->context["form"] = $this->response["object"];
        }
        $this->render();
    }
    
    protected function post() {
        $nombre = trim(filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING));
        $POST = ["nombre" => $nombre];
        
        $form = new PaisForm($POST);
        
        $form->processForm();
        
        if ($form->isValid) {
            $SQL = "UPDATE paises SET nombre=:NOMBRE WHERE id=:ID";
            $bindParams = ["nombre" => ":NOMBRE"];
            $this->response = $this->paisModel->update($SQL, $bindParams, $POST, $this->pk);
            
            if ($this->response["state"] == PaisModel::SUCCESS) {
                header("Location: " . URL . "admin/pais");
            }
        }
        else {
            $this->context["form"] = $POST;
            $this->response = $form->getResponse();
        }
        
        $this->render();
    }
    
}
