<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "PaisModel.php";

use app\controllers\Controller;
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
        $this->context["action"] = "object-detail.php";
        $this->context["detail_title"] = "Detalle País";
    }
    
    protected function get() {
        $paisModel = new PaisModel();
        $this->response = $paisModel->detail($this->pk);
        $this->processResponse();  
    }
    
    protected function post() {}
    
}
