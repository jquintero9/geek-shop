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
        $this->className = "ProveedorModel";
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
            Model::INSERT => "El proveedor <b>{objectName}</b> se ha creado correctnamente.",
            Model::UPDATE => "El proveedor <b>{objectName}</b> se ha actualizado correctamente.",
            Model::DELETE => "El proveedor se ha eliminado correctamente.",
        ];
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
