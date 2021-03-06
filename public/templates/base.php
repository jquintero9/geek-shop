<!DOCTYPE html>
<html lang="es-co">
<head>
    <meta charset="UTF-8" /> 
    <title><?=$this->context["title"] ?></title>
    <link rel="stylesheet" href="<?=URL . "public/css/normalize.css"?>" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="<?=URL . "public/css/estilos.css" ?>" />
    
</head>
<body>
    <div id="container-page">
        <?php include TEMPLATES . "header.php" ?>
        <div id="content" class="row">
        <?php include TEMPLATES . $this->context["content"] ?>
        </div>
    </div>
    <!-- En este bloque se incluyen los archivos JS -->
    <?php if (isset($this->loginAJAX)) print($this->loginAJAX); ?>
</body>
</html>