<?php

namespace app\models;

require_once CORE . "Connection.php";

use app\core\Connection;

/**
 * Description of LoginModel
 *
 * @author JHON
 */
class LoginModel {
    
    const SUCCESS = 1;
    const FAIL = 2;

    public static function login() {
        
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");

        $conn = new Connection();

        $result = $conn->query("SELECT * FROM usuario WHERE username='$username' AND password='$password'");

        if ($conn->rows($result) > 0) {
            $_SESSION['user'] = $username;
            $response = array("state" => self::SUCCESS);
        }
        else {
            $response = array(
                "state" => self::FAIL,
                "message" => "El nombre de usuario y/o contraseña no son válidos.",
                "username" => $username
            );
            
        }
        
        $conn->freeResults($result);
        $conn->close();
        
        return json_encode($response);
   
    }
    
}
