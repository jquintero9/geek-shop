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
            if ($this->response->state == \app\models\Model::SUCCESS) {
               print($this->response->data);
            } 
        ?>
    </tbody>
</table>

<?php 
if ($this->response->state == \app\models\Model::NO_RESULTS) {
    print ("<div><span>" . $this->response->message . "</span></div>");
}
