<?php

namespace app\models;

require_once MODELS . "Model.php";

use app\models\Model;

/**
 * Esta clase representa el modelo de la tabla productos.
 *
 * @author JHON
 */
class ProductoModel extends Model {
    
    public $id;
    public $nombre;
    public $proveedor;
    public $fabricante;
    public $precioCompra;
    public $precio;
    public $stockMin;
    public $stock;
    public $categoria;
    public $fechaIngreso;

    const INDEXES = [
        "ID",
        "NOMBRE",
        "PROVEEDOR",
        "FABRICANTE",
        "PRECIO COMPRA",
        "PRECIO",
        "STOCK MIN",
        "STOCK",
        "CATEGORÍA",
        "FECHA INGRESO",
    ];
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "productos";
        $this->className = "ProductoModel";
        $this->indexesOfTable = [
            "id",
            "nombre",
            "proveedor",
            "fabricante",
            "precio_compra",
            "precio",
            "stock_min",
            "stock",
            "categoria",
            "fecha_ingreso"
        ];
        
        $this->messages = [
            Model::SELECT => "La lista de <b>PRODUCTOS</b> está vacía.",
        ];
    }
    
}
