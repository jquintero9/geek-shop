<?php

namespace app\forms;

require_once FORMS . "Form.php";


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

        $this->messages = "nombre" => [
            "regex" => "El nombre no debe contener digítos.",
            "empty" => "¿Cúal es el nombre del Páis?",
            "length" => "Ingrese máximo 40 caracteres."
        ];

        $this->maxLength = ["nombre" => 40];

        $this->filters = [
            "nombre" => FILTER_SANITIZE_STRING,
        ];
    }
    
}
