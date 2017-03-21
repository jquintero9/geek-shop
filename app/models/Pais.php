<?php

namespace app\models;

require_once CORE . "Model.php";

use app\core\Model;

/**
 * Description of Pais
 *
 * @author JHON
 */

class Pais extends Model {
    
    private $id;
    private $nombre;
    
    public function __construct() {
        
    }
    
    protected function setAttributes($args) {
        foreach ($args as $key => $value) {
            if (property_exists(get_class($this), $key)) {
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
    
    public function setId($newId) {
        $this->id = $newId;
    }
    
    public function setNombre($newNombre) {
        $this->nombre = $newNombre;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    
}
