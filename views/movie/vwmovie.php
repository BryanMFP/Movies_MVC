<?php

    $id          = $this->d['id'];
    $name        = $this->d['name'];
    $image       = $this->d['image'];
    $views       = $this->d['totalViews'];
    $viewsByUser = $this->d['totalViewsByUser'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= $this->showMessages(); ?>
    <div class="pelicula">
        <video src="<?= URL ?>public/img/movie/<?= $name ?>.mp4" controls></video>
        <p><?= str_replace('_', ' ', $name) ?></p>
    </div>
</body>
</html>