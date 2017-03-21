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
    private function prepareStatement($SQL, $bindValues = null) {
        $stm = $this->connection->prepare($SQL);
        
        if ($bindValues) {
            
            foreach ($bindValues as $key => $value) {
                $stm->bindValue($key, $value);
            }
        }
        
        return $stm;
    }
    
    private function generateBindValues($object) {
        $bindValues = [];
        $cont = 1;
        foreach (get_object_vars($object) as $attr => $value) {
            $bindValues[$cont] = $value;
            $cont += 1;
        }
        
        return $bindValues;
    }
    
    public function saveObject($object) {
        $ok = false;
        
        $this->connectDB();
        
        $stm = $this->prepareStatement($this->sqlStatements[Model::SAVE], 
                $this->generateBindValues($object));
        
        try {
            if ($stm->execute()) {
                $ok = true;
                print("ok");
            }
        } catch (\PDOException $ex) {
            print("Error al guardar el objeto.");
        }
        
        return $ok;  
    }
    
    public function getAll() {
        /* Se crea una conexión con la base de datos. */
        $this->connectDB();
        
        /* Se genera la consulta SQL y 
         * Se prepara la consulta en un objeto de tipo statement */
        //$stm = $this->prepareStatement("SELECT * FROM $this->tableName");
        $stm = $this->prepareStatement($this->sqlStatements[Model::GET_ALL]);
        
        try {
            /*Se ejecuta la consulta y se genera la lista de objetos. */
            if ($stm->execute()) {
                $instances = $this->createAllObjects($stm);
            }
        }
        catch (\PDOException $ex) {
            print("El objeto no existe.");
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
        
        return $objects;
    }
    
    public function getObject($pk) {
        /* Se crea una conexión con la base de datos. */
        $this->connectDB();
        
        /* Se genera la consulta SQL */
        //$SQL = "SELECT * FROM $this->tableName WHERE id=? LIMIT 1";
        
        /* Se prepara la consulta en un objeto de tipo statement*/
        $stm = $this->connection->prepare($this->sqlStatements[Model::GET]);
        
        /* Se asignan los parámetros a la consulta */
        $stm->bindValue(1, $pk);
        
        $instance = null;
        
        try {
            /* Se ejecuta la consulta */
            if ($stm->execute()) {
                
                /* Se retorna el objeto con los datos obtenido por la consulta. */
                $instance =  $this->createInstance($stm->fetch());
            }
        }
        catch (\PDOException $ex) {
            print("El objeto no existe.");
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
    }
    
}
