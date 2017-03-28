
<nav id="left-menu" class="col-wd-2 col-md-3 col-sm-12">
    <ul>
        <li><a href="<?=URL_CATEGORIAS?>">Categorías</a></li>
        <li><a href="<?=URL_FABRICANTES?>">Fabricantes</a></li>
        <li><a href="<?=URL_PAISES?>">Países</a></li>
        <li><a href="<?=URL_PRODUCTOS?>">Productos</a></li>
        <li><a href="<?=URL_PROVEEDORES?>">Proveedores</a></li>
        <li><a href="<?=URL_CREAR_PAIS?>">Crear País</a></li>
        <li><a href="<?=URL_CREAR_FABRICANTE?>">Crear Fabricante</a></li>
        <li><a href="<?=URL_CREAR_PROVEEDOR?>">Crear Proveedor</a></li>
    </ul>
</nav>
<section id="main" class="col-wd-10 col-md-9 col-sm-12">
    <?php include_once TEMPLATES . $this->context["action"]?>
</section>

