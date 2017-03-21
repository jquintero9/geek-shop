<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "FabricanteModel.php";
require_once FORMS . "FabricanteForm.php";

use app\controllers\Controller;
use app\models\FabricanteModel;
use app\forms\FabricanteForm;


/**
 * Description of CrearFabricanteController
 *
 * @author JHON
 */
class CrearFabricanteController extends Controller {
    
    public function __construct() {
        parent::__construct("Crear Fabricante");
        $this->templateName = "admin.php";
        $this->redirectSuccess = URL . "admin/fabricante";
        $this->context["action"] = "fabricante-form.php";
        $this->context["id_form"] = "create-fabricante-form";
        $this->context["submit_value"] = "Crear";
        $this->context["form_title"] = "Crear Fabricante";
    }
    
    protected function get() {
        $this->render();
    }
    
    protected function post() {
        $nombre = trim(filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING));
        $POST = ["nombre" => $nombre];
        $form = new FabricanteForm($POST);
        $form->processForm();
        
        if ($form->isValid) {
            $fabricanteModel = new FabricanteModel();
            $SQL = "INSERT INTO fabricantes(id, nombre) VALUES (NULL, :NOMBRE)";
            $bindParams = ["nombre" => ":NOMBRE"];
            
            $this->response = $fabricanteModel->insert($SQL, $bindParams, $POST);
            
            $this->processResponse();
        }
        else {
            $this->context["form"] = $POST;
            $this->response = $form->getResponse();
            $this->render();
        } 
    }
}
