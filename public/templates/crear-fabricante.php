<div class="form-wrapper">
    <h2 class="form-title">Crear Fabricante</h2>
    <?php
    if (isset($this->response->state)) {
        if ($this->response->state == \app\models\Model::ERROR) {
            print("<div class='messages-container'><span>". $this->response->message . "</span></div>");
        }
    }
    ?>
    <form id="create-fabricante-form" class="form" method="POST">
        <?php
        //Se imprimen los mensajes de erroes del campo nombre.
        if (isset($this->response->nombre)) {
            print("<div class='messages-container'><span>". $this->response->nombre . "</span></div>");
        }
        ?>
        <div><label for="id_nombre"><b>Nombre: </b></label></div>
        <div class="input-container">
            <input id="id_nombre" type="text" name="nombre" maxlength="30" required />
        </div>
        <div class="input-container">
            <input type="submit" value="Crear" />
        </div>
    </form>
</div>

