<?php

namespace app\forms;

require_once FORMS . "Form.php";

use app\forms\Form;

/**
 * Description of PaisForm
 *
 * @author JHON
 */
class PaisForm extends Form {
    
    public function __construct($post) {
        parent::__construct();
        $this->fields = $post;
        $this->regex = ["nombre" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/"];
        
        $this->infoFields = [
            "nombre" => [
                "messages" => [
                    "regex" => "El nombre no debe contener digítos.",
                    "empty" => "¿Cúal es el nombre del Páis?",
                    "length" => "Ingrese máximo 40 caracteres."
                ],
                "max_length" => 40
            ]
        ];
    }
    
}
