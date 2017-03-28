<?php include TEMPLATES . "messages.php" ?>
<h2 class="title-main">Lista de Países</h2>
<table class="items-list col-wd-5 col-md-7 col-sm-10">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if ($this->context["object-list"]) {
               foreach ($this->context["object-list"] as $object) {
                   $url = URL . "admin/pais/" . $object->id . "/ver";
                   print("<tr>");
                   print("<td><a href='" . $url . "'>" . $object->id . "</a></td>");
                   print("<td>" . $object->nombre . "</td>");
                   print("</tr>");
               }
            }
        ?>
    </tbody>
</table>

