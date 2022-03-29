<?php

    date_default_timezone_set("America/Guayaquil");

    error_reporting(E_ALL);
    ini_set('ignore_repeated_errors', TRUE);
    ini_set('display_errors', FALSE);
    ini_set('log_errors', TRUE);
    ini_set("error_log", constant('URL') ."log/log_error_" . date('d-m-Y') . ".log");

    const URL      = "http://localhost/Php/Practica/Pruebas/Pelicula/";
    const HOST     = "localhost:3306";
    const DATABASE = "movies";
    const USER     = "root";
    const PASSWORD = "root";
    const CHARSET  = "utf8mb4";

    /*define('URL', 'http://localhost/Php/Practica/Codigos/Php/MVC/');
    define('HOST', 'localhost:3306');
    define('DATABASE', '');
    define('USER', 'root');
    define('PASSWORD', 'root');
    define('CHARSET', 'utf8mb4');*/

?>