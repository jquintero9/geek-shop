<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "FabricanteModel.php";

use app\controllers\Controller;
use app\models\FabricanteModel;

/**
 * Description of DetalleFabricanteController
 *
 * @author JHON
 */
class DetalleFabricanteController extends Controller {
    
    public function __construct() {
        parent::__construct("Detalle Fabricante");
        $this->templateName = "admin.php";
        $this->context["action"] = "object-detail.php";
        $this->context["detail_title"] = "Detalle Fabricante";
    }
    
    protected function get() {
        $fabricanteModel = new FabricanteModel();
        $this->response = $fabricanteModel->detail($this->pk);
        $this->processResponse();
    }

    protected function post() {}

}
