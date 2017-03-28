
<?php
if (isset($_SESSION["message"])) {
    print("<div class='messages-container'><span>" . $_SESSION["message"] . "</span></div>");
    unset($_SESSION["message"]);
}

