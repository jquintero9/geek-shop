<?php

session_start();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('URL', 'http://localhost/geek-shop/');
define('MODELS', ROOT . "app" . DS . "models" . DS);
define('CONTROLLERS', ROOT . "app" . DS . "controllers" . DS);
define('CORE', ROOT . "app" . DS . "core" . DS);
define('HTML', ROOT . "public" . DS . "html" . DS);
define('CSS', ROOT . 'public' . DS . "css" . DS);
define('TEMPLATES', ROOT . 'public' . DS . 'templates' . DS);
define('URL_LOGIN', URL . "accounts/login");
define("URL_LOGOUT", URL . "accounts/logout");

//Urls menú que pertenecen al menú del administrador.
define("URL_CATEGORIAS", URL . "admin/categoria");
define("URL_FABRICANTES", URL . "admin/fabricante");
define("URL_PAISES", URL . "admin/pais");
define("URL_PRODUCTOS", URL . "admin/producto");
define("URL_PROVEEDORES", URL . "admin/proveedor");

require_once 'app/core/Request.php';

use app\core\Request;

$controller = Request::getController(filter_input(INPUT_GET, "url"));

$controller->httpRequestProcess();

