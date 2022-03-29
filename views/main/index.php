<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main</title>
    <link rel="stylesheet" href="<?= URL ?>public/css/main.css">
</head>

<body>
    <div id="container">
        <?= $this->showMessages(); ?>
        <form class="box" action="<?= URL ?>main/authenticate" method="post">
            <h1>Login</h1>
            <input type="text" name="username" placeholder="Usuario">
            <input type="password" name="password" placeholder="Contraseña">
            <input type="submit" value="Ingresar">
            <div>
                <a href="<?= URL ?>main/signup">Sign-Up</a>
            </div>
        </form>
    </div>

</body>

</html>