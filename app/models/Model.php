<?php

namespace app\models;

/**
 *Esta clase representa los modelos de la aplicación, los cuales hacen
 * referencia a las tablas de la base de datos.
 * Se encarga de realizar todas las operaciones de consulta
 * a la base de datos.
 * 
 * @author JHON
 */

class Model {
    
    //Claves para acceder al array de mensajes.
    const SELECT = "select";
    const UPDATE = "update";
    const DELETE = "delete";
    const INSERT = "insert";
    
    //Estados para determinar el estado de la transacción con la base de datos.
    const SUCCESS = 1;
    const ERROR = 2;
    const NO_RESULTS = 3;

    protected $tableName;
    protected $indexesOfTable;
    protected $response;
    protected $messages;
    protected $connection;
    
    protected $className;

    public function __construct() {
        $this->response = array();
    }
    
    private function connectDB() {
        require_once CORE . "Database.php";
        $this->connection = new \Database();
    }
    
    public function getObject($id) {
        $this->connectDB();
        $sentenceSQL = "SELECT * FROM $this->tableName WHERE id=:ID";
        print("<br/>SQL: " . $sentenceSQL . "<br/>");
        $stm = $this->connection->prepare($sentenceSQL);
        $stm->bindParam(":ID", $id);
        print_r($stm);
        if ($stm->execute()) {
            if ($stm->rowCount() > 0) {

                return \json_encode($this->createObject($stm->fetchAll()));
            }
        }
    }
    
    private function createObject($register) {
        try {
            $instance = "app\\models\\" . $this->className;
            $object = new $instance;
            print_r($register);
            $object->id = $register[0]["id"];
            $object->nombre = $register[0]["nombre"];
            return $object;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    /**
     * Selecciona uno o todos lo registros de una tabla.
     */
    public function select($sql = null) {
        $this->connectDB();
        print("<br/>Nombre de la tabla: " . $this->tableName);
        $sentenceSQL = ($sql != null) ? $sql : "SELECT * FROM $this->tableName";
        $stm = $this->connection->prepare($sentenceSQL);
        
        print($sentenceSQL);
        
        if ($stm->execute()) {
            if ($stm->rowCount() > 0) {
                $this->response["data"] = "";
                $this->generateRows($stm);
                $this->response["state"] = self::SUCCESS;
                $this->connection = null;
            }
            else {
                $this->response["state"] = self::NO_RESULTS;
                $this->response["message"] = $this->messages[self::SELECT];
            }
        }
        
        $this->response["data"] = utf8_encode($this->response["data"]);
        return json_encode($this->response);
    }
    
    private function generateRows($statement) {
        foreach ($statement->fetchAll() as $register) {
            $this->response["data"] .= "<tr>";
            foreach ($this->indexesOfTable as $index) {
                $this->response["data"] .= "<td>" . $register[$index] . "</td>";
            }
            $this->response["data"] .= "</tr>";
        }
    }
    
    
    
    

    /**
     * Inserta un nuevo registro en la tabla.
     */
    public function insert() {

    }
    
    /**
     * Edita un registro de la tabla.
     */
    public function update() {
        
    }
    
    /**
     * Elimina uno más regsitro de la tabla.
     */
    public function delete() {

    }

}
