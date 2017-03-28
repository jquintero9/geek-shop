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

class PaisModel extends Model {
    
    const TABLE_NAME = "paises";
    
    const SQL_STATEMENTS = [
        Model::GET => "SELECT * FROM " . self::TABLE_NAME . " WHERE id=:id LIMIT 1",
        Model::GET_ALL => "SELECT * FROM " . self::TABLE_NAME,
        Model::SAVE => "INSERT INTO " . self::TABLE_NAME . " (id, nombre) VALUES (NULL, :nombre)",
        Model::UPDATE => "UPDATE " . self::TABLE_NAME . " SET nombre=:nombre WHERE id=:id",
        Model::DELETE => "DELETE FROM " . self::TABLE_NAME . " WHERE id=:id",
    ];
    
    public $id;
    public $nombre;
    
    public function __construct($nombre = null, $id = null) {
        $this->nombre = $nombre;
        $this->id = $id;
    }
    
    public static function get($pk) {
        $model = ModelManager::getInstance(__CLASS__, self::TABLE_NAME, self::SQL_STATEMENTS);
        return $model->getObject($pk);
    }
    
    public static function all() {
        $model = ModelManager::getInstance(__CLASS__, self::TABLE_NAME, self::SQL_STATEMENTS);
        return $model->getAll();
    }
    
    public function save() {
        $model = ModelManager::getInstance(__CLASS__, self::TABLE_NAME, self::SQL_STATEMENTS);
        $model->saveObject($this);
    }
    
    public function update() {
        $model = ModelManager::getInstance(__CLASS__, self::TABLE_NAME, self::SQL_STATEMENTS);
        $model->updateObject($this);
    }
    
    public function delete() {
        
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
