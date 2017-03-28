<?php include TEMPLATES . "messages.php" ?>
<h2 class="title-main">Productos</h2>
<table class="items-list col-wd-10 col-md-11 col-sm-12">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>PRECIO COMPRA</th>
            <th>PRECIO</th>
            <th>STOCK MIN</th>
            <th>STOCK</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            /*if ($this->context["object-list"]) {
               foreach ($this->context["object-list"] as $object) {
                   $url = URL . "admin/producto/" . $object->id . "/ver";
                   print("<tr>");
                   print("<td><a href='" . $url . "'>" . $object->id . "</a></td>");
                   print("<td>" . $object->nombre . "</td>");
                   print("</tr>");
               }
            }
             * */
             
        ?>
    </tbody>
</table>

