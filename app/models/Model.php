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
    public $connection;
    
    protected $className;

    public function __construct() {
        $this->response = array();
    }
    
    /**
     * Crea una instancia de conexión a la base de datos.
     */
    public function connectDB() {
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
        
        $sentenceSQL = ($sql != null) ? $sql : "SELECT * FROM $this->tableName";
        
        $stm = $this->connection->prepare($sentenceSQL);
        
        try {
            $this->executeSelect($stm);
        } catch (\PDOException $e) {
            $this->response["state"] = self::ERROR;
            $this->response["message"] = "Ocurrio un error al ejecutar la consulta.";
        }
        
        $this->response["data"] = $this->response["data"];
        return json_encode($this->response);
    }
    
    /**
     * Ejecuta la consulta SELECT y verifica que halla obtenido resultados.
     * Genera la respuesta dependiendo del resultado obtenido en la consulta.
     * 
     * @param type $stm instancia de la consultad SQL.
     */
    private function executeSelect($stm) {
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
    }
    
    /**
     * Genera el código HTML que contiene los datos obtenidos en la
     * consulta.
     * 
     * @param type $statement instancia de la consulta SQL.
     */
    private function generateRows($statement) {
        foreach ($statement->fetchAll() as $register) {
            $this->response["data"] .= "<tr>";
            foreach ($this->indexesOfTable as $index) {
                $this->response["data"] .= "<td>" . utf8_encode($register[$index]) . "</td>";
            }
            $this->response["data"] .= "</tr>";
        }
    }
    
    /**
     * Inserta un registro en la base de datos.
     * 
     * @param type $SQL consulta SQL de tipo INSERT INTO.
     * @param type $binParams lista de valores que se deben reemplazar
     * en la consulta SQL.
     * @param type $POST son los datos que se van a insertar.
     * @return type json este objeto contiene información acerca del resultado
     * de la consulta.
     */
    public function insert($SQL, $binParams, $POST) {
        //Se crea una conexión a la base de datos.
        $this->connectDB();
        
        $stm = $this->connection->prepare($SQL);
        
        //Se reemplazan los bindParam en la consulta SQL.
        foreach ($POST as $key => $value) {
            $stm->bindParam($binParams[$key], $value);
        }
        
        try {
            $this->executeInsert($stm, $POST);
        } catch (\PDOException $ex) {
            $this->response["state"] = self::ERROR;
            $this->response["message"] = "Ocurrio un error al insertar el registro";
        }
        
        
        $stm = null;
        $this->connection = null;
        
        return json_encode($this->response);
    }
    
    /**
     * Ejecuta la consulta de tipo INSERT INTO.
     * 
     * @param type $stm instancia de la consulta SQL.
     * @param type $POST datos que serán registrados en la base de datos.
     */
    private function executeInsert($stm, $POST) {
        if ($stm->execute()) {
            $message = $this->messages[self::INSERT];

            $this->messages[self::INSERT] = str_replace(
                    "{objectName}", 
                    $POST["nombre"],
                    $message);

            $this->response["state"] = self::SUCCESS;
            $_SESSION["message"] = $this->messages[self::INSERT];
        }
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
