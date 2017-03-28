<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "PaisModel.php";

use app\models\PaisModel;

/**
 * Description of DetallePaisController
 *
 * @author JHON
 */
class DetallePaisController extends Controller {
    
    public function __construct() {
        parent::__construct("Vista País");
        $this->templateName = "admin.php";
        $this->context["action"] = "pais-detail.php";
        
    }
    
    protected function get() {
        $this->context["object"] = PaisModel::get($this->pk);
        $this->context["detail-title"] = "País " . $this->context["object"]->nombre;
        $this->render();
    }
    
    protected function post() {}
    
}
