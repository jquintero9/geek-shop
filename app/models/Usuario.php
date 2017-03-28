<?php

namespace app\models;

require_once CORE . "Model.php";

use app\core\Model;


class Usuario extends Model {

    const TABLE_NAME = "Usuarios";

    const SQL_STATEMENTS = [
        Model::GET => "SELECT * FROM " . self::TABLE_NAME . " WHERE persona=?",
    ];


    public static function get($pk) {

    }

    public static function all() {

    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function save() {

    }

    public function delete() {

    }



}