<?php

namespace app\forms;

require_once FORMS . "Form.php";

class LoginForm extends Form {

    public function __construct($POST) {
        parent::__construct($POST);

        $this->regex = [
            "username" => "/^[a-z0-9]+$/",
            "password" => "/^[a-z0-9]+$/"
        ];

        $this->messages = [
            "username" => [
                "regex" => "Username invalido.",
                "empty" => "¿Cúal es tu nombre de usuario?",
                "length" => "Ingrese máximo 30 caracteres"
            ],
            "password" => [
                "regex" => "Password no válido.",
                "empty" => "¿Cúal es tu contraseña?",
                "length" => "Ingrese máximo 16 caracteres"
            ]
        ];

        $this->maxLength = [
            "username" => 30,
            "password" => 16
        ];

        $this->filters = [
            "username" => FILTER_SANITIZE_STRING,
            "password" => FILTER_SANITIZE_STRING
        ];
    }

}