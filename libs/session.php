<?php

class Session
{
    private $sessionName = 'user';

    public function __construct() 
    {
        if (session_status() == PHP_SESSION_NONE) 
        {
            session_set_cookie_params(60*60*24*14);
            session_start();
        }
    }

    public function setCurrentUser($user)
    {
        error_log('setCurrentUser');
        $_SESSION[$this->sessionName] = $user;
    }

    public function getCurrentUser()
    {
        error_log('getCurrentUser');
        return $_SESSION[$this->sessionName];
    }

    public function closeSession()
    {
        session_unset();
        session_destroy();
    }

    public function existSession()
    {
        error_log('existSession 2');
        return isset($_SESSION[$this->sessionName]);
    }

}

?>