<?php

namespace app\models;

require_once MODELS . "Model.php";

use app\models\Model;

/**
 * Description of CategoriaModel
 *
 * @author JHON
 */
class CategoriaModel extends Model {
    
    const INDEXES = array("id", "nombre", "descripcion");
    
    public $id;
    public $nombre;
    public $descripcion;
    
    function __construct() {
        parent::__construct();
        $this->tableName = "categorias";
        $this->className = "CategoriaModel";
        $this->indexesOfTable = array("id", "nombre", "descripcion");
        $this->messages = [
            Model::SELECT => "La lista de <b>CATEGORÍAS</b> esta vacía.",
        ];
    }
    
}
