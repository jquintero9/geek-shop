<div class="form-wrapper">
    <h2 class="form-title"><?=$this->context["form_title"]?></h2>
    <form id="<?=$this->context["id_form"]?>" class="form" method="POST">
        <?php
        if (isset($this->response["nombre"])) {
            print("<div class='messages-container'><span>". $this->response["nombre"] . "</span></div>");
        }
        ?>
        <div><label for="id_nombre"><b>Nombre: </b></label></div>
        <div class="input-container">
            <input id="id_nombre" type="text" value="<?php if (isset($this->context["form"])) {print($this->context["form"]["nombre"]);} ?>" name="nombre" maxlength="30" required />
        </div>
        <div class="input-container">
            <input type="submit" value="<?=$this->context["submit_value"]?>" />
        </div>
    </form>
</div>

