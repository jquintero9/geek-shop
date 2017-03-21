<?php


namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "PaisModel.php";

use app\controllers\Controller;
use app\models\PaisModel;

/**
 * Description of ListaPais
 *
 * @author JHON
 */
class ListaPaisController extends Controller {
    
    public $id;
    public $nombre;
    
    public function __construct() {
        parent::__construct("Lista de Países");
        $this->templateName = "admin.php";
        $this->context["action"] = "to-list.php";
        $this->indexes = PaisModel::INDEXES;
    }

    protected function get() {
        $paisModel = new PaisModel();
        $this->response = $paisModel->select();
        
        if (isset($this->response["state"])) {
            if ($this->response["state"] == PaisModel::SUCCESS) {
                $this->render();
            }
        }
    }

    protected function post() {}

}
