<?php

namespace app\core;



/**
 * Description of Model
 *
 * @author JHON
 */
abstract class Model {
    
    private static function connectDB() {
        require_once CORE . "Database.php";
        return new \Database();
    }
    
    public static function getAll($class) {
        
    }
    
    public static function getObject($className, $tableName, $pk) {
        /* Se crea una conexión con la base de datos. */
        $conn = self::connectDB();
        
        /* Se genera la consulta SQL */
        $SQL = "SELECT * FROM $tableName WHERE id=? LIMIT 1";
        
        /* Se prepara la consulta en un objeto de tipo statement*/
        $stm = $conn->prepare($SQL);
        
        /* Se asignan los parámetros a la consulta */
        $stm->bindValue(1, $pk);
        
        try {
            /* Se ejecuta la consulta */
            if ($stm->execute()) {
                /* Se cierra la conexión con la base de datos y 
                 * se liberan los datos de la memoria. */
                $conn = null;
                $stm->closeCursor();
                /* Se retorna el objeto con los datos obtenido por la consulta. */
                return self::createInstance($className, $stm->fetch());
            }
        }
        catch (\PDOException $ex) {
            print("El objeto no existe.");
        }
    }
    
    private static function createInstance($className, $args) {
        $instance = "app\\models\\" . $className;
        if (class_exists($instance)) {
            $modelInstance = new $instance;
            $modelInstance->setAttributes($args);
            return $modelInstance;
        }
    }
    
    protected abstract function setAttributes($args);
    
}
