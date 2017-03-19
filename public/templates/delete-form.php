
<div class="form-wrapp">
    <?php 
    if (isset($this->response["state"])) {
        if ($this->response["state"] == \app\models\Model::ERROR) {
            print("<div class='message-container'><span>" . $this->response["message"] . "</span></div>");
        }
    }
    ?>
    <h2 class="title-form-delete"><?=$this->context["form_title"]?></h2>
    <form id="delete-form" class="form" action="" method="POST">
        <input type="submit" value="Si, Eliminar" />
        <a href="<?=$this->context["url_back"]?>">Cancelar</a>
    </form>
</div>
