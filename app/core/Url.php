<?php

namespace app\core;

/**
 * Esta clase contiene todas las urls de la aplicación.
 * Cada URL está referenciada con su respectivo controlador. Donde 
 * la clave es el nombre del controlador y el contenido el patrón de URL.
 *
 * Todas las URL de la aplicación deben etar registradas aquí.
 * 
 * @author JHON
 */
class Url {
    
    const URL_PATTERNS = [
        "Login" => "/accounts\/login$/",
        "Logout" => "/accounts\/logout$/",
        "Admin" => "/admin$/",
        "ListaCategoria" => "/admin\/categoria$/",
        "ListaFabricante" => "/admin\/fabricante$/",
        "ListaProveedor" => "/admin\/proveedor$/",
        "ListaProducto" => "/admin\/producto$/",
        "ListaPais" => "/admin\/pais$/",
        "CrearPais" => "/admin\/pais\/crear$/",
        "CrearFabricante" => "/admin\/fabricante\/crear$/",
        "EliminarPais" => "/admin\/pais\/(?P<id>[0-9]+)\/eliminar$/",
        "EditarPais" => "/admin\/pais\/(?P<id>[0-9]+)\/editar$/",
        "DetallePais" => "/admin\/pais\/(?P<id>[0-9]+)\/ver$/",
    ];
    
}
