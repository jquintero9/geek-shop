<?php

namespace app\core;

require_once CORE . "Url.php";
require_once CONTROLLERS . "IndexController.php";

use app\core\Url;
use app\controllers\IndexController;

/**
 * Esta clase se encarga de recibir y procesar la petición 
 * enviada por el usuario. Además de retornar la instancia del controlador
 * solicitado.
 * 
 * @author JHON
 */

class Request {
    
    /**
     * Esta función recibe la URL que ha solicitado el usuario y realiza
     * la búsqueda de dicha URL en los patrones de URLS que tiene definidos
     * la aplicación. Si la URL recibida es válida, entonces se crea
     * y se retorna una instancia del controlador 
     * al cual hace referencia la URL.
     * 
     * @param String $url Es la URL que el usuario ha solicitado.
     * @return Una instancia del controlador al cual hace referencia
     * la URL recibida.
     */
    public static function getController($url) {
        
        if ($url != null) {
            
            /* Se realiza la busqueda de la URL solicitada en la lista de 
             * patrones URL de la aplicación. */
            foreach (Url::URL_PATTERNS as $controller => $urlPattern) {
                
                /* Esta función se encarga de comparar la URL recibida 
                 * con el con cada uno de las URLS de la lista patrones. 
                 * La varable coincidences guarda los valores con los cuales 
                 * coincidio la URL, si el patrón de URL requiere de un P<id>,
                 * este valor también será guardado mediante la función
                 * setID().
                 */
                $coincidences = array();
                if (preg_match($urlPattern, $url, $coincidences)) {
                    
                    print($controller . "<br />");
                    $controller .= "Controller";
                    
                    self::setID($coincidences);
                    
                    /* Se Crea y se retorna la instancia del controlador
                     * al cual pertenece la URL solicitada. */
                    require_once CONTROLLERS . $controller . ".php";
                    
                    $instacne = 'app\\controllers' . DS . $controller;
                    
                    return new $instacne;
                }
            }
        }
        else {
            return new IndexController();
        }
    }
    
    /* Vefica si la URL que coincidió con el patrón URL, requiere de un ID.
     * Si es asi, entonces se guarda el ID en la variable global $_POST
     * para que luego el controlador pueda tener acceso a ella desde allí. */
    private function setID($coincidences) {
        if (isset($coincidences["id"])) {
            \print_r($coincidences["id"]);
            $_POST['pk'] = $coincidences["id"];
        }
    }

}