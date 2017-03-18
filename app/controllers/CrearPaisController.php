<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "PaisModel.php";
require_once FORMS . "PaisForm.php";

use app\controllers\Controller;
use app\models\PaisModel;
use app\forms\PaisForm;

/**
 * Description of CrearPaisController
 *
 * @author JHON
 */
class CrearPaisController extends Controller {
    
    public function __construct($title = "") {
        parent::__construct($title);
        $this->templateName = "admin.php";
        $this->context["action"] = "crear-pais.php";
    }
    
    protected function get() {
        $this->render();
    }
    
    protected function post() {
        $nombre = trim(filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING));
        
        //Se obtienen los datos que se validarán en el formulario.
        $POST = ["nombre" => $nombre];
        //Se crea la instancia del modelo país.
        $form = new PaisForm($POST);
        //Se procesa el formulairo.
        $form->processForm();
        
        if ($form->isValid) {
            print("El formulario es válido");
            $paisModel = new PaisModel();
            $SQL = "INSERT INTO paises(id, nombre) VALUES (NULL, :NOMBRE)";
            $bindParams = ["nombre" => ":NOMBRE"];
            
            $this->response = json_decode($paisModel->insert($SQL, $bindParams, $POST));
            
            if ($this->response->state == PaisModel::SUCCESS) {
                header("Location: " . URL . "admin/pais");
            }
        }
        else {
            print("El formulario NO  es válido");
            print_r($form->response);
            $this->response = json_decode($form->getResponse());
        }
        
        $this->render();
    }
    
}
