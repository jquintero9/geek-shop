<?php

namespace app\models;

require_once CORE . "ModelManager.php";
require_once CORE . "Model.php";

use app\core\ModelManager;
use app\core\Model;

/**
 * Description of Pais
 *
 * @author JHON
 */

class Pais extends Model {
    
    const CLASS_NAME= __CLASS__;
    const TABLE_NAME = "paises";
    
    const SQL_STATEMENTS = [
        Model::GET => "SELECT * FROM " . self::TABLE_NAME . " WHERE id=? LIMIT 1",
        Model::GET_ALL => "SELECT * FROM " . self::TABLE_NAME,
        Model::SAVE => "INSERT INTO " . self::TABLE_NAME . " (id, nombre) VALUES (NULL, ?)",
    ];
    
    private $id;
    public $nombre;
    
    public function __construct($nombre = null, $id = null) {
        $this->nombre = $nombre;
        $this->id = $id;
    }
    
    public static function get($pk) {
        $model = new ModelManager(__CLASS__, self::TABLE_NAME, self::SQL_STATEMENTS);
        return $model->getObject($pk);
    }
    
    public static function all() {
        $model = new ModelManager(__CLASS__, self::TABLE_NAME, self::SQL_STATEMENTS);
        return $model->getAll();
    }
    
    public function save() {
        $model = new ModelManager(__CLASS__, self::TABLE_NAME, self::SQL_STATEMENTS);
        return $model->saveObject($this);
    }
    
    public function setAttributes($args) {
        foreach ($args as $key => $value) {
            if (\property_exists(get_class($this), $key)) {
                $this->__set($key, $value);
            }
        }
    }
    
    public function __toString() {
        return "id: " . $this->id . " | Nombre: " . $this->nombre;
    }
    
    public function __set($name, $value) {
        switch ($name) {
            case "id":
                $this->id = $value;
                break;
            case "nombre":
                $this->nombre = $value;
                break;
        }
    }
}
