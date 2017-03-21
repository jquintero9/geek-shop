<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once CONTROLLERS . "ServerErrorController.php";
require_once MODELS . "PaisModel.php";
require_once FORMS . "PaisForm.php";

//use app\controllers\Controller;
use app\controllers\ServerErrorController;
use app\models\PaisModel;
use app\forms\PaisForm;

/**
 * Description of CrearPaisController
 *
 * @author JHON
 */
class CrearPaisController extends Controller {
    
    public function __construct() {
        parent::__construct("Crear País");
        $this->templateName = "admin.php";
        $this->redirectSuccess = URL . "admin/pais";
        $this->context["action"] = "pais-form.php";
        $this->context["form_title"] = "Crear País";
        $this->context["id_form"] = "create-pais-form";
        $this->context["submit_value"] = "Crear";
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
        
        //Si los datos son validados se procede a insertar el registro.
        if ($form->isValid) {
            $paisModel = new PaisModel();
            $SQL = "INSERT INTO paises(id, nombre) VALUES (NULL, :NOMBRE)";
            $bindParams = ["nombre" => ":NOMBRE"];
            
            $this->response = $paisModel->insert($SQL, $bindParams, $POST);
            
            //Si la transacción tuvo éxito, entonces se redirecciona a la lista de países.
            $this->processResponse();
        }
        else {
            /*Si los datos no son válidos entonces se vuelve a mostrar el 
              formulario con los mensajes correspondientes.*/
            $this->context["form"] = $POST;
            $this->response = $form->getResponse();
            $this->render();
        }
    }
    
}
