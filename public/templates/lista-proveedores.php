<?php include TEMPLATES . "messages.php" ?>
<h2 class="title-main">Lista de Proveedores</h2>
<table class="items-list col-wd-5 col-md-7 col-sm-10">
    <thead>
    <tr>
        <th>ID</th>
        <th>NIT</th>
        <th>NOMBRE</th>
        <th>PAÍS</th>
        <th>TELÉFONO</th>
        <th>WEB</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($this->context["object-list"]) {
        foreach ($this->context["object-list"] as $object) {
            $url = URL . "admin/proveedor/" . $object->id . "/ver";
            print("<tr>");
            print("<td><a href='" . $url . "'>" . $object->id . "</a></td>");
            print("<td>" . $object->nit . "</td>");
            print("<td>" . $object->nombre . "</td>");
            print("<td>" . $object->pais->nombre . "</td>");
            print("<td>" . $object->telefono . "</td>");
            print("<td>" . $object->web . "</td>");
            print("</tr>");
        }
    }
    ?>
    </tbody>
</table>