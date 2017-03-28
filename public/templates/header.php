<header id="header">
    <div id="header-container" class="row">
        <div id="logo-header" class="col-wd-3 col-md-5 col-sm-9">
            <h1>GEEK SHOP</h1>
            <div><span>Administrador</span></div>
        </div>
        
        <nav id="header-menu" class="col-wd-9 col-md-7 col-sm-3">
            <ul>
                <!---->
               <?php 
                if(isset($_SESSION["user"])) {
                    print('<li><a class="button-header" href="' . URL_ADMIN . '">Home</a></li>');
                    print('<li><a class="button-header" href="' . URL_LOGOUT . '">Salir</a></li>');
                }
                
                /*else {
                    print ('<li><a class="button-header" href="' . URL_LOGIN . '">Entrar</a></li>');
                }*/
                ?>
            </ul>
        </nav>
    </div>
</header>

