<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "CategoriaModel.php";

use app\controllers\Controller;
use app\models\CategoriaModel;

/**
 * Description of ListaCategoria
 *
 * @author JHON
 */
class ListaCategoriaController extends Controller {
    
    public function __construct() {
        parent::__construct("Lista de Categorías");
        $this->templateName = "admin.php";
        $this->context["action"] = "to-list.php";
        $this->indexes = CategoriaModel::INDEXES;
    }

    protected function get() {
        $categoriaModel = new CategoriaModel();
        $this->response = json_decode($categoriaModel->select());
        print_r($this->response);
        $this->render();
        
    }

    protected function post() {
        print("El método fue por POST");
    }

}
