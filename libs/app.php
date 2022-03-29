<?php

require_once 'controllers/errores.php';

class App{

    public function __construct() 
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        //

        if (empty($url[0])) 
        {
            error_log('APP::construct->no hay controlador especificado ');
            $archivoController = 'controllers/main.php';
            require_once $archivoController;
            error_log('controler');
            $controller = new Main();
            $controller->loadModel('main');
            $controller->render();
            error_log('despues de render');
            return false;
        }
    
        $archivoController = 'controllers/'. $url[0] . '.php';

        error_log('url 0 -> '. $url[0]);

        if (file_exists($archivoController)) 
        {
            require_once $archivoController;

            $controller = new $url[0];
            $controller->loadModel($url[0]);

            if (isset($url[1])) 
            {
                // error_log('url 1 -> '. $url[1]);
                if (method_exists($controller, $url[1])) 
                {
                    if (isset($url[2])) 
                    {
                        // error_log('url 2 -> '. $url[2]);
                        //Nº de parametros
                        $nparam = count($url) - 2;
                        $params = [];

                        for ($i=0; $i < $nparam; $i++) 
                        { 
                            array_push($params, $url[$i + 2]);
                        }
                        $controller->{$url[1]}($params);
                    }
                    else 
                    {
                        error_log('No tiene parametros, se manda a llamar el metodo ' . $url[1]);
                        //No tiene parametros, se manda a llamar el metodo
                        $controller->{$url[1]}();
                        error_log('despues de render');
                    }
                }
                else
                {
                    //Error, no existe el metodo
                    $controller = new Errores();
                }
            }
            else 
            {
                //metodo por defecto
                $controller->render();
            }
        }
        else
        {
            $controller = new Errores();
        }
    }
}

?>