<?php

class Main extends SessionController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $this->view->render('main/index', []);
    }

    public function signup()
    {
        error_log('entra al metodo');
        $this->view->render('main/signup', []);
        error_log('termina el metodo');
    }

    public function authenticate()
    {
        error_log('getPost ' . $this->getPost('username') . '  ' . $this->getPost('password'));
        if ($this->existPOST(['username', 'password'])) 
        {

            $username = $this->getPost('username');
            $password = $this->getPost('password');

            if(($username == '' || empty($username)) || ($password == '' || empty($password)))
            {
                error_log("vacio");
                $this->redirect('main',
                [
                    'error' => Errors::ERROR_LOGIN_AUTHENTICATE_EMPTY
                ]);
            }
            $user = new UserModel();
            $user->login($username, $password);
            $user->setRegisterLogin($user->getId());

            if ($user != NULL)
            {
                error_log('initialize');
                $this->initialize($user);
            }
            else
            {
                $this->redirect('main',
                [
                    'error' => Errors::ERROR_LOGIN_AUTHENTICATE_DATA
                ]);
            }
        }
        else
        {
            $this->redirect('main',
                [
                    'error' => Errors::ERROR_LOGIN_AUTHENTICATE
                ]);
        }
    }

    public function newUser()
    {
        if($this->existPOST(['username', 'password','completename']))
        {
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            $completeName = $this->getPost('completename');

            $user = new UserModel();

            $user->setUsername($username);
            $user->setSecretPassword($password, true);
            $user->setCompleteName($completeName);
            $user->setIdRole(2);
            
            if(($username == '' || empty($username)) || ($password == '' || empty($password)) || ($completeName == '' || empty($completeName)))
            {
                $this->redirect('main/signup',
                [
                    'error' => Errors::ERROR_SIGNUP_NEWUSER_EMPTY
                ]);
            }
            elseif ($user->exists($username))
            {
                $this->redirect('main/signup',
                [
                    'error' => Errors::ERROR_SIGNUP_NEWUSER_EXISTS
                ]);
            }
            elseif($user->save())
            {
                $this->redirect('',
                [
                    'success' => Success::SUCCESS_SIGNUP_NEWUSER
                ]);
            }
            else
            {
                $this->redirect('main/signup',
                [
                    'error' => Errors::ERROR_SIGNUP_NEWUSER
                ]);
            }
        }
        else
        {
            $this->redirect('signup/signup', 
            [
                'error' => Errors::ERROR_SIGNUP_NEWUSER_EXISTS
            ]);
        }
    }
}

?>