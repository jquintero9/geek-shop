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
        $this->className = "FabricateModel";
        $this->indexesOfTable = ["id", "nombre"];
        $this->editUrl = URL . "admin/fabricante/{id}/editar";
        $this->deleteUrl = URL . "admin/fabricante/{id}/eliminar";
        $this->detailUrl = URL . "admin/fabricante/{id}/ver";
        $this->messages = [
            Model::SELECT => "La tabla FABRICANTES está vacía.",
            Model::INSERT => "Se ha creado el registro <b>{objectName}</b> correctamente.",
            Model::UPDATE => "El fabricante <b>{objectName}</b> se ha actualizado correctamente.",
            Model::DELETE => "El fabricante se ha eliminado correctamente.",
        ];
    }
    
}
