
<div class="message-container">
    <span><?php if($this->response) print($this->response->message) ?></span>
</div>
<form id="login-form" action="" method="POST">
    <div class="container-input">
        <label for="id_username"><b>Usuario:</b></label>
        <input id="id_username" type="text" name="username" value="<?php if($this->response) print($this->response->username) ?>" maxlength="30" required />
    </div>
     <div class="container-input">
        <label for="id_password"><b>Contraseña: </b></label>
        <input id="id_password" type="password" name="password" maxlength="16" required />
    </div>
    <div class="container-input">
        <input type="submit" value="Entrar" />
    </div>
</form>


