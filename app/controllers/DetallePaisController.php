<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once CONTROLLERS . "PageNotFoundController.php";
require_once CONTROLLERS . "ServerErrorController.php";
require_once MODELS . "PaisModel.php";

use app\controllers\Controller;
use app\controllers\PageNotFoundController;
use app\controllers\ServerErrorController;
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
        
        if (isset($this->response["state"])) {
            if ($this->response["state"] == PaisModel::SUCCESS) {
                $this->render();
            }
            elseif ($this->response["state"] == PaisModel::NO_RESULTS) {
                $error404 = new PageNotFoundController();
                $error404->httpRequestProcess();
            }
            else if ($this->response["state"] == PaisModel::ERROR) {
                $error500 = new ServerErrorController();
                $error500->httpRequestProcess();
            }
        }   
    }
    
    protected function post() {}
    
}
