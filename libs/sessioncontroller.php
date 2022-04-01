<?php

require_once 'libs/session.php';
require_once "models/userModel.php";

class SessionController extends Controller
{
    private $usersession;
    private $username;
    private $userid;

    private $session;
    private $sites;

    private $user;

    public function __construct() 
    {
        error_log('construct');
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        error_log('init');
        $this->session = new Session();
        $this->user = new UserModel();

        $json = $this->getJSONFileConfig();

        $this->sites = $json['sites'];
        $this->defaultSites = $json['default-sites'];

        $this->validateSession();
    }

    public function getJSONFileConfig()
    {
        $string = file_get_contents('config/access.json');
        $json = json_decode($string, true);

        error_log('getjsonfileconfig');

        return $json;
    }

    public function validateSession()
    {
        error_log('SESSIONCONTROLLER::validateSession');

        if ($this->existsSession())
        {
            $role = $this->getUserSessionData()->getIdRole();

            error_log('role ' . $role);

            if ($this->isPublic()) 
            {
                error_log('entra ispublic');
                $this->redirectDefaultSiteByRole($role);
            }
            else
            {
                if ($this->isAuthorized($role)) 
                {
                    
                }
                else
                {
                    $this->redirectDefaultSiteByRole($role);
                }
            }
        }
        else
        {
            error_log('caso contrario existsSession');
            
            if ($this->isPublic()) 
            {
                error_log('entra a isPublic en caso contrario');
                //Lo dejo pasar
            }
            else
            {
                error_log('redireccion');
                header('location: ' . URL . '');
            }
        }
    }

    public function existsSession()
    {
        error_log('existsSession 1');
        if(!$this->session->existSession()) return false;
        if($this->session->getCurrentUser() == NULL) return false;

        $userid = $this->session->getCurrentUser();
        //$userid = 'user';

        error_log('userid: ' . $userid);

        if ($userid) return true;

        return false;
    }

    public function getUserSessionData()
    {
        $id = $this->session->getCurrentUser();

        error_log('SESSIONCONTROLLER::getUserSessionData -> ' . $id);

        return $this->user->get($id);
    }

    public function isPublic()
    {
        $currentURL = $this->getCurrentPage();
        $currentURL = preg_replace("/\?.*/", "", $currentURL);

        error_log('currentURL ' . $currentURL);

        for ($i=0; $i < sizeof($this->sites) ; $i++) 
        {

            if ($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['access'] == 'public') 
            {
                error_log('entrar al for, pasa condiciones');
                error_log('site: ' . $this->sites[$i]['site'] . ' access: ' . $this->sites[$i]['access']);
                return true;
            }
        }

        error_log('entrar al for, no pasa condiciones');
        return false;
    }

    public function getCurrentPage()
    {
        $actualLink = trim("$_SERVER[REQUEST_URI]");
        $url = explode('/', $actualLink);

        error_log('SESSIONCONTROLLER::GETCurrentPage -> ' . $url[5]);
        return $url[5];
    }

    private function redirectDefaultSiteByRole($role)
    {
        $url = '';
        for ($i=0; $i < sizeof($this->sites) ; $i++) 
        { 
            for ($j=0; $j < sizeof($this->sites[$i]['role']) ; $j++)
            { 
                if ($this->sites[$i]['role'][$j] == $role) 
                {
                    $url = $this->sites[$i]['site'];
                    break;
                }
            }
        }

        header('location: ' . URL . $url);

    }

    private function isAuthorized($role)
    {
        $currentURL = $this->getCurrentPage();
        $currentURL = preg_replace("/\?.*/", "", $currentURL);

        for ($i=0; $i < sizeof($this->sites) ; $i++) 
        {
            for ($j=0; $j < sizeof($this->sites[$i]['role']); $j++)
            { 
                if ($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['role'][$j] == $role) 
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function initialize($user)
    {
        $this->session->setCurrentUser($user->getId());
        error_log('id' . $user->getId());
        $this->authorizeAccess($user->getIdRole());
    }

    public function authorizeAccess($role)
    {
        switch ($role) 
        {
            case '2':
                $this->redirect($this->defaultSites['2'], []);
                break;
            case '1':
                $this->redirect($this->defaultSites['1'], []);
                break;
        }
    }

    public function logout()
    {
        $this->session->closesession();
    }

}

?>