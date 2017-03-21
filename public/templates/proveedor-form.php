<div class="form-wrapper">
    <h2 class="form-title"><?=$this->context["form_title"]?></h2>
    <form id="<?=$this->context["id_form"]?>" class="form" method="POST">
        <!-- Campo NIT -->
        <?php
        if (isset($this->response["nit"])) {
            print("<div class='messages-container'><span>". $this->response["nit"] . "</span></div>");
        }
        ?>
        <div><label for="id_nit"><b>NIT: </b></label></div>
        <div class="input-container">
            <input id="id_nit" name="nit" type="text" value="<?php if (isset($this->context["form"]["nit"])) {print($this->context["form"]["nit"]);} ?>" maxlength="13" required />
        </div>
        <!-- Campo Nombre -->
        <?php
        if (isset($this->response["nombre"])) {
            print("<div class='messages-container'><span>". $this->response["nombre"] . "</span></div>");
        }
        ?>
        <div><label for="id_nombre"><b>Nombre: </b></label></div>
        <div class="input-container">
            <input id="id_nombre" type="text" value="<?php if (isset($this->context["form"]["nombre"])) {print($this->context["form"]["nombre"]);} ?>" name="nombre" maxlength="40" required />
        </div>
        <!-- Campo País -->
        <?php
        if (isset($this->response["pais"])) {
            print("<div class='messages-container'><span>". $this->response["pais"] . "</span></div>");
        }
        ?>
        <div><label for="id_pais"><b>País: </b></label></div>
        <div class="input-container">
            <?php if (isset($this->context["form"]["pais"])) { print($this->context["form"]["pais"]); }?>
        </div>
        
        <!-- Campo Teléfono -->
        <?php
        if (isset($this->response["telefono"])) {
            print("<div class='messages-container'><span>". $this->response["telefono"] . "</span></div>");
        }
        ?>
        <div><label for="id_telefono"><b>Teléfono: </b></label></div>
        <div class="input-container">
            <input id="id_telefono" name="telefono" type="text" value="<?php if (isset($this->context["form"]["telefono"])) {print($this->context["form"]["telefono"]);} ?>" maxlength="10" required />
        </div>
        
        <!-- Campo Página Web -->
        <?php
        if (isset($this->response["web"])) {
            print("<div class='messages-container'><span>". $this->response["web"] . "</span></div>");
        }
        ?>
        <div><label for="id_web"><b>Página Web: </b></label></div>
        <div class="input-container">
            <input id="id_web" name="web" type="text" value="<?php if (isset($this->context["form"]["web"])) {print($this->context["form"]["web"]);} ?>" maxlength="80" required />
        </div>
        
        <div class="input-container">
            <input type="submit" value="<?=$this->context["submit_value"]?>" />
        </div>
    </form>
</div>

