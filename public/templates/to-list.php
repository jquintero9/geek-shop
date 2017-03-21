<?php
if (isset($_SESSION["message"])) {
    print("<div class='messages-container'><span>" . $_SESSION["message"] . "</span></div>");
    unset($_SESSION["message"]);
}
?>
<table>
    <thead>
        <tr>
            <?php 
            foreach ($this->indexes as $index) {
                print("<th>" . ucfirst($index) . "</th>");
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php 
            if ($this->response["state"] == \app\models\Model::SUCCESS) {
               print(utf8_decode($this->response["data"]));
            } 
        ?>
    </tbody>
</table>

<?php 
if ($this->response["state"] == \app\models\Model::NO_RESULTS) {
    print ("<div><span>" . $this->response->message . "</span></div>");
}
