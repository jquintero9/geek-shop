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
    const NO_RESULTS = 2;

    protected $tableName;
    protected $indexesOfTable;
    protected $editUrl;
    protected $deleteUrl;
    protected $detailUrl;
    protected $response;
    protected $messages;
    public $connection;
    
    protected $className;

    public function __construct() {
        $this->response = [];
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
        $stm = $this->connection->prepare($sentenceSQL);
        $stm->bindParam(":ID", $id);
        
        try {
            $this->executeGetObject($stm);
        } catch (\PDOException $e) {}
        
        $stm = null;
        $this->connection = null;
        
        return $this->response;
    }
    
    private function executeGetObject($stm) {
        if ($stm->execute()) {
            if ($stm->rowCount() > 0) {
                $this->response["state"] = self::SUCCESS;
                $this->response["object"] = $stm->fetchAll()[0];
            }
            else {
                $this->response["state"] = self::NO_RESULTS;
            }
        }
    }
    
    private function createObject($register) {
        try {
            $instance = "app\\models\\" . $this->className;
            $object = new $instance;
            
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
        } catch (\PDOException $e) {}
        
        $this->response["data"] = $this->response["data"];
        return $this->response;
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
     * consulta para mostrarlos en una tabla.
     * Se genera los botones de acciones eliminar y editar.
     * 
     * @param type $statement instancia de la consulta SQL.
     */
    private function generateRows($statement) {
        foreach ($statement->fetchAll() as $register) {
            $this->response["data"] .= "<tr>";
            
            foreach ($this->indexesOfTable as $index) {
                if ($index == "id") {
                    $detailUrl = str_replace("{id}", $register[$index], $this->detailUrl);
                    $this->response["data"] .= "<td><a href=" . $detailUrl . ">" . $register[$index] . "</a></td>";
                }
                else {
                    $this->response["data"] .= "<td>" . utf8_encode($register[$index]) . "</td>";
                }
            }   
            $this->response["data"] .= "</tr>";
        }
    }
    
    /**
     * Inserta un registro en la base de datos.
     * @param type $SQL consulta SQL de tipo INSERT INTO.
     * @param type $bindParams lista de valores que se deben reemplazar
     * en la consulta SQL.
     * @param type $POST son los datos que se van a insertar.
     * @return type json este objeto contiene información acerca del resultado
     * de la consulta.
     */
    public function insert($SQL, $bindParams, $POST) {
        //Se crea una conexión a la base de datos.
        $this->connectDB();
        $stm = $this->connection->prepare($SQL);
        //Se reemplazan los bindParam en la consulta SQL.
        foreach ($POST as $key => $value) {
            print("bind: ". $bindParams[$key] . " value: ". $value . "<br/>");
            $stm->bindValue($bindParams[$key], $value, \PDO::PARAM_STR);
        }

        $this->executeInsert($stm, $POST);
        try {
            //$this->executeInsert($stm, $POST);
        } catch (\PDOException $ex) {$ex->getTrace();}
        
        $stm = null;
        $this->connection = null;
        
        return $this->response;
    }
    
    public function in($SQL) {
        //Se crea una conexión a la base de datos.
        $this->connectDB();
        $stm = $this->connection->prepare($SQL);
        
        if ($stm->execute()) {
            $message = $this->messages[self::INSERT];

            $this->messages[self::INSERT] = str_replace(
                    "{objectName}", 
                    "prove",
                    $message);

            $this->response["state"] = self::SUCCESS;
            $_SESSION["message"] = $this->messages[self::INSERT];
        }
        
        try {
            //$this->executeInsert($stm, $POST);
        } catch (\PDOException $ex) {$ex->getTrace();}
        
        $stm->closeCursor();
        $this->connection = null;
        
        return $this->response;
    }
    
    public static function exists($pk, $tableName) {
        $exists = false;
        //Se crea una conexión a la base de datos.
        require_once CORE . "Database.php";
        $conn = new \Database();
        
        $SQL = "SELECT * FROM $tableName WHERE id=:PK";
        $stm = $conn->prepare($SQL);
        //Se reemplazan los bindParam en la consulta SQL.
        $stm->bindParam(":PK", $pk);
        
        $response = [];
        try {
            if ($stm->execute()) {
                if ($stm->rowCount() > 0) {
                    $response["state"] = self::SUCCESS;
                }
                else {
                    $response["state"] = self::NO_RESULTS;
                    $response["message"] = "La opción seleccionada no es válida.";
                }
            }
        
        }
        catch (\PDOException $e) {
            $response["state"] = self::NO_RESULTS;
            $response["message"] = "La opción seleccionada no es válida.";
        }
        
        
        $stm->closeCursor();
        $conn = null;
        
        return $response;
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
    public function update($SQL, $bindParams, $POST, $pk) {
        $this->connectDB();
        $stm = $this->connection->prepare($SQL);
        
        foreach ($POST as $key => $value) {
            $stm->bindParam($bindParams[$key], $value);
        }
        
        $stm->bindParam(":ID", $pk);
        print_r($stm);
        
        try {
            $this->executeUpdate($stm, $POST);
        } catch (\PDOException $ex) {}
        
        return $this->response;
    }
    
    private function executeUpdate($stm, $POST) {
        
        if ($stm->execute()) {
            
            $this->response["state"] = self::SUCCESS;
            $message = $this->messages[self::UPDATE];
            $this->messages[self::UPDATE] = str_replace(
                    "{objectName}",
                    $POST["nombre"],
                    $message
            );
            
            $_SESSION["message"] = $this->messages[self::UPDATE];
        }
    }
    
    /**
     * Elimina uno más regsitro de la tabla.
     */
    public function delete($pk) {
        $this->connectDB();
        $SQL = "DELETE FROM $this->tableName WHERE id=:ID";
        $stm = $this->connection->prepare($SQL);
        $stm->bindParam(":ID", $pk);
        
        try {
            $this->executeDelete($stm);
        } catch (\PDOException $ex) {}
        
        $stm = null;
        $this->connection = null;
        
        return $this->response;
    }
    
    private function executeDelete($stm) {
        if ($stm->execute()) {
                $this->response["state"] = self::SUCCESS;
                $_SESSION["message"] = $this->messages[self::DELETE];
            }
    }
    
    public function detail($pk) {
        $this->connectDB();
        $SQL = "SELECT * FROM $this->tableName WHERE id=:ID";
        $stm = $this->connection->prepare($SQL);
        $stm->bindParam(":ID", $pk);
        
        try {
            $this->executeDetail($stm);
        } catch (\PDOException $ex) {}
        
        $stm = null;
        $this->connection = null;
        
        return $this->response;
    }
    
    private function executeDetail($stm) {
        if ($stm->execute()) {
            if ($stm->rowCount() > 0) {
                $this->generateDetail($stm);
                $this->response["state"] = self::SUCCESS;
            }
            else {
                $this->response["state"] = self::NO_RESULTS;
            }
        }
    }
    
    private function generateDetail($stm) {
        $data = "";
        $register = $stm->fetchAll()[0];
        
        foreach ($this->indexesOfTable as $index) {
            $data .= "<div class='row-detail'>";
            $data .= "<div><span><b>" . strtoupper($index) . "</b></span></div>";
            $data .= "<div><span>" . utf8_encode($register[$index]) . "</span></div>";
            $data .= "</div>";
        }
        
        $urlEdit = str_replace("{id}", $register["id"], $this->editUrl);
        $urlDelete = str_replace("{id}", $register["id"], $this->deleteUrl);
        
        $data .= "<div class='row-detail'>";
        $data .= "<div><span><b>ACCIONES</b></span></div>";
        $data .= "<div><a href=" . $urlEdit . ">editar</a>";
        $data .= "<a href=" . $urlDelete . ">eliminar</a></div>";
        $data .= "</div>";
        
        $this->response["data"] = $data;
        //print_r($this->response["data"]);
    }
    
}
