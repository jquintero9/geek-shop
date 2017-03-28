<?php

namespace app\models;

require_once  CORE . "Model.php";
require_once CORE . "ModelManager.php";

use app\core\Model;
use app\core\ModelManager;

/**
 * Description of ProveedorModel
 *
 * @author JHON
 */
class ProveedorModel extends Model {

    const TABLE_NAME = "proveedores";

    const SQL_STATEMENTS = [
        Model::GET => "SELECT * FROM " . self::TABLE_NAME . " WHERE id=:id LIMIT 1",
        Model::GET_ALL => "SELECT * FROM " . self::TABLE_NAME,
        Model::SAVE => "INSERT INTO " . self::TABLE_NAME .
            "(id, nit, nombre, pais, telefono, web)" .
            "VALUES (NULL,:nit,:nombre,:pais,:telefono,:web)",
        Model::UPDATE => "UPDATE " . self::TABLE_NAME .
            " SET nit=:nit nombre=:nombre pais=:pais telefono=:telefono web=:web",
        Model::DELETE => "DELETE " . self::TABLE_NAME . " WHERE id=:id"
    ];

    const FOREIGN_KEYS = [
        "pais" => ["table" => "paises", "pk" => "id", "class" => "app\\models\\PaisModel"]
    ];

    public $id;
    public $nit;
    public $nombre;
    public $pais;
    public $telefono;
    public $web;
    
    public function __construct($id = null, $nit = null, $nombre = null, $pais = null,
                                $telefono = null, $web = null) {
        $this->id = $id;
        $this->nit = $nit;
        $this->nombre = $nombre;
        $this->pais = $pais;
        $this->telefono = $telefono;
        $this->web = $web;
    }

    public static function get($pk) {
        $modelManager = ModelManager::getInstance(__CLASS__, self::TABLE_NAME,
            self::SQL_STATEMENTS, self::FOREIGN_KEYS);
        return $modelManager->getObject($pk);
    }

    public static function all() {

    }

    public function save() {

    }

    public function update() {

    }

    public function delete() {

    }

    public function setAttributes($args) {
        foreach ($args as $name => $value) {
            if (\property_exists(__CLASS__, $name)) {
                $this->__set($name, $value);
            }
        }
    }

    public function __set($name, $value) {
        switch ($name) {
            case "id":
                $this->id = $value;
                break;
            case "nit":
                $this->nit = $value;
                break;
            case "nombre":
                $this->nombre = $value;
                break;
            case "pais":
                $this->pais = $value;
                break;
            case "telefono":
                $this->telefono = $value;
                break;
            case "web":
                $this->web = $value;
                break;
        }
    }
    
    public function validateForeignKeyPais() {
        foreach ($this->fields as $key => $value) {
            if ($foreignKeyInfo) { 
                if (array_key_exists($key, $foreignKeyInfo)) {
                    print("antes del continue");
                    $table = $foreignKeyInfo[$key]["table"];
                    $fk = $foreignKeyInfo[$key]["fk"];
                    
                    require_once CORE . "Database.php";
                    
                    $conn = new \Database();
                    $SQL = "SELECT id FROM $table WHERE id=:FK";
                    $stm = $conn->prepare($SQL);
                    $stm->bindParam(":FK", $fk);
                    
                    try {
                        if ($stm->execute()) {
                            if ($stm->rowCount() == 0) {
                                $this->response[$key] = $this->infoFields[$key][self::MESSAGES][self::REGEX];
                            }
                        }
                    }
                    catch (PDOException $e) {}
                    
                    $stm->closeCursor();
                    
                    $conn = null;
                    
                    continue;
                }
            }
            print("<br/>despues del continue: ". $key);
            $this->validateFields($key, $value);
        }
    }
    
    public function getSelectPais($selected = null) {
        $this->connectDB();
        
        $SQL = "SELECT id, nombre FROM paises";
        
        $stm = $this->connection->query($SQL);
        
        try {
            if ($stm->execute()) {
                $this->generateSelect($stm, $selected);
            }
        }
        catch (\PDOException $e) {}
        
        return $this->response;
    }
    
    private function generateSelect($stm, $selected) {
        if ($stm->rowCount() > 0) {
            $data = "<select name='pais'>";
            $data .= "<option value=''>- - -</option>";
            
            foreach ($stm->fetchAll() as $register) {
                if ($selected == $register["id"]) {
                    $data .= "<option value=" . $register["id"] . " selected>" . $register["nombre"] . "</option>";
                }
                else {
                    $data .= "<option value=" . $register["id"] . ">" . $register["nombre"] . "</option>"; 
                }
            }
            
            $data .= "</select>";
            $this->response["pais"] = $data;
        }
    }
    
}
