<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once CONTROLLERS . "PageNotFoundController.php";
require_once MODELS . "FabricanteModel.php";
require_once FORMS . "FabricanteForm.php";

use app\models\FabricanteModel;
use app\forms\FabricanteForm;

/**
 * Description of EditarFabricanteController
 *
 * @author JHON
 */
class EditarFabricanteController extends Controller {
    
    private $fabricanteModel;
    
    public function __construct() {
        parent::__construct("Editar Fabricante");
        $this->templateName = "admin.php";
        $this->context["action"] = "fabricante-form.php";
        $this->context["form_title"] = "Editar Fabricante";
        $this->context["submit_value"] = "Editar";
        $this->context["id_form"] = "edit-fabricante-form";
        $this->fabricanteModel = new FabricanteModel();
    }
    
    protected function get() {
        $this->response = $this->fabricanteModel->getObject($this->pk);
        
        if (isset($this->response["state"])) {
            if ($this->response["state"] == FabricanteModel::SUCCESS) {
                $this->context["form"] = $this->response["object"];
                $this->render();
            }
            elseif ($this->response["state"] == FabricanteModel::NO_RESULTS) {
                $error404 = new PageNotFoundController();
                $error404->httpRequestProcess();
            }
        }
    }
    
    protected function post() {
        $nombre = trim(filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING));
        $POST = ["nombre" => $nombre];
        $form = new FabricanteForm($POST);
        $form->processForm();
        
        if ($form->isValid) {
            $SQL = "UPDATE fabricantes SET nombre=:NOMBRE WHERE id=:ID";
            $bindParams = ["nombre" => ":NOMBRE"];
            $this->response = $this->fabricanteModel->update($SQL, $bindParams, $POST, $this->pk);
            $this->redirectSuccess = URL . "admin/fabricante/" . $this->pk . "/ver";
            $this->processResponse();
        }
        else {
            $this->context["form"] = $POST;
            $this->response = $form->getResponse();
            $this->render();
        }
    }
}
