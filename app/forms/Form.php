<?php

namespace app\forms;

/**
 * Representa los formularios de cada uno de los modelos.
 * @regex Lista de expresiones regulares con las cuales se
 * validarán los campos del formulario.
 * 
 * @fields Lista con el contenido de cada uno de los campos que se
 * guardarán en la base de datos.
 * 
 * @infoFields Array asociativo que contiene la información que se debe
 * mostrar acerca de cada campo del formulario. Como los mensajes y la 
 * longitud máxima permitida para cada campo.
 * 
 * @response Es un objeto de tipo JSON el cual contiene la información del 
 * proceso de validación del formulario. Como los mensajes que se deben mostrar
 * sí el formulario se válido correctamente.
 * 
 * @isValid Define el estado del formulario una vez este ha sido procesado.
 * Si se proceso correctamente tomará un valor de TRUE y de lo contrario será
 * asignado un valor FALSE.
 *
 * @author JHON
 */
class Form {
    
    //Claves para acceder a la lista de mensajes.
    const MESSAGES = "messages";
    const REGEX = "regex";
    const VOID = "empty";
    const LENGTH = "length";

    const MAX_LENGTH = "max_length";

    public $regex;
    public $fields;
    public $infoFields;
    public $response;
    public $isValid;

    public function __construct() {
        $this->isValid = false;
    }
    
    /**
     * Procesa los datos recibidos en el formulario.
     * Verifica que cada campo no se encuetre vacío, que no supere el limite
     * máximo de caracteres permitidos y que cumpla con la expresión regular
     * que fue asignada.
     */
    public function processForm() {
        $this->response = [];
        foreach ($this->fields as $key => $value) {
            if ($this->checkLength($key, $value)) {
                $this->checkRegex($key, $value);
            }
        }
        print_r($this->response);
        if (count($this->response) == 0) {
            $this->isValid = true;
        }
    }
    
    /**
     * Verfica el dato recibido con la expresión regular.
     * 
     * @param type $key Nombre del campo
     * @param type $value Valor contenido en el campo.
     */
    private function checkRegex($key, $value) {
        if (!preg_match_all($this->regex[$key], $value)) {
            $this->response[$key] = $this->infoFields[$key][self::MESSAGES][self::REGEX];
        }
    }
    
    /**
     * Verifica que el dato contenido en el campo no supere el limite
     * máximo de caracteres permitidos.
     * 
     * @param type $key Nombre del campo
     * @param type $value Valor contenido en el campo.
     * @return boolean Si el contenido del campo no es vacío y no supera el
     * limite de caracteres entoces retornará TRUE, de los contrario 
     * retornará FALSE.
     */
    private function checkLength($key, $value) {
        $len= strlen($value);
        $isValid = true;

        if ($len == 0) {
            $this->response[$key] = $this->infoFields[$key][self::MESSAGES][self::VOID];
            $isValid = false;
        }
        elseif ($len > $this->infoFields[$key][self::MAX_LENGTH]) {
            $this->response[$key] = $this->infoFields[$key][self::MESSAGES][self::LENGTH];
            $isValid = false;
        }

        return $isValid;
    }
    
    public function getResponse() {
        return $this->response;
    }

}
