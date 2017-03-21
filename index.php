<?php



session_start();



define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('URL', 'http://localhost/geek-shop/');
define('MODELS', ROOT . "app" . DS . "models" . DS);
define('CONTROLLERS', ROOT . "app" . DS . "controllers" . DS);
define('CORE', ROOT . "app" . DS . "core" . DS);
define('CSS', ROOT . 'public' . DS . "css" . DS);
define('JS', 'geek-shop/public/js/');
define('TEMPLATES', ROOT . 'public' . DS . 'templates' . DS);
define("FORMS", ROOT . "app" . DS . "forms" . DS);

define('URL_LOGIN', URL . "accounts/login");
define("URL_LOGOUT", URL . "accounts/logout");

//Urls menú que pertenecen al menú del administrador.
define("URL_CATEGORIAS", URL . "admin/categoria");
define("URL_FABRICANTES", URL . "admin/fabricante");
define("URL_PAISES", URL . "admin/pais");
define("URL_PRODUCTOS", URL . "admin/producto");
define("URL_PROVEEDORES", URL . "admin/proveedor");
define("URL_CREAR_PAIS", URL . "admin/pais/crear");
define("URL_CREAR_CATEGORIA", URL . "admin/categoria/crear");
define("URL_CREAR_FABRICANTE", URL . "admin/fabricante/crear");
define("URL_CREAR_PROVEEDOR", URL . "admin/proveedor/crear");
define("URL_CREAR_PRODUCTO", URL . "admin/producto/crear");

//require_once 'app/core/Request.php';
require_once MODELS . "Pais.php";


//use app\core\Request;
use app\models\Pais;

$pais = Pais::get(25);

$pais2 = Pais::get(4);
$paises = Pais::all();

$pais3 = new Pais("Colombia");
$pais3->save();
    //print("Se ha guardado con éxito el país <b>".$pais3->nombre."</b>");




print($pais);
print("<br/>");
print("</br>PAIS2: " . $pais2);

print("<br/>");

//$pais2->nombre = "Japón";
//$pais2->update();
print("<br/>");
print("</br>NUEVO PAIS2: " . $pais2);

foreach ($paises as $p) {
    print("<br/>");
    print($p);
}

if (isset($_SESSION["message"])) {
    print($_SESSION["message"]);
}

//$controller = Request::getController(filter_input(INPUT_GET, "url"));

//$controller->httpRequestProcess();
