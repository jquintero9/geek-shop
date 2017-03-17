<?php


namespace app\models;

require_once MODELS . "Model.php";


/**
 * Representa los paises de donde provienen los proveedores.
 *
 * @author JHON
 */

class PaisModel extends Model {
    
    const INDEXES = ["id", "nombre"];
    
    public $id;
    public $nombre;
   
    public function __construct() {
        parent::__construct();
        $this->tableName = "paises";
        $this->indexesOfTable = ["id", "nombre"];
        $this->messages = [
            Model::SELECT => "La tabla PAÍSES está vacía.",
        ];
    }

}
