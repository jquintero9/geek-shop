<?php 
    if($this->response) {
        print(
            '<div class="messages col-wd-4 col-md-8 col-sm-11">
                <span>' . $this->response->message . '</span>
            </div>'
        );
    }
    else {
        print(
            '<div class="messages col-wd-4 col-md-8 col-sm-11" style="display: none;"></div>'
        );
    }
?>

<!-- col-wd-4 col-md-8 col-sm-9 -->

<div id="login-container" class="form-wrapper">
    <h2 class="form-title">Login</h2>
    <form id="login-form" action="" method="POST">
    <div class="container-input">
        <?php
            if (isset($this->context["error"]["username"])) {
                print('<div id="username-message" class="message-input" style="display: block;">'. $this->context["error"]["username"] .'</div>');
            }
            else {
                print('<div id="username-message" class="message-input"></div>');
            }
        ?>
        <label class="form-label" for="id_username"><b>Usuario:</b></label>
        <input id="id_username" class="input" type="text" name="username" value="<?php if(isset($this->context["form"])) { print($this->context["form"]["username"]); } ?>" maxlength="30" required />
    </div>
     <div class="container-input">
         <?php
             if (isset($this->context["error"]["password"])) {
                 print('<div id="password-message" class="message-input" style="display: block;">'. $this->context["error"]["password"] .'</div>');
             }
             else {
                 print('<div id="password-message" class="message-input"></div>');
             }
         ?>
         <div id="password-message" class="message-input"></div>
        <label class="form-label" for="id_password"><b>Contraseña: </b></label>
        <input id="id_password" class="input" type="password" name="password" maxlength="16" required />
    </div>
    <div class="container-input">
        <div id="submit-message" class="message-input"></div>
        <button id="submit-button" class="input active" type="submit">Entrar</button>
    </div>
</form>
</div>




