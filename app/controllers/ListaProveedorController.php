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
        
        $sql = "SELECT prov.id, prov.nit, prov.nombre, pais.nombre AS pais,
                prov.telefono, prov.pagina_web
                FROM proveedores AS prov
                INNER JOIN paises AS pais
                ON prov.pais = pais.id";
        
        $this->response = json_decode($proveedorModel->select($sql));
        
        $this->render();
    }

    protected function post() {}

}
