<?php

namespace app\forms;

require_once FORMS . "Form.php";

/**
 * Description of ProveedorForm
 *
 * @author JHON
 */
class ProveedorForm extends Form {
    
    public function __construct($POST, $exclude = null) {
        parent::__construct();
        $this->fields = $POST;
        $this->exclude = $exclude;
        
        $this->regex = [
            "nit" => "/^[0-9][0-9][0-9].[0-9][0-9][0-9].[0-9][0-9][0-9]\-[0-9]$/",
            "nombre" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/",
            "pais" => "/^[0-9]+$/",
            "telefono" => "/^[0-9]+$/",
            "web" => "/^(https:\/\/|http:\/\/)?www.[a-z0-9]+.com$/",
        ];
        
        $this->infoFields = [
            "nit" => [
                "messages" => [
                    "regex" => "El formato del nit es incorrecto deber ser (xxx.xxx.xxx-y)",
                    "empty" => "¿Cúal es el NIT del proveedor?",
                    "length" => "Ingrese máximo 13 caracteres",
                ],
                "max_length" => 13,
            ],
            "nombre" => [
                "messages" => [
                    "regex" => "Ingrese solo caracteres alfabéticos",
                    "empty" => "¿Cúal es el nombre del proveedor?",
                    "length" => "Ingrese máximo 40 caracteres.",
                ],
                "max_length" => 40,
            ],
            "pais" => [
                "messages" => [
                    "regex" => "La opción seleccionada no es válida",
                    "empty" => "¿De donde es el proveedor?",
                    "length" => "",
                ],
                "max_length" => 0,
            ],
            "telefono" => [
                "messages" => [
                    "regex" => "Ingrese solo caracteres numéricos",
                    "empty" => "¿Cúal es el teléfono del proveedor?",
                    "length" => "Ingrese máximo 13 caracteres.",
                ],
                "max_length" => 13,
            ],
            "web" => [
                "messages" => [
                    "regex" => "La URL no es válida.",
                    "empty" => "¿Cúal es la página web del proveedor?",
                    "length" => "Ingrese máximo 80 caracteres.",
                ],
                "max_length" => 80,
            ],
        ];
    }
    
    
    
}
