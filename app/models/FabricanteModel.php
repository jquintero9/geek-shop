<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

require_once MODELS . "Model.php";

use app\models\Model;

/**
 * Esta clase describe el modelo de la tabla fabricantes.
 *
 * @author JHON
 */
class FabricanteModel extends Model {
    
    const INDEXES = ["id", "nombre"];
    
    
    public $id;
    public $nombre;
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "fabricantes";
        $this->indexesOfTable = ["id", "nombre"];
        $this->messages = [
            Model::SELECT => "La lista de FABRICANTES está vacía.",
        ];
    }
    
}
