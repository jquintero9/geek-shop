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

    protected $tableName;
    protected $indexesOfTable;
    protected $response;
    protected $messages;
    protected $connection;
    
    const SUCCESS = 1;
    const ERROR = 2;
    const NO_RESULTS = 3;

    public function __construct() {
        //$this->tableName = $tableName;
        //$this->indexesOfTable = $indexes;
        $this->response = array();
    }
    
    private function connectDB() {
        require_once CORE . "Database.php";
        $this->connection = new \Database();
    }
    
    /**
     * Selecciona uno o todos lo registros de una tabla.
     */
    public function select() {
        $this->connectDB();
        print("<br/>Nombre de la tabla: " . $this->tableName);
        $sentenceSQL = "SELECT * FROM $this->tableName";
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
