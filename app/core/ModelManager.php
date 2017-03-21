<?php

namespace app\core;

/**
 * Description of Model
 *
 * @author JHON
 */

class ModelManager {
    
    private $className;
    private $tableName;
    private $sqlStatements;
    
    private $connection;
    
    public function __construct($className, $tableName, $sqlStatements) {
        $this->className = $className;
        $this->tableName = $tableName;
        $this->sqlStatements = $sqlStatements;
    }
    
    private function connectDB() {
        require_once CORE . "Database.php";
        $this->connection = new \Database();
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
     * @param type $bindValues Valores que serán reemplazados en la consulta.
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
                $objects[] = $this->createInstance($register);
            }
        }
        else {
            $_SESSION["message"] = "La tabla <b>" . $this->tableName . "<b/> está vacía.";
        }
        
        return $objects;
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
                $instance =  $this->createInstance($stm->fetch());
            }
        }
        catch (\PDOException $ex) {
            $_SESSION["message"] = "Ocurrio un error al ejecutar la consulta " . $ex->getMessage();
        }
        
        $this->closeConnection($stm);
        
        return $instance;
    }
    
    private function createInstance($args) {
        if (class_exists($this->className)) {
            $modelInstance = new $this->className;
            $modelInstance->setAttributes($args);
         
            return $modelInstance;
        }
        else {
            $_SESSION["message"] = "La clase que está tratando de instanciar no existe.";
        }
    }
    
}
