<?php

namespace app\forms;

require_once FORMS . "Form.php";

use app\forms\Form;

/**
 * Description of FabricanteForm
 *
 * @author JHON
 */
class FabricanteForm extends Form {
    
    public function __construct($POST) {
        parent::__construct();
        $this->fields = $POST;
        $this->regex = ["nombre" => "/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/"];
        $this->infoFields = [
            "nombre" => [
                "messages" => [
                    "regex" => "El nombre debe contener solo caracteres alfabéticos",
                    "empty" => "¿Cúal es el nombre del <b>FABRICANTE</b>?",
                    "length" => "Ingrese máximo 30 caracteres."
                ],
                "max_length" => 30,
            ],
        ];
    }
    
}
