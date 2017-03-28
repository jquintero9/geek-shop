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
    
    public function __construct() {
        parent::__construct("Lista de Países");
        $this->templateName = "admin.php";
        $this->context["action"] = "lista-paises.php";
    }

    protected function get() {
        $this->context["object-list"] = PaisModel::all();
        $this->render();
    }

    protected function post() {}

}
