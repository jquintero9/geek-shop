<?php


namespace app\models;

require_once MODELS . "Model.php";


/**
 * Representa los paises de donde provienen los proveedores.
 *
 * @author JHON
 */

class PaisModel extends Model {
    
    const INDEXES = ["id", "nombre", "Acciones"];
    
    public $id;
    public $nombre;
   
    public function __construct() {
        parent::__construct();
        $this->tableName = "paises";
        $this->className = "PaisModel";
        $this->indexesOfTable = ["id", "nombre"];
        $this->editUrl = URL . "admin/pais/{id}/editar";
        $this->deleteUrl = URL . "admin/pais/{id}/eliminar";
        $this->messages = [
            Model::SELECT => "La tabla PAÍSES está vacía.",
            Model::INSERT => "Se ha creado el registro <b>{objectName}</b> correctamente.",
            Model::UPDATE => "El país <b>{objectName}</b> se ha actualizado correctamente.",
            Model::GET_OBJECT => "El país solicitado no éxiste."
        ];
    }

}
