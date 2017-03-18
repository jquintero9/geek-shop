<?php

namespace app\controllers;

require_once CONTROLLERS . "Controller.php";
require_once MODELS . "ProductoModel.php";

use app\controllers\Controller;
use app\models\ProductoModel;

/**
 * Este controlador se encarga de mostrar la lista de todos los productos
 * disponibles.
 *
 * @author JHON
 */
class ListaProductoController extends Controller {
    
    public function __construct() {
        parent::__construct("Lista de Productos");
        $this->templateName = "admin.php";
        $this->context["action"] = "to-list.php";
        $this->indexes = ProductoModel::INDEXES;
    }
    
    protected function get() {
        $productoModel = new ProductoModel();
        $sql = "SELECT prod.id, prod.nombre, prov.nombre AS proveedor, fab.nombre AS fabricante, 
                prod.precio_compra, prod.precio, prod.stock_min, prod.stock, catg.nombre AS categoria,
                prod.fecha_ingreso
                FROM productos AS prod
                    INNER JOIN proveedores AS prov
                    ON prov.id = prod.proveedor
                    INNER JOIN fabricantes AS fab
                    ON fab.id = prod.fabricante
                    INNER JOIN categorias AS catg
                    ON catg.id = prod.categoria;";
        
        $this->response = json_decode($productoModel->select($sql));
        $this->render();
    }
    
    protected function post() {}
    
}
