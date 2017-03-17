<header>
    <h1>GEEK SHOP</h1>
    <nav>
        <ul>
           <?php 
            if(isset($_SESSION["user"])) {                
                print('<li><a href="' . URL_LOGOUT . '">Salir</a></li>');
            }
            else {
                print ('<li><a href="' . URL_LOGIN . '">Entrar</a></li>');
            }
            ?>
        </ul>
    </nav>
</header>

