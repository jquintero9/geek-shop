<?php

namespace app\core;

/**
 * Description of Model
 *
 * @author JHON
 */

class ModelManager {

    const FK_TABLE_INDEX = "table";
    const PK_INDEX = "pk";
    const CLASS_NAME_FK = "class";

    private $className;
    private $tableName;
    private $sqlStatements;
    private $foreignKeys;
    
    private static $modelManager;
    
    private $connection;
    
    private function __construct($className = "", $tableName = "", $sqlStatements = null, $foreignKeys = null) {
        $this->className = $className;
        $this->tableName = $tableName;
        $this->foreignKeys = $foreignKeys;
        $this->sqlStatements = $sqlStatements;
    }
    
    public function __clone() { }
    
    public static function getInstance($className = "", $tableName = "", $sqlStatements = null,
                                        $foreignKeys = null) {
        if (is_null(self::$modelManager)) {
            self::$modelManager = new ModelManager($className, $tableName, $sqlStatements, $foreignKeys);
        }
        
        return self::$modelManager;
    }
    
    private function connectDB() {
        if (is_null($this->connection)) {
            require_once CORE . "Database.php";
            $this->connection = new \Database();
        }
    }
    
    /** Se cierra la conexión con la base de datos y 
     * se liberan los datos de la memoria. 
     */
    private function closeConnection($stm) {
        $this->connection = null;
        $stm->closeCursor();
    }
    
    /**
     * Prepara la sentencia SQL y asigna los bindValues.
     * @param type $SQL Consulta SQL
     * @param type $object Es el objeto sobre el cual se realizara la consulta.
     * @return Un objeto de tipo Statement.
     */
    private function prepareStatement($SQL, $object = null) {
        $stm = $this->connection->prepare($SQL);
        
        if ($object) {
            foreach (get_object_vars($object) as $attr => $value) {
                if ($value) {
                    $stm->bindValue($attr, $value);
                }
            }
        }
        
        return $stm;
    }
    
    public function saveObject($object) {
        
        $this->connectDB();
        
        $stm = $this->prepareStatement($this->sqlStatements[Model::SAVE],
                $object);
        
        try {
            if ($stm->execute()) {
                $_SESSION["message"] = "<br/>Se ha creado correctamente el registro <b>" . $object->nombre . "</b>";
            }
        } catch (\PDOException $ex) {
            $_SESSION["message"] = "<b>Error al GUARDAR el objeto ". $ex->getMessage() ." </b>";
        }
    }
    
    public function updateObject($object) {
        
        $this->connectDB();
        
        $stm = $this->prepareStatement($this->sqlStatements[Model::UPDATE], 
               $object);
        
        try {
            if ($stm->execute()) {
                $_SESSION["message"] = "<br/>Se ha actualizado correctamente el registro <b>" . $object->nombre . "</b>";
            }
        } catch (Exception $ex) {
            $_SESSION["message"] = "<b>Error al ACTUALIZAR el objeto ". $ex->getMessage() ." </b>";
        }
    }
    
    public function getAll() {
        /* Se crea una conexión con la base de datos. */
        $this->connectDB();
        
        /* Se genera la consulta SQL y 
         * Se prepara la consulta en un objeto de tipo statement */
        
        $stm = $this->prepareStatement($this->sqlStatements[Model::GET_ALL]);
        
        try {
            /*Se ejecuta la consulta y se genera la lista de objetos. */
            if ($stm->execute()) {
                $instances = $this->createAllObjects($stm);
            }
        }
        catch (\PDOException $ex) {
            $_SESSION["message"] = "Ocurrio un error al ejecutar la consulta " . $ex->getMessage();
        }
        
        $this->closeConnection($stm);
        
        return $instances;
    }
    
    private function createAllObjects($stm) {
        $objects = [];
        
        if ($stm->rowCount() > 0) {
            foreach ($stm->fetchAll() as $register) {
                $objects[] = $this->createInstance($this->className, $register);
            }
        }
        else {
            $_SESSION["message"] = "La tabla <b>" . strtoupper($this->tableName) . "<b/> está vacía.";
        }
        
        return $objects;
    }

    private function getForeignObject($fk) {
        $this->connectDB();

        $objects = [];

        foreach ($this->foreignKeys as $foreignKey => $array) {
            $SQL = "SELECT * FROM ". $array[self::FK_TABLE_INDEX] .
                "WHERE " . $array[self::PK_INDEX] . "=:id LIMIT 1";
            $stm = $this->connection->prepare($SQL);
            $stm->bindValue("id", $fk);

            try {
                if ($stm->excute()) {
                    $objects[] = $this->createInstance($array[self::CLASS_NAME_FK], $stm->fetch());
                }
            }
            catch (\PDOException $ex) {}
            $stm->closeCursor();
        }


    }
    
    public function getObject($pk) {
        /* Se crea una conexión con la base de datos. */
        $this->connectDB();
        
        /* Se prepara la consulta en un objeto de tipo statement*/
        $stm = $this->connection->prepare($this->sqlStatements[Model::GET]);
        
        /* Se asignan los parámetros a la consulta */
        $stm->bindValue("id", $pk);
        
        $instance = null;
        
        try {
            /* Se ejecuta la consulta */
            if ($stm->execute()) {
                /* Se retorna el objeto con los datos obtenido por la consulta. */
                if (\is_null($this->foreignKeys)) {
                    $instance =  $this->createInstance($this->className, $stm->fetch());
                }
                else {

                }
            }
        }
        catch (\PDOException $ex) {
            $_SESSION["message"] = "Ocurrio un error al ejecutar la consulta " . $ex->getMessage() . " " .
            $ex->getLine();
        }
        
        $this->closeConnection($stm);
        
        return $instance;
    }
    
    private function createInstance($className, $args) {
        if (class_exists($className)) {
            $modelInstance = new $className;
            $modelInstance->setAttributes($args);
         
            return $modelInstance;
        }
        else {
            $_SESSION["message"] = "La clase que está tratando de instanciar no existe.";
        }
    }

    public function exists($tableName, $pk) {
        $this->connectDB();
        $SQL = "SELECT * FROM $tableName WHERE id=?";
        $stm = $this->connection->prepare($SQL);
        $stm->bindValue(1, $pk);

        try {
            if ($stm->execute()) {
                return ($stm->rowCount > 0);
            }
        }
        catch (\PDOException $e) {
            $_SESSION["message"] = "Ocurrio un error al verificar la existencia del registro.";
        }
    }

    public function login($username, $password) {

        $this->connectDB();

        $sql = "SELECT * FROM usuarios WHERE username=? AND password=? LIMIT 1";

        $stm = $this->connection->prepare($sql);
        $stm->bindValue(1, $username);
        $stm->bindValue(2, $password);

        $response = [];

        if ($stm->execute()) {
            if ($stm->rowCount() > 0) {
                //$this->className =
                //$pk = $stm->fetch()["id"];
                //$usuario = $this->getObject($pk);
                $_SESSION['user'] = $username;
                $response = ["state" => "success"];
            }
            else {
                $response = [
                    "state" => "no_exists",
                    "message" => "El nombre de usuario y/o contraseña no son válidos.",
                ];
            }
        }

        $this->closeConnection($stm);

        return json_encode($response);
    }
    
}
