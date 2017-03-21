<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "ProveedorModel.php";
require_once FORMS . "ProveedorForm.php";

use app\controllers\Controller;
use app\models\ProveedorModel;
use app\forms\ProveedorForm;

/**
 * Description of CrearProveedorController
 *
 * @author JHON
 */
class CrearProveedorController extends Controller {
    
    private $proveedorModel;
    
    public function __construct() {
        parent::__construct("Crear Proveedor");
        $this->templateName = "admin.php";
        $this->redirectSuccess = URL . "admin/proveedor";
        $this->context["action"] = "proveedor-form.php";
        $this->context["form_title"] = "Crear Proveedor";
        $this->context["id_form"] = "create-proveedor-form";
        $this->context["submit_value"] = "Crear";
        //$this->proveedorModel = new ProveedorModel();
    }
    
    protected function get() {
        $proveedorModel = new ProveedorModel();
        $this->context["form"] = $proveedorModel->getSelectPais();
        //$this->context["form"] = $this->proveedorModel->getSelectPais();
        //$proveedorModel = null;
        $this->render();
    }

    protected function post() {
        $nit = trim(filter_input(INPUT_POST, "nit"));
        $nombre = trim(filter_input(INPUT_POST, "nombre"));
        $pais = trim(filter_input(INPUT_POST, "pais"));
        $telefono = trim(filter_input(INPUT_POST, "telefono"));
        $web = trim(filter_input(INPUT_POST, "web", FILTER_SANITIZE_URL));
        
        $POST = [
            "nit" => $nit,
            "nombre" => $nombre,
            "pais" => strval($pais),
            "telefono" => $telefono,
            "web" => $web
        ];
        
        $form = new ProveedorForm($POST);
        
        $proveedorModel = new ProveedorModel();
        $form->processForm(["pais" => ["table" => "paises", "fk" => $pais]]);
        print_r($form->getResponse());
        
        if ($form->isValid) {
            
            print("is valid");
            $SQL = "INSERT INTO proveedores(id, nit, nombre, pais, telefono, pagina_web) VALUES ("
                    . "NULL, ?, ?, ?, ?, ?)";
            print("SQL: " . $SQL);
            $bindParams = [
                "nit" => 1,
                "nombre" => 2,
                "pais" => 3,
                "telefono" => 4,
                "web" => 5,
            ];
             
             
            /*$SQL = "INSERT INTO proveedores(id, nit, nombre, pais, telefono, pagina_web) VALUES ("
                    . "NULL, '$nit', '$nombre', '$pais', '$telefono', '$web')";
            
            */
            
             $this->response = $proveedorModel->insert($SQL, $bindParams, $POST);
             
            //$this->response = $proveedorModel->in($SQL);
            $this->processResponse();
        }
        else {
            $response = $proveedorModel->getSelectPais($pais);
            $POST["pais"] = $response["pais"];
            
            $this->response = $form->getResponse();
            
            $this->context["form"] = $POST;
            
            $this->render();
        }
        
    }

}
