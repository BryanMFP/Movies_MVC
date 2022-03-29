<?php

class View
{
    public function __construct() 
    {
    }

    public function render($nombre, $data = [])
    {
        $this->d = $data;

        $this->handleMessages();

        error_log('view -> ' . 'views/' . $nombre . '.php');

        require 'views/' . $nombre . '.php';
    }

    private function handleMessages()
    {
        if (isset($_GET['success']) && isset($_GET['error'])) 
        {
            
        }
        elseif (isset($_GET['success'])) 
        {
            $this->handleSuccess();
        }
        elseif (isset($_GET['error'])) 
        {
            $this->handleError();
        }
    }

    private function handleSuccess()
    {
        $hash = $_GET['success'];
        $success = new Success();

        if ($success->existsKey($hash)) 
        {
            $this->d['success'] = $success->get($hash);
        }
    }

    private function handleError()
    {
        $hash = $_GET['error'];
        $error = new Errors();

        if ($error->existsKey($hash)) 
        {
            $this->d['error'] = $error->get($hash);
        }
    }

    public function showMessages()
    {
        $this->showErrors();
        $this->showSuccess();
    }

    public function showSuccess()
    {
        if (array_key_exists('success', $this->d)) 
        {
            echo '<div class="success">'.$this->d['success'].'</div>';
        }
    }

    public function showErrors()
    {
        if (array_key_exists('error', $this->d)) 
        {
            echo '<div class="error">'.$this->d['error'].'</div>';
        }
    }
}

?>