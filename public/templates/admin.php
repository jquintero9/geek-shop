<div class="left-menu">
    <nav>
        <ul>
            <li><a href="<?=URL_CATEGORIAS?>">Categorías</a></li>
            <li><a href="<?=URL_FABRICANTES?>">Fabricantes</a></li>
            <li><a href="<?=URL_PAISES?>">Países</a></li>
            <li><a href="<?=URL_PRODUCTOS?>">Productos</a></li>
            <li><a href="<?=URL_PROVEEDORES?>">Proveedores</a></li>
        </ul>
    </nav>
</div>
<div class="main">
    <?php include_once TEMPLATES . $this->context["action"]?>
</div>

