<?php

namespace app\controllers;

require_once CONTROLLERS . "PageNotFoundController.php";
require_once CONTROLLERS . "ServerErrorController.php";

use app\controllers\ServerErrorController;

/**
 * Esta clase representa los controladores de la aplicación.
 * La función de cada controlador es comunicarse con el modelo (Base de Datos)
 * y retornar las vistas a los usuarios. 
 *
 * @author JHON
 */

abstract class Controller {
    
    protected $requestMethod;
    protected $templateName;
    protected $pk;
    protected $context;
    protected $response;
    public $indexes;
    protected $redirectSuccess;


    /**
     * Constructor de la clase Controller.
     * @param String $title es el titulo del documento.
     */
    public function __construct($title = "") {
        self::init($title);
    }
    
    /**
     * Incializa los atributos del controlador.
     * 
     * @param String $title es el titulo del documento.
     */
    private function init($title = "") {
        $this->context = array("title" => $title);
        
        /* Se obtiene el método por el cual se realizo la petición http. */
        $this->requestMethod = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    }
    
    /**
     * Se invoca la función get() o post()
     * dependiendo del tipo de petición http que el usuairo halla realizado
     * (GET o POST).
     */
    public function httpRequestProcess() {
        if ($this->requestMethod == "GET") {
            $this->get();
        }
        elseif ($this->requestMethod == "POST") {
            $this->post();
        }
    }
    
    /**
     * get(): Esta función debe ser implementada por cada controlador, y
     * define las instruciones que se deben realizar cuando el controlador
     * recibe una petición http por el método GET.
     */
    protected abstract function get();
    
    /**
     * get(): Esta función debe ser implementada por cada controlador, y
     * define las instruciones que se deben realizar cuando el controlador
     * recibe una petición http por el método GET.
     */
    protected abstract function post();
    
    /**
     * Esta función se encarga de retornar la vista al usuario.
     * context: es un array que contienen todas las variables que son requeridas
     * por el template, como: El titulo de la página y registros que fueron
     * obtenidos por el modelo.
     */
    protected function render() {
        $this->context["content"] = $this->templateName;
        include_once TEMPLATES . "base.php";
    }
    
    public function setPK($pk) {
        $this->pk = $pk;
    }
    
    public function processResponse() {
        if (isset($this->response["state"])) {
            if ($this->response["state"] == \app\models\Model::SUCCESS) {
                if ($this->redirectSuccess) {
                    header("Location: " . $this->redirectSuccess);
                }
                else {
                    $this->render();
                }
            }
            elseif ($this->response["state"] == \app\models\Model::NO_RESULTS) {
                $error404 = new PageNotFoundController();
                $error404->httpRequestProcess();
            }
        }
        else {
            $error500 = new ServerErrorController();
            $error500->httpRequestProcess();
        }
    }
    
}
