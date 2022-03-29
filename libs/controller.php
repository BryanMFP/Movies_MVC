<?php

class Controller
{
    public function __construct() 
    {
        $this->view = new View();
    }

    public function loadModel($model)
    {
        $url = 'models/' . $model . 'model.php';

        if (file_exists($url)) 
        {
           require_once $url;

           $modelName = $model.'Model';
           $this->model = new $modelName();
        }
    }

    public function existPOST($params)
    {
        foreach ($params as $param) 
        {
            if (!isset($_POST[$param])) 
            {
                error_log('Controller::existPost => No existe el parametro ' . $param);
                return false;
            }
        }

        return true; 
    }

    public function existGET($params)
    {
        foreach ($params as $param) 
        {
            if (!isset($_GET[$param])) 
            {
                error_log('Controller::existGet => No existe el parametro ' . $param);
                return false;
            }
        }

        return true; 
    }

    public function getGet($name)
    {
        return $_GET[$name];
    }

    public function getPost($name)
    {
        return $_POST[$name];
    }

    public function redirect($route, $msgs)
    {
        $data = [];
        $params = '';

        foreach($msgs as $key => $msg)
        {
            array_push($data, $key . '=' . $msg);
        }
        $params = join('&', $data);

        if ($params != '') 
        {
            $params = '?' . $params;
        }

        header('Location: ' . URL . $route . $params);
    }
}


?>