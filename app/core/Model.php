<?php

namespace app\core;

/**
 *
 * @author JHON
 */
abstract class Model {
    
    /* Constantes para acceder al array de SQLStatements. */
    const GET = "get";
    const GET_ALL = "get_all";
    const SAVE = "save";
    const UPDATE = "update";
    const DELETE = "delete";
    
    public abstract static function get($pk);
    
    public abstract static function all();
    
    public abstract function save();
    
    public abstract function update();
    
    public abstract function delete();
    
}
