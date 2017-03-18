<?php

namespace app\models;

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
        
        require_once CORE . "Database.php";
        
        $conn = new \Database();
        
        $sql = "SELECT * FROM usuario WHERE username=:USERNAME AND password=:PASSWORD";
        
        $stm = $conn->prepare($sql);
        $stm->bindParam(":USERNAME", $username);
        $stm->bindParam(":PASSWORD", $password);

        if ($stm->execute()) {
            if ($stm->rowCount() > 0) {
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
        }
        
        $conn = null;
        $stm = null;
        
        return json_encode($response);
   
    }
    
}
