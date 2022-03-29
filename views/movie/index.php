<?php

$totalResult = $this->d['showTotalResult'];
$movies = $this->d['showMovie'];
$actualPage = $this->d['actualPage'];
$totalPage = $this->d['totalPage'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paginación</title>
    <link rel="stylesheet" href="<?= URL ?>public/css/main.css">
</head>
<body>
    <div id="container">
        <div class="menu">
            <li><a href="principal">Principal</a></li>
            <li><a href="movie">Movies</a></li>
            <li><a href="logout">Cerrar sesión</a></li>
        </div>
        <?= $this->showMessages(); ?>
        <?= $totalResult . " resultados totales <br/>"; ?>

        <div id="peliculas">
            <?php
                foreach ($movies as $movie)
                {
            ?>
            <div class="pelicula">
                <a href="<?= URL.'principal/seemovie/'. $movie->getName() ?>"><img src="<?= URL ?>public/img/poster/<?= $movie->getName() ?>.jpg" width="125px" height= "200px"></a>
                <p><?= str_replace('_', ' ', $movie->getName()) ?></p>
            </div>
            <?php
                }
            ?>
        </div>

        <div id="paginas">
            <ul>
                <?php
                    //$peliculas->mostrarPaginas();
                    for($i=0; $i < $totalPage; $i++)
                    {
                        if(($i + 1) == $actualPage)
                        {
                            $actual = ' class="actual" ';
                        }
                        else
                        {
                            $actual = '';
                        }
                        echo '<li><a ' .$actual . ' href="'. URL .'movie?page='. ($i + 1). '">' . ($i + 1) . '</a></li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>