<?php

namespace app\models;

require_once MODELS . "Model.php";

use app\models\Model;

/**
 * Description of ProveedorModel
 *
 * @author JHON
 */
class ProveedorModel extends Model {
    
    const INDEXES = [
        "ID",
        "NIT",
        "NOMBRE",
        "PAÍS",
        "TELÉFONO",
        "PÁGINA WEB",
    ];
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "proveedores";
        $this->indexesOfTable = [
            "id",
            "nit",
            "nombre",
            "pais",
            "telefono",
            "pagina_web"
        ];
        
        $this->messages = [
            Model::SELECT => "La lista de PROVEEDORES está vacía.",
        ];
    }
    
}
